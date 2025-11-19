<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Reply to Your Message</title>
   <style>
      body {
         font-family: Arial, sans-serif;
         line-height: 1.6;
         color: #333;
      }

      .container {
         max-width: 600px;
         margin: 0 auto;
         padding: 20px;
      }

      .header {
         background: linear-gradient(135deg, #730c0e 0%, #480415 100%);
         color: white;
         padding: 20px;
         text-align: center;
      }

      .content {
         background: #f9f9f9;
         padding: 20px;
         border-radius: 0 0 5px 5px;
      }

      .message-thread {
         margin: 20px 0;
      }

      .original-message,
      .reply-message {
         background: white;
         padding: 15px;
         margin: 10px 0;
         border-radius: 5px;
         border-left: 4px solid #ddd;
      }

      .original-message {
         border-left-color: #730c0e;
      }

      .reply-message {
         border-left-color: #28a745;
      }

      .message-meta {
         font-size: 12px;
         color: #666;
         margin-bottom: 10px;
      }

      .footer {
         margin-top: 20px;
         padding-top: 20px;
         border-top: 1px solid #ddd;
         font-size: 12px;
         color: #666;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="header">
         <h1>Reply to Your Message</h1>
      </div>

      <div class="content">
         <p>Dear <strong>{{ $name }}</strong>,</p>

         <p>Thank you for your message. Here is our response:</p>

         <div class="message-thread">
            <div class="original-message">
               <div class="message-meta">
                  <strong>Your original message:</strong>
                  {{ $original_message_date ?? 'Previous' }}
               </div>
               <p>{{ nl2br(e($original_message)) }}</p>
            </div>

            <div class="reply-message">
               <div class="message-meta">
                  <strong>Our reply:</strong>
                  {{ $reply_date }}
               </div>
               <p>{{ nl2br(e($reply_message)) }}</p>
            </div>
         </div>

         <p>If you have any further questions, please don't hesitate to reply to this email.</p>

         <p>Best regards,<br>
            <strong>Baraa Al-Rifaee</strong><br>
            Full Stack Developer
         </p>
      </div>

      <div class="footer">
         <p>This is an automated response. Please do not reply to this email directly.</p>
      </div>
   </div>
</body>

</html>
