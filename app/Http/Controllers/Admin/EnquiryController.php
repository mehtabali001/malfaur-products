<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;

class EnquiryController extends Controller
{
    /**
     * Display a listing of customer enquiries.
     */
    public function index(Request $request)
    {
        $query = Enquiry::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('company', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        $enquiries = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $statusCounts = [
            'all' => Enquiry::count(),
            'new' => Enquiry::where('status', 'new')->count(),
            'in_progress' => Enquiry::where('status', 'in_progress')->count(),
            'replied' => Enquiry::where('status', 'replied')->count(),
        ];

        return view('admin.enquiries.index', compact('enquiries', 'statusCounts'));
    }

    /**
     * Display the specified enquiry.
     */
    public function show($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        
        // Auto mark as in_progress if still new
        if ($enquiry->status === 'new') {
            $enquiry->status = 'in_progress';
            $enquiry->save();
        }

        return view('admin.enquiries.show', compact('enquiry'));
    }

    /**
     * Update enquiry status & admin notes.
     */
    public function update(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);

        $request->validate([
            'status' => 'required|in:new,in_progress,replied,archived',
            'admin_notes' => 'nullable|string'
        ]);

        $enquiry->status = $request->status;
        $enquiry->admin_notes = $request->admin_notes;
        $enquiry->save();

        return redirect()->route('admin.enquiries.show', $enquiry->id)->with('success', 'Enquiry status updated successfully.');
    }

    /**
     * Remove the specified enquiry.
     */
    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
