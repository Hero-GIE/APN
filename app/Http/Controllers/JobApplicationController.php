<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobApplicationController extends Controller
{
    public function create($slug)
    {
        $job = JobOpportunity::where('slug', $slug)
                            ->where('is_published', true)
                            ->firstOrFail();

        // Check if already applied
        $hasApplied = $job->hasApplied(Auth::guard('donor')->id());

        return view('member.jobs.apply', compact('job', 'hasApplied'));
    }

    public function store(Request $request, $slug)
    {
        $job = JobOpportunity::where('slug', $slug)
                            ->where('is_published', true)
                            ->firstOrFail();

        // Check if already applied
        if ($job->hasApplied(Auth::guard('donor')->id())) {
            return redirect()->route('member.jobs.show', $job->slug)
                           ->with('error', 'You have already applied for this position.');
        }

        $validator = Validator::make($request->all(), [
            'cover_letter' => 'nullable|string|max:5000',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $applicationData = [
            'job_id' => $job->id,
            'donor_id' => Auth::guard('donor')->id(),
            'status' => 'pending',
            'cover_letter' => $request->cover_letter,
            'notes' => $request->notes,
            'applied_at' => now()
        ];

        // Handle resume upload
        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $applicationData['resume_path'] = $path;
        }

        $application = JobApplication::create($applicationData);

        // Send email notification to admin 
        if (function_exists('messageAdmin')) {
            messageAdmin([
                'title' => 'New Job Application',
                'message' => "{$job->title} at {$job->company}",
                'user_info' => Auth::guard('donor')->user()->firstname . ' ' . 
                              Auth::guard('donor')->user()->lastname,
                'time' => now()->format('d M Y, h:i A')
            ]);
        }

        // Send confirmation email to applicant
        if (function_exists('sendEmail')) {
            sendEmail(
                'emails.job-application-confirmation',
                [
                    'applicant' => Auth::guard('donor')->user(),
                    'job' => $job,
                    'application' => $application
                ],
                Auth::guard('donor')->user()->email,
                'Application Received - ' . $job->title
            );
        }

        return redirect()->route('member.jobs.show', $job->slug)
                       ->with('success', 'Your application has been submitted successfully!');
    }

    public function myApplications()
    {
        $applications = JobApplication::with('job')
                                     ->where('donor_id', Auth::guard('donor')->id())
                                     ->orderBy('created_at', 'desc')
                                     ->paginate(10);

        return view('member.jobs.my-applications', compact('applications'));
    }
}