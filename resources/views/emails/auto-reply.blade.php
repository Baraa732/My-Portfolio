<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <title>Thank You for Contacting Baraa Al-Rifaee</title>
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
         padding: 30px;
         text-align: center;
      }

      .content {
         background: #f9f9f9;
         padding: 30px;
         border-radius: 0 0 5px 5px;
      }

      .thank-you {
         font-size: 18px;
         margin-bottom: 20px;
      }

      .response-time {
         background: white;
         padding: 15px;
         border-radius: 5px;
         margin: 20px 0;
      }

      .footer {
         margin-top: 30px;
         padding-top: 20px;
         border-top: 1px solid #ddd;
         text-align: center;
         color: #666;
      }

      .signature {
         margin-top: 20px;
         font-style: italic;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="header">
         <h1>Thank You for Reaching Out!</h1>
      </div>

      <div class="content">
         <div class="thank-you">
            <p>Dear <strong>{{ $name }}</strong>,</p>

            <p>Thank you for contacting me through my portfolio website. I have received your message and truly
               appreciate you taking the time to get in touch.</p>
         </div>

         <div class="response-time">
            <p><strong>Here's what happens next:</strong></p>
            <ul>
               <li>I review every message personally</li>
               <li>I'll respond to your inquiry within 24-48 hours</li>
               <li>For urgent matters, you can reach me at +963 994 134 966</li>
            </ul>
         </div>

         <div class="message-summary">
            <p><strong>Your Message Details:</strong></p>
            <p><em>"{{ Str::limit($messageContent, 150) }}"</em></p>
         </div>

         <div class="signature">
            <p>Best regards,<br>
               <strong>Baraa Al-Rifaee</strong><br>
               Full Stack Developer<br>
               Email: baraaalrifaee732@gmail.com<br>
               Phone: +963 994 134 966
            </p>
         </div>
      </div>

      <div class="footer">
         <p>This is an automated response. Please do not reply to this email.</p>
      </div>
   </div>
</body>

</html>
