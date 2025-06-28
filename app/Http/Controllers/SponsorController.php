<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\WebsiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SponsorController extends Controller
{
    /**
     * Register a new sponsor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|max:2048', // Made optional
            'url' => 'nullable|url|max:255',
            'payment_method' => 'required|string|max:50',
            'payment_amount' => 'required|string|max:50',
            'payment_transaction_id' => 'nullable|string|max:255',
            'payment_screenshot' => 'required|image|max:2048', // Max 2MB
        ]);

        // Handle logo upload directly to public folder (if provided)
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_' . Str::random(10) . '.' . $logoFile->getClientOriginalExtension();
            $logoDirectory = 'images/sponsors/logos';
            
            // Create directory if it doesn't exist
            if (!File::exists(public_path($logoDirectory))) {
                File::makeDirectory(public_path($logoDirectory), 0755, true);
            }
            
            $logoFile->move(public_path($logoDirectory), $logoName);
            $logoPath = $logoDirectory . '/' . $logoName;
        }

        // Handle payment screenshot upload directly to public folder
        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotFile = $request->file('payment_screenshot');
            $screenshotName = time() . '_' . Str::random(10) . '.' . $screenshotFile->getClientOriginalExtension();
            $screenshotDirectory = 'images/sponsors/payments';
            
            // Create directory if it doesn't exist
            if (!File::exists(public_path($screenshotDirectory))) {
                File::makeDirectory(public_path($screenshotDirectory), 0755, true);
            }
            
            $screenshotFile->move(public_path($screenshotDirectory), $screenshotName);
            $screenshotPath = $screenshotDirectory . '/' . $screenshotName;
        }

        // Create new sponsor with inactive status
        $sponsor = Sponsor::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'logo' => $logoPath,
            'url' => $request->url,
            'payment_method' => $request->payment_method,
            'payment_amount' => $request->payment_amount,
            'payment_transaction_id' => $request->payment_transaction_id,
            'payment_screenshot' => $screenshotPath,
            'payment_status' => 'pending',
            'status' => 'inactive',
            'order' => 0, // Default order
        ]);

        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your application! We will review it and contact you soon.',
                'sponsor' => $sponsor
            ]);
        }

        // For regular form submissions
        return redirect()->route('home')->with('success', 'Thank you for your application! We will review it and contact you soon.');
    }

    /**
     * Get payment information based on payment method
     *
     * @param  string  $method
     * @return \Illuminate\Http\Response
     */
    public function getPaymentInfo($method)
    {
        $paymentInfo = [];
        
        switch($method) {
            case 'bKash':
                $paymentInfo = [
                    'number' => WebsiteContent::where('key', 'payment.bKash.number')->where('is_active', true)->value('content') ?? '01712345678',
                    'type' => WebsiteContent::where('key', 'payment.bKash.type')->where('is_active', true)->value('content') ?? 'Personal'
                ];
                break;
            
            case 'Nagad':
                $paymentInfo = [
                    'number' => WebsiteContent::where('key', 'payment.Nagad.number')->where('is_active', true)->value('content') ?? '01812345678',
                    'type' => WebsiteContent::where('key', 'payment.Nagad.type')->where('is_active', true)->value('content') ?? 'Personal'
                ];
                break;
                
            case 'Rocket':
                $paymentInfo = [
                    'number' => WebsiteContent::where('key', 'payment.Rocket.number')->where('is_active', true)->value('content') ?? '01912345678',
                    'type' => WebsiteContent::where('key', 'payment.Rocket.type')->where('is_active', true)->value('content') ?? 'Personal'
                ];
                break;
                
            case 'Bank_Transfer':
                $bankDetails = WebsiteContent::where('key', 'payment.Bank_Transfer.details')->where('is_active', true)->value('content');
                $paymentInfo = $bankDetails ? json_decode($bankDetails, true) : [
                    'bank_name' => 'Dutch-Bangla Bank Limited',
                    'account_name' => 'One2One4 Blood Donation',
                    'account_number' => '123456789012',
                    'branch' => 'Dhanmondi Branch'
                ];
                break;
                
            default:
                $paymentInfo = [
                    'message' => 'Please select a payment method to see payment details.'
                ];
        }
        
        return response()->json($paymentInfo);
    }
}
