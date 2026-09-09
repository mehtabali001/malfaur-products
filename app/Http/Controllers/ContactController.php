<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
            'product_name' => 'nullable|string|max:255',
            'product_category' => 'nullable|string|max:255',
            'quantity' => 'nullable|string|max:100',
            'lead_time' => 'nullable|string|max:100',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $productName = $validated['product_name'] ?? $request->input('product', null);
        $productCategory = $validated['product_category'] ?? $request->input('category', null);
        $quantity = $validated['quantity'] ?? null;
        $leadTime = $validated['lead_time'] ?? null;

        // Determine clear subject
        $subject = $validated['subject'] ?? null;
        if (empty($subject)) {
            $subject = $productName ? "Quote Request: {$productName}" : "Product Enquiry / Quote Request";
        }

        // Format message with structured metadata if provided
        $extraMeta = [];
        if ($productName) {
            $extraMeta[] = "Product: {$productName}";
        }
        if ($quantity) {
            $extraMeta[] = "Requested Quantity: {$quantity}";
        }
        if ($leadTime) {
            $extraMeta[] = "Required Lead Time: {$leadTime}";
        }

        $formattedMessage = $validated['message'];
        if (count($extraMeta) > 0 && !str_contains($formattedMessage, "Requested Quantity:")) {
            $formattedMessage = implode(" | ", $extraMeta) . "\n\n" . $formattedMessage;
        }

        // Create and save enquiry to database (stored for admin panel site)
        $enquiry = new Enquiry();
        $enquiry->name = $validated['name'];
        $enquiry->email = $validated['email'];
        $enquiry->phone = $validated['phone'] ?? null;
        $enquiry->company = $validated['company'] ?? null;
        $enquiry->product_category = $productCategory;
        $enquiry->subject = $subject;
        $enquiry->message = $formattedMessage;
        $enquiry->status = 'new';
        $enquiry->save();

        // Send support email notification
        try {
            $recipientEmail = Setting::get('contact_email', 'enquiries@malfaurengineering.co.uk');
            $siteName = Setting::get('site_name', 'Malfaur Engineering Products');

            Mail::send('emails.enquiry-notification', [
                'enquiry' => $enquiry,
                'productName' => $productName,
                'siteName' => $siteName
            ], function ($mail) use ($recipientEmail, $enquiry, $siteName) {
                $mail->to($recipientEmail)
                     ->replyTo($enquiry->email, $enquiry->name)
                     ->subject("[{$siteName}] " . ($enquiry->subject ?: 'New Product Quote Request'));
            });
        } catch (\Exception $e) {
            Log::error('Quote enquiry email notification error: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your quote request has been submitted successfully. Our technical engineering sales team will review your specifications and respond shortly.',
                'enquiry_id' => $enquiry->id
            ]);
        }

        return redirect()->back()->with('success', 'Thank you! Your enquiry has been submitted successfully. We will get back to you shortly.');
    }
}
