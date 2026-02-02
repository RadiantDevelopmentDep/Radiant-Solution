<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceQuery;

class ServiceQueryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
            'service_slug' => 'required|string',
            'service_category' => 'required|string',
        ]);

        ServiceQuery::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Query submitted successfully'
        ], 201);
    }
}
