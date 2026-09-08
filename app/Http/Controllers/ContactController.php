<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Setting;

class ContactController extends Controller
{
    /**
     * Handle contact & quote enquiry form submission.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'product_category' => 'nullable|string|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $enquiry = new Enquiry();
        $enquiry->name = $validated['name'];
        $enquiry->email = $validated['email'];
        $enquiry->phone = $validated['phone'] ?? null;
        $enquiry->company = $validated['company'] ?? null;
        $enquiry->product_category = $validated['product_category'] ?? $request->get('category', null);
        $enquiry->subject = $validated['subject'] ?? 'Product Enquiry / Quote Request';
        $enquiry->message = $validated['message'];
        $enquiry->status = 'new';
        $enquiry->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your enquiry has been submitted. Our technical sales team will review it and respond shortly.'
            ]);
        }

        return redirect()->back()->with('success', 'Thank you! Your enquiry has been submitted successfully. We will get back to you shortly.');
    }
}
