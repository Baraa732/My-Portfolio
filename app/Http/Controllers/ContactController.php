<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use App\Notifications\NewContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Services\ActivityLogger;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Enhanced validation with security rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s\-\'\.À-ſ]+$/u',
            'email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'subject' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-_.,!?()]+$/',
            'message' => 'required|string|min:10|max:2000'
        ], [
            'name.regex' => 'Name contains invalid characters.',
            'email.regex' => 'Please enter a valid email address.',
            'subject.regex' => 'Subject contains invalid characters.',
        ]);
        
        // Check for suspicious patterns
        $suspiciousPatterns = [
            '/(<script[^>]*>.*?<\/script>)/is',
            '/(javascript:|vbscript:|onload=|onerror=)/i',
            '/(union|select|insert|update|delete|drop|create|alter)/i',
            '/(<iframe|<object|<embed|<link|<meta)/i'
        ];
        
        $inputFields = ['name', 'email', 'subject', 'message'];
        foreach ($inputFields as $field) {
            $value = $request->input($field, '');
            foreach ($suspiciousPatterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    \Log::warning('Suspicious input detected in contact form', [
                        'field' => $field,
                        'value' => $value,
                        'ip' => $request->ip(),
                        'user_agent' => $request->userAgent()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid content detected. Please remove any HTML or script tags.',
                        'errors' => [$field => ['Invalid content detected.']]
                    ], 422);
                }
            }
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please fix the errors below',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Sanitize input data
            $sanitizedData = [
                'name' => htmlspecialchars(strip_tags($request->input('name')), ENT_QUOTES, 'UTF-8'),
                'email' => filter_var($request->input('email'), FILTER_SANITIZE_EMAIL),
                'subject' => htmlspecialchars(strip_tags($request->input('subject')), ENT_QUOTES, 'UTF-8'),
                'message' => htmlspecialchars(strip_tags($request->input('message')), ENT_QUOTES, 'UTF-8'),
                'ip_address' => $request->ip(),
                'user_agent' => htmlspecialchars($request->userAgent(), ENT_QUOTES, 'UTF-8'),
                'is_read' => false,
                'is_reply' => false
            ];
            
            // Additional email validation
            if (!filter_var($sanitizedData['email'], FILTER_VALIDATE_EMAIL)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email address format.',
                    'errors' => ['email' => ['Invalid email address format.']]
                ], 422);
            }
            
            // Save to messages table
            $message = Message::create($sanitizedData);
            
            ActivityLogger::log('message_received', "New message from {$request->name}: {$request->subject}", $message);

            // Send notification to admin users
            try {
                $adminUsers = User::where('is_admin', true)->get();
                if ($adminUsers->isNotEmpty()) {
                    Notification::send($adminUsers, new NewContactMessage($message));
                }
            } catch (\Exception $notificationError) {
                Log::error('Notification error: ' . $notificationError->getMessage());
                // Don't fail the entire request if notifications fail
            }

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
            try {
                Mail::send('emails.contact', $data, function ($message) use ($data) {
                    $message->to('baraaalrifaee732@gmail.com')
                        ->subject('New Contact Form Message: ' . $data['subject'])
                        ->replyTo($data['email'], $data['name']);
                });
                Log::info('Admin notification email sent successfully');
            } catch (\Exception $emailError) {
                Log::error('Admin email failed: ' . $emailError->getMessage());
                // Continue with the request even if admin email fails
            }

            // Send auto-reply to the user
            try {
                Mail::send('emails.auto-reply', $data, function ($message) use ($data) {
                    $message->to($data['email'])
                        ->subject('Thank you for contacting Baraa Al-Rifaee')
                        ->from('baraaalrifaee732@gmail.com', 'Baraa Al-Rifaee');
                });
                Log::info('Auto-reply email sent successfully');
            } catch (\Exception $autoReplyError) {
                Log::error('Auto-reply email failed: ' . $autoReplyError->getMessage());
                // Continue with the request even if auto-reply fails
            }

            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your message has been sent successfully. I will get back to you soon.'
            ]);
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            Log::error('Contact form stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error sending your message. Please try again later.'
            ], 500);
        }
    }

    public function testEmail()
    {
        return view('emails.auto-reply')
            ->with('name', 'user')
            ->with('messageContent', 'some content here');
    }
}
