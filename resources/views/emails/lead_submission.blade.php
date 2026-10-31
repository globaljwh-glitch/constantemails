<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Business Inquiry Logged</title>
  <style>
    body { margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
    table { border-collapse: collapse; border-spacing: 0; }
    img { border: 0; max-width: 100%; height: auto; }
    .email-container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    .header { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); padding: 32px; text-align: center; }
    .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.5px; }
    .content { padding: 32px; }
    .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; color: #4f46e5; letter-spacing: 1px; margin: 24px 0 12px 0; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px; }
    .section-title:first-of-type { margin-top: 0; }
    .info-table { width: 100%; margin-bottom: 8px; }
    .info-table td { padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: top; }
    .info-table td.label { width: 35%; color: #64748b; font-weight: 600; }
    .info-table td.value { color: #0f172a; }
    .panel { background-color: #f8fafc; border-left: 4px solid #4f46e5; padding: 16px; border-radius: 0 8px 8px 0; margin-top: 12px; font-size: 14px; color: #334155; line-height: 1.5; }
    .footer { background-color: #f8fafc; padding: 24px; text-align: center; font-size: 12px; color: #94a3b8; }
  </style>
</head>
<body>
  <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f1f5f9">
    <tr>
      <td padding="40px 20px" align="center">
        <div class="email-container">
          
          <!-- Header -->
          <div class="header">
            <h1>New Business Inquiry Logged</h1>
          </div>

          <!-- Content -->
          <div class="content">
            
            <!-- Section 1 -->
            <div class="section-title">Sender Profile</div>
            <table class="info-table">
              <tr>
                <td class="label">Full Name</td>
                <td class="value">{{ $formData['first_name'] }} {{ $formData['last_name'] }}</td>
              </tr>
              <tr>
                <td class="label">Email Address</td>
                <td class="value"><a href="mailto:{{ $formData['email'] }}" style="color: #4f46e5; text-decoration: none;">{{ $formData['email'] }}</a></td>
              </tr>
              <tr>
                <td class="label">Phone Line</td>
                <td class="value">{{ $formData['phone'] }}</td>
              </tr>
              <tr>
                <td class="label">Company Profile</td>
                <td class="value">{{ $formData['company'] ?? 'N/A' }}</td>
              </tr>
            </table>

            <!-- Section 2 -->
            <div class="section-title">Geographic Location</div>
            <table class="info-table">
              <tr>
                <td class="label">Street Address</td>
                <td class="value">{{ $formData['address'] }}</td>
              </tr>
              <tr>
                <td class="label">City Details</td>
                <td class="value">{{ $formData['city'] }}</td>
              </tr>
              <tr>
                <td class="label">State / Region</td>
                <td class="value">{{ $formData['state'] }} ({{ $formData['zip'] }})</td>
              </tr>
              <tr>
                <td class="label">Country Origin</td>
                <td class="value">{{ $formData['country'] }}</td>
              </tr>
            </table>

            <!-- Section 3 -->
            <div class="section-title">Target Segment Metrics</div>
            <table class="info-table">
              <tr>
                <td class="label">Market Segment</td>
                <td class="value" style="font-weight: 600; color: #4f46e5;">{{ $formData['application'] }}</td>
              </tr>
              <tr>
                <td class="label">Products Interested</td>
                <td class="value">{{ $formData['products_interested'] }}</td>
              </tr>
            </table>

            <!-- Section 4 -->
            <div class="section-title">Application Summary</div>
            <div class="panel">
              {{ $formData['final_application'] }}
            </div>

          </div>

          <!-- Footer -->
          <div class="footer">
            This is an automated operational alert sent from your application workspace backend.<br>
            &copy; {{ date('Y') }} Your Brand CRM. All rights reserved.
          </div>

        </div>
      </td>
    </tr>
  </table>
</body>
</html>
