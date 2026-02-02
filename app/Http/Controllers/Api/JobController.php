<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Job_application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    // React par Active Jobs dikhane ke liye
    public function index()
    {
        $jobs = Career::where('is_active', true)->latest()->get();
        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }

    // Form Submit (Application) handle karne ke liye
    public function apply(Request $request)
    {
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
            // CV File ko Storage mein save karna
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $path = $file->store('resumes', 'public'); // storage/app/public/resumes mein jayegi
            }

            // Database mein data save karna
            Job_application::create([
                'career_id'       => $request->career_id,
                'applicant_name'  => $request->applicant_name,
                'applicant_email' => $request->applicant_email,
                'resume_path'     => $path,
                'cover_letter'    => $request->cover_letter,
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