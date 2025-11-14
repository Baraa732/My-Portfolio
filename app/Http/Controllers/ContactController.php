<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fix the errors below',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'messageContent' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'received_at' => now()->format('F j, Y \a\t g:i A')
            ];

            // Send email to yourself
            Mail::send('emails.contact', $data, function ($message) use ($data) {
                $message->to('baraaalrifaee732@gmail.com')
                    ->subject('New Contact Form Message: ' . $data['subject'])
                    ->replyTo($data['email'], $data['name']);
            });

            // Optional: Send auto-reply to the user
            Mail::send('emails.auto-reply', $data, function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject('Thank you for contacting Baraa Al-Rifaee')
                    ->from('baraaalrifaee732@gmail.com', 'Baraa Al-Rifaee');
            });

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been sent successfully. I will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.'
            ], 500);
        }
    }

    public function testEmail(){
        return view('emails.auto-reply')
        ->with('name', 'user')
        ->with('messageContent', 'some content here');
    }
}
