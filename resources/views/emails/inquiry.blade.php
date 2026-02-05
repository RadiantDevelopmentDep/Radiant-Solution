<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eef2f2; border-radius: 15px; }
        .header { background: #396068; color: white; padding: 20px; border-radius: 12px 12px 0 0; text-align: center; }
        .content { padding: 20px; background: #fcfcfc; }
        .field { margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .label { font-weight: bold; color: #396068; text-transform: uppercase; font-size: 12px; }
        .footer { text-align: center; font-size: 11px; color: #94a3b8; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Inquiry Received</h1>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Full Name</div>
                <div>{{ $formData['name'] }}</div>
            </div>
            <div class="field">
                <div class="label">Email Address</div>
                <div>{{ $formData['email'] }}</div>
            </div>
            <div class="field">
                <div class="label">Service Requested</div>
                <div>{{ strtoupper(str_replace('-', ' ', $formData['service_slug'])) }}</div>
            </div>
            <div class="field">
                <div class="label">Project Brief</div>
                <div>{{ $formData['message'] }}</div>
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} Radiant Solutions Admin System
        </div>
    </div>
</body>
</html>