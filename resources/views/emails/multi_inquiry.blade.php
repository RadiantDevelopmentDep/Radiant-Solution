<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eef2f2; border-radius: 15px; }
        .header { background: #396068; color: white; padding: 20px; border-radius: 12px 12px 0 0; text-align: center; }
        .badge { background: #b4955e; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; margin-right: 5px; display: inline-block; margin-bottom: 5px; }
        .field { margin-bottom: 20px; padding: 10px; background: #f9f9f9; border-radius: 8px; }
        .label { font-weight: bold; color: #396068; font-size: 12px; text-transform: uppercase; margin-bottom: 5px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Multi-Service Inquiry</h2>
        </div>
        <div style="padding: 20px;">
            <div class="field">
                <span class="label">Client Name</span>
                <div>{{ $formData['name'] }}</div>
            </div>
            <div class="field">
                <span class="label">Contact Email</span>
                <div>{{ $formData['email'] }}</div>
            </div>
            <div class="field">
                <span class="label">Requested Services</span>
                <div>
                    @foreach($formData['services'] as $service)
                        <span class="badge">{{ $service }}</span>
                    @endforeach
                </div>
            </div>
            <div class="field">
                <span class="label">Project Brief</span>
                <div>{{ $formData['message'] }}</div>
            </div>
        </div>
    </div>
</body>
</html>