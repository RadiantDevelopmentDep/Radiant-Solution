<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Job_application;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// Yahan apne Mail classes import karein (Jo hum aglay step mein banayenge)
// use App\Mail\JobOnboardMail;
// use App\Mail\JobRejectedMail;

class JobAdminController extends Controller
{
    // --- JOBS MANAGEMENT ---

    public function index()
    {    
        $applications = Job_application::with('career')->latest()->get();
        $jobs = Career::with('applications')->withCount('applications')->latest()->get();
        return view('admin.job', compact('jobs','applications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string',
            'description' => 'required',
        ]);

        Career::create([
            'title' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job Posted!');
    }

    public function destroy(Career $job)
    {
        $job->delete();
        return redirect()->back()->with('success', 'Job Deleted!');
    }

    // --- NEW: STATUS UPDATE & MAIL LOGIC ---

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,onboard,rejected'
        ]);

        $application = Job_application::with('career')->findOrFail($id);
        $application->status = $request->status;
        $application->save();

        // --- EMAIL LOGIC ---
        try {
            if ($request->status === 'onboard') {
                // Mail::to($application->applicant_email)->send(new JobOnboardMail($application));
            } 
            elseif ($request->status === 'rejected') {
                // Mail::to($application->applicant_email)->send(new JobRejectedMail($application));
            }
        } catch (\Exception $e) {
            // Mail fail ho toh error log ho jaye magar page crash na ho
            Log::error("Mail Sending Failed: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status updated to ' . ucfirst($request->status));
    }

    public function destroyApplication($id)
    {
        Job_application::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Application Removed!');
    }
}