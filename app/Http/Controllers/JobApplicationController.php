<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class JobApplicationController extends Controller
{
    public function create($slug)
    {
        try {
            $job = JobOpportunity::where('slug', $slug)
                                ->where('is_published', true)
                                ->firstOrFail();

            $hasApplied = $job->hasApplied(Auth::guard('donor')->id());

            return view('member.jobs.apply', compact('job', 'hasApplied'));
        } catch (\Exception $e) {
            Log::error('Error loading job application form: ' . $e->getMessage());
            return redirect()->route('member.jobs.index')
                           ->with('error', 'Unable to load job application. Please try again.');
        }
    }

    public function store(Request $request, $slug)
    {
        try {
            DB::beginTransaction();

            $job = JobOpportunity::where('slug', $slug)
                                ->where('is_published', true)
                                ->firstOrFail();

            // Check if already applied
            if ($job->hasApplied(Auth::guard('donor')->id())) {
                return redirect()->route('member.jobs.show', $job->slug)
                               ->with('error', 'You have already applied for this position.');
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'cover_letter' => 'nullable|string|max:5000',
                'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Increased to 5MB
                'notes' => 'nullable|string|max:1000'
            ], [
                'cover_letter.max' => 'Cover letter cannot exceed 5000 characters. You have used :max characters.',
                'resume.max' => 'Resume file size cannot exceed 5MB.',
                'resume.mimes' => 'Resume must be a PDF, DOC, or DOCX file.',
                'notes.max' => 'Notes cannot exceed 1000 characters.'
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                               ->withErrors($validator)
                               ->withInput();
            }

            // Prepare application data
            $applicationData = [
                'job_id' => $job->id,
                'donor_id' => Auth::guard('donor')->id(),
                'status' => 'pending',
                'cover_letter' => $request->cover_letter,
                'notes' => $request->notes,
                'applied_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ];

            // Handle resume upload
            if ($request->hasFile('resume') && $request->file('resume')->isValid()) {
                $file = $request->file('resume');
                $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $path = $file->storeAs('resumes', $fileName, 'public');
                $applicationData['resume_path'] = $path;
                
                Log::info('Resume uploaded', [
                    'job_id' => $job->id,
                    'donor_id' => Auth::guard('donor')->id(),
                    'file_name' => $fileName,
                    'path' => $path
                ]);
            }

            // Create the application
            $application = JobApplication::create($applicationData);

            DB::commit();

            // Send notifications in background (optional - can be queued)
            $this->sendNotifications($application, $job);

            // Log the successful application
            Log::info('Job application submitted', [
                'application_id' => $application->id,
                'job_id' => $job->id,
                'job_title' => $job->title,
                'donor_id' => Auth::guard('donor')->id(),
                'donor_name' => Auth::guard('donor')->user()->firstname . ' ' . Auth::guard('donor')->user()->lastname
            ]);

            return redirect()->route('member.jobs.show', $job->slug)
                           ->with('success', 'Your application has been submitted successfully! We will notify you once there\'s an update.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            // Check if it's the cover letter length error
            if (str_contains($e->getMessage(), 'Data too long for column')) {
                Log::error('Cover letter too long: ' . $e->getMessage());
                return redirect()->back()
                               ->withErrors(['cover_letter' => 'Your cover letter is too long. Please keep it under 5000 characters.'])
                               ->withInput();
            }
            
            Log::error('Database error submitting job application: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'There was a technical problem submitting your application. Our team has been notified.')
                           ->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error submitting job application: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()
                           ->with('error', 'There was a problem submitting your application. Please try again or contact support.')
                           ->withInput();
        }
    }

    /**
     * Send notifications for job application
     */
   private function sendNotifications($application, $job)
{
    try {
        // Send email notification to admin with more details
        if (function_exists('messageAdmin')) {
            messageAdmin([
                'title' => '📝 New Job Application',
                'message' => "A new application has been submitted for: {$job->title} at {$job->company}",
                'user_info' => "Applicant: " . Auth::guard('donor')->user()->firstname . ' ' . 
                              Auth::guard('donor')->user()->lastname . " (" . Auth::guard('donor')->user()->email . ")",
                'time' => now()->format('d M Y, h:i A'),
                'type' => 'job_application',
                'details' => [
                    'job_title' => $job->title,
                    'company' => $job->company,
                    'location' => $job->location,
                    'job_type' => $job->job_type,
                    'application_id' => $application->id,
                    'has_cover_letter' => !empty($application->cover_letter),
                    'has_resume' => !empty($application->resume_path),
                    'applicant_phone' => Auth::guard('donor')->user()->phone ?? 'Not provided'
                ],
                'action_url' => route('admin.job-applications.show', $application->id),
                'subject' => "New Job Application: {$job->title} at {$job->company}"
            ]);
        }

        // Send confirmation email to applicant
        if (function_exists('sendEmail')) {
            sendEmail(
                'emails.job-application-confirmation',
                [
                    'applicant' => Auth::guard('donor')->user(),
                    'job' => $job,
                    'application' => $application,
                    'submission_date' => now()->format('F j, Y')
                ],
                Auth::guard('donor')->user()->email,
                'Application Received - ' . $job->title
            );
        }
        
    } catch (\Exception $e) {
        Log::error('Failed to send notifications for job application: ' . $e->getMessage());
    }
}

    public function myApplications()
    {
        try {
            $applications = JobApplication::with('job')
                                         ->where('donor_id', Auth::guard('donor')->id())
                                         ->orderBy('created_at', 'desc')
                                         ->paginate(10);
            
            // Add status badges
            $applications->getCollection()->transform(function ($application) {
                $application->status_badge = $this->getStatusBadge($application->status);
                return $application;
            });

            return view('member.jobs.my-applications', compact('applications'));
            
        } catch (\Exception $e) {
            Log::error('Error loading my applications: ' . $e->getMessage());
            return view('member.jobs.my-applications', ['applications' => collect([])])
                   ->with('error', 'Unable to load your applications. Please try again later.');
        }
    }

    /**
     * Get status badge class for application status
     */
    private function getStatusBadge($status)
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'reviewing' => 'bg-blue-100 text-blue-800',
            'shortlisted' => 'bg-green-100 text-green-800',
            'interview' => 'bg-purple-100 text-purple-800',
            'rejected' => 'bg-red-100 text-red-800',
            'hired' => 'bg-emerald-100 text-emerald-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * View a specific application
     */
    public function show($id)
    {
        try {
            $application = JobApplication::with('job')
                                        ->where('donor_id', Auth::guard('donor')->id())
                                        ->where('id', $id)
                                        ->firstOrFail();
            
            return view('member.jobs.application-details', compact('application'));
            
        } catch (\Exception $e) {
            Log::error('Error viewing application: ' . $e->getMessage());
            return redirect()->route('member.jobs.applications')
                           ->with('error', 'Application not found.');
        }
    }

    /**
     * Withdraw an application
     */
    public function withdraw($id)
    {
        try {
            DB::beginTransaction();
            
            $application = JobApplication::where('id', $id)
                                        ->where('donor_id', Auth::guard('donor')->id())
                                        ->where('status', 'pending')
                                        ->firstOrFail();
            
            $application->update(['status' => 'withdrawn']);
            
            DB::commit();
            
            Log::info('Job application withdrawn', [
                'application_id' => $application->id,
                'donor_id' => Auth::guard('donor')->id()
            ]);
            
            return redirect()->route('member.jobs.applications')
                           ->with('success', 'Your application has been withdrawn successfully.');
                           
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error withdrawing application: ' . $e->getMessage());
            
            return redirect()->back()
                           ->with('error', 'Unable to withdraw application. Please try again.');
        }
    }
}