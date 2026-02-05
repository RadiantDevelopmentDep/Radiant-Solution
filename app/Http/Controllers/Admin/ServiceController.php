<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MultiService; 
use App\Models\ServiceQuery;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
   
    public function inquiries(Request $request)
{
    $status = $request->status;
    $date = $request->date;

    $stats = [
        'total'     => ServiceQuery::count() + MultiService::count(),
        'pending'   => ServiceQuery::where('status', 'pending')->count() + MultiService::where('status', 'pending')->count(),
        'working'   => ServiceQuery::where('status', 'in_progress')->count() + MultiService::where('status', 'working')->count(),
        'completed' => ServiceQuery::where('status', 'completed')->count() + MultiService::where('status', 'finished')->count(),
    ];

    // 2. Base Queries
    $serviceBase = ServiceQuery::query();
    $multiBase = MultiService::query();

    if ($request->filled('status')) {
        if ($status == 'in_progress') {
            $serviceBase->where('status', 'in_progress');
            $multiBase->where('status', 'working'); 
        } elseif ($status == 'completed') {
            $serviceBase->where('status', 'completed');
            $multiBase->where('status', 'finished'); 
        } else {
            $serviceBase->where('status', $status);
            $multiBase->where('status', $status);
        }
    }

    if ($request->filled('date')) {
        $serviceBase->whereDate('created_at', $date);
        $multiBase->whereDate('created_at', $date);
    }

    
    $serviceInquiries = (clone $serviceBase)->where('service_slug', '!=', 'contact-us')->latest()->get();

    $contactInquiries = (clone $serviceBase)->where('service_slug', 'contact-us')->latest()->get();

    $multiMessages = $multiBase->latest()->get();

    return view('admin.service', compact('serviceInquiries', 'multiMessages', 'contactInquiries', 'stats'));
}
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $inquiry = ServiceQuery::findOrFail($id);
        $inquiry->status = $request->status;
        $inquiry->save();

        return back()->with('success', 'Status updated successfully!');
    }

public function updateMultiStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,working,finished'
    ]);

    $multi = MultiService::findOrFail($id);
    $multi->status = $request->status;
    $multi->save();

    return back()->with('success', 'Multi-service status updated!');
}


}