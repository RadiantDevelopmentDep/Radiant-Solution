<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceQuery;
class ServiceController extends Controller
{
public function inquiries(Request $request)
{
    $query = ServiceQuery::query();

    // Stats calculations
    $stats = [
        'total' => ServiceQuery::count(),
        'pending' => ServiceQuery::where('status', 'pending')->count(),
        'working' => ServiceQuery::where('status', 'in_progress')->count(),
        'completed' => ServiceQuery::where('status', 'completed')->count(),
    ];

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('date')) {
        $query->whereDate('created_at', $request->date);
    }

    $messages = $query->orderBy('created_at', 'desc')->get();

    return view('admin.service', compact('messages', 'stats'));
}
public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $inquiry = ServiceQuery::findOrFail($id);
        $inquiry->status = $request->status;
        $inquiry->save();

        return back()->with('success', 'Status updated successfully to ' . ucfirst(str_replace('_', ' ', $request->status)));
    }
}