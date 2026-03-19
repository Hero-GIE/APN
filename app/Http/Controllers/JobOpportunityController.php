<?php

namespace App\Http\Controllers;

use App\Models\JobOpportunity;
use Illuminate\Http\Request;

class JobOpportunityController extends Controller
{
    public function index(Request $request)
    {
        $query = JobOpportunity::where('is_published', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by job type
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        // Filter by experience level
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }

        $jobs = $query->orderBy('posted_date', 'desc')->paginate(5);

        $categories = JobOpportunity::where('is_published', true)
                                   ->select('category')
                                   ->distinct()
                                   ->pluck('category');

        $jobTypes = JobOpportunity::where('is_published', true)
                                 ->select('job_type')
                                 ->distinct()
                                 ->pluck('job_type');

        return view('member.jobs.index', compact('jobs', 'categories', 'jobTypes'));
    }

    public function show($slug)
    {
        $job = JobOpportunity::where('slug', $slug)
                            ->where('is_published', true)
                            ->firstOrFail();

        $similarJobs = JobOpportunity::where('is_published', true)
                                    ->where('id', '!=', $job->id)
                                    ->where('category', $job->category)
                                    ->orderBy('posted_date', 'desc')
                                    ->take(3)
                                    ->get();

        return view('member.jobs.show', compact('job', 'similarJobs'));
    }
}