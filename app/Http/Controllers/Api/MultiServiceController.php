<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MultiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Log;  
// Humne yahan naya mailer class use kiya hai
use App\Mail\MultiServiceInquiryMail; 

class MultiServiceController extends Controller
{
    /**
     * Store multi-service inquiry and send email notification.
     */
    public function store(Request $request)
    {
        // 1. Validation Logic
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'services' => 'required|array|min:1',
            'message' => 'required|string',
        ]);

        try {
            // 2. Database mein save karein
            $query = MultiService::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'services' => $data['services'], // Model casting handles JSON conversion
                'message'  => $data['message'],
            ]);

            if ($query) {
                // 3. Email Sending Logic
                try {
                    Mail::to('services@radiantsolutionsrs.com')
                        ->send(new MultiServiceInquiryMail($data));
                } catch (\Exception $e) {
                    // Mail fail ho toh log karein, lekin user ko success response hi dein
                    Log::error("Mail Sending Failed for MultiService: " . $e->getMessage());
                }

                return response()->json([
                    'status' => true, 
                    'message' => 'Inquiry saved and notification sent!',
                    'data' => $query
                ], 201);
            }

        } catch (\Exception $e) {
            Log::error("Database Error in MultiService: " . $e->getMessage());
            
            return response()->json([
                'status' => false, 
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => false, 
            'message' => 'Failed to process request.'
        ], 500);
    }
}