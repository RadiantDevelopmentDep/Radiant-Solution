<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Job_application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Career::where('is_active', true)->latest()->get();
        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

   public function apply(Request $request)
    {
        // 1. Check for duplicate application for the same job
        $exists = Job_application::where('career_id', $request->career_id)
            ->where('applicant_email', $request->applicant_email)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You have already applied for this position with this email address.'
            ], 400); // 400 Bad Request
        }

        // 2. Standard Validation
        $validator = Validator::make($request->all(), [
            'career_id'       => 'required|exists:careers,id',
            'applicant_name'  => 'required|string|max:255',
            'applicant_email' => 'required|email',
            'resume'          => 'required|mimes:pdf,doc,docx|max:2048', 
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $path = null;
            if ($request->hasFile('resume')) {
                $path = $request->file('resume')->store('resumes', 'public');
            }

            Job_application::create([
                'career_id'       => $request->career_id,
                'applicant_name'  => $request->applicant_name,
                'applicant_email' => $request->applicant_email,
                'resume_path'     => $path,
                'cover_letter'    => $request->cover_letter ?? 'Submitted via Web Portal',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}