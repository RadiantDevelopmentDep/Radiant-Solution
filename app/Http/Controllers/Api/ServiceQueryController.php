<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ServiceInquiryMail;
use Illuminate\Http\Request;
use App\Models\ServiceQuery;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Mail;

class ServiceQueryController extends Controller
{
public function store(Request $request)
{
    
    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'message' => 'required|string',
        'service_slug' => 'required|string',
        'service_category' => 'required|string',
    ]);

    $query = ServiceQuery::create($data);

    if ($query) {
        try {
            $targetEmail = ($request->service_category === 'sales') 
                ? 'sales@radiantsolutionsrs.com' 
                : 'services@radiantsolutionsrs.com';

            Mail::to($targetEmail)->send(new ServiceInquiryMail($data));
        } catch (\Exception $e) {
            Log::error("Mail Error: " . $e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'Saved in DB and Processed!',
            'db_id' => $query->id 
        ], 201);
    }

    return response()->json(['status' => false, 'message' => 'Failed to save'], 500);
}
}