<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #730c0e 0%, #480415 100%); color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 5px 5px; }
        .field { margin-bottom: 15px; }
        .field-label { font-weight: bold; color: #730c0e; }
        .message-box { background: white; padding: 15px; border-left: 4px solid #730c0e; margin: 15px 0; }
        .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Form Message</h1>
            <p>From Your Portfolio Website</p>
        </div>
        
        <div class="content">
            <div class="field">
                <span class="field-label">Name:</span>
                <span>{{ $name }}</span>
            </div>
            
            <div class="field">
                <span class="field-label">Email:</span>
                <span>{{ $email }}</span>
            </div>
            
            <div class="field">
                <span class="field-label">Subject:</span>
                <span>{{ $subject }}</span>
            </div>
            
            <div class="field">
                <span class="field-label">Message:</span>
                <div class="message-box">
                    {{ nl2br(e($messageContent)) }}
                </div>
            </div>
            
            <div class="field">
                <span class="field-label">Received:</span>
                <span>{{ $received_at }}</span>
            </div>
            
            <div class="field">
                <span class="field-label">IP Address:</span>
                <span>{{ $ip_address }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>This message was sent from your portfolio website contact form.</p>
        </div>
    </div>
</body>
</html>
