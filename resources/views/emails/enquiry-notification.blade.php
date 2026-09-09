<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $enquiry->subject ?: 'New Product Quote Request' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .email-container {
            max-width: 620px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .email-header {
            background-color: #0B1E3D;
            padding: 24px 30px;
            border-bottom: 3px solid #C8860A;
        }
        .email-header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        .email-header p {
            color: #94a3b8;
            font-size: 13px;
            margin: 4px 0 0;
        }
        .email-body {
            padding: 28px 30px;
        }
        .section-title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #C8860A;
            margin-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 6px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        .info-grid td {
            padding: 8px 10px;
            font-size: 14px;
            vertical-align: top;
        }
        .info-grid td.label {
            width: 32%;
            font-weight: 600;
            color: #64748b;
            background-color: #f8fafc;
            border-radius: 4px;
        }
        .info-grid td.value {
            color: #0f172a;
            font-weight: 500;
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 3px solid #0B1E3D;
            border-radius: 6px;
            padding: 16px;
            font-size: 14px;
            color: #1e293b;
            white-space: pre-wrap;
            line-height: 1.65;
            margin-bottom: 24px;
        }
        .product-highlight {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 22px;
        }
        .product-highlight h3 {
            margin: 0 0 4px 0;
            font-size: 15px;
            color: #1e40af;
        }
        .product-highlight p {
            margin: 0;
            font-size: 13px;
            color: #3b82f6;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 18px 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
            text-align: center;
        }
        .btn-reply {
            display: inline-block;
            background-color: #C8860A;
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $siteName ?? 'Malfaur Engineering' }}</h1>
            <p>New Quote Request / Product Enquiry Received</p>
        </div>

        <div class="email-body">
            @if(!empty($productName) || !empty($enquiry->product_name))
                <div class="product-highlight">
                    <h3>Associated Product: {{ $productName ?? $enquiry->product_name }}</h3>
                    @if(!empty($enquiry->product_category))
                        <p>Category: {{ $enquiry->product_category }}</p>
                    @endif
                </div>
            @endif

            <div class="section-title">Customer Information</div>
            <table class="info-grid">
                <tr>
                    <td class="label">Full Name:</td>
                    <td class="value"><strong>{{ $enquiry->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Email Address:</td>
                    <td class="value"><a href="mailto:{{ $enquiry->email }}" style="color:#2563eb;">{{ $enquiry->email }}</a></td>
                </tr>
                @if(!empty($enquiry->phone))
                <tr>
                    <td class="label">Phone:</td>
                    <td class="value">{{ $enquiry->phone }}</td>
                </tr>
                @endif
                @if(!empty($enquiry->company))
                <tr>
                    <td class="label">Company:</td>
                    <td class="value">{{ $enquiry->company }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Subject:</td>
                    <td class="value">{{ $enquiry->subject ?: 'Quote Request' }}</td>
                </tr>
                <tr>
                    <td class="label">Submitted At:</td>
                    <td class="value">{{ $enquiry->created_at ? $enquiry->created_at->format('d M Y, H:i (T)') : date('d M Y, H:i') }}</td>
                </tr>
            </table>

            <div class="section-title">Enquiry & Specifications Message</div>
            <div class="message-box">{{ $enquiry->message }}</div>

            <div style="text-align: center; margin-top: 20px;">
                <a href="mailto:{{ $enquiry->email }}?subject=Re: {{ rawurlencode($enquiry->subject ?: 'Your inquiry to Malfaur Engineering') }}" class="btn-reply">
                    Reply to {{ $enquiry->name }}
                </a>
            </div>
        </div>

        <div class="email-footer">
            <p>This automated notification was generated by the {{ $siteName ?? 'Malfaur Engineering' }} website.</p>
        </div>
    </div>
</body>
</html>
