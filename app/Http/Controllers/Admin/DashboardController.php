<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceQuery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
// DashboardController.php
public function index()
{
    $stats = [
        'total'   => \App\Models\ServiceQuery::count(),
        'pending' => \App\Models\ServiceQuery::where('status', 'pending')->count(),
        'working' => \App\Models\ServiceQuery::where('status', 'in_progress')->count(),
    ];

    return view('dashboard', compact('stats'));
}
}