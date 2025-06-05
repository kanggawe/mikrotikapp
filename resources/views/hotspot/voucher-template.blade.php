<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotspot Voucher Template</title>
    <style>
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
            .page-break { page-break-after: always; }
        }
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .voucher-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .voucher {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
            width: 300px;
            height: 200px;
            margin: 10px;
        }
        
        .voucher::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }
        
        .voucher-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }
        
        .logo {
            font-size: 18px;
            font-weight: bold;
            color: #fff;
        }
        
        .voucher-type {
            background: rgba(255,255,255,0.2);
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .voucher-content {
            position: relative;
            z-index: 2;
        }
        
        .credentials {
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            backdrop-filter: blur(10px);
        }
        
        .credential-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .credential-label {
            font-size: 12px;
            opacity: 0.8;
        }
        
        .credential-value {
            font-size: 14px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }
        
        .voucher-info {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-top: 15px;
            opacity: 0.9;
        }
        
        .qr-code {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #333;
        }
        
        .instructions {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            color: #333;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .instructions h3 {
            color: #667eea;
            margin-top: 0;
        }
        
        .instructions ol {
            padding-left: 20px;
        }
        
        .instructions li {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        
        .print-controls {
            text-align: center;
            margin: 20px 0;
        }
        
        .print-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            background: #5a67d8;
            transform: translateY(-2px);
        }
        
        .voucher-premium {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .voucher-business {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .voucher-trial {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .watermark {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            opacity: 0.6;
        }
    </style>
</head>
<body>
    <div class="print-controls no-print">
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Vouchers
        </button>
        <button class="print-btn" onclick="window.close()">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <div class="voucher-container" id="voucherContainer">
        <!-- Vouchers will be generated here -->
    </div>

    <div class="instructions no-print">
        <h3>How to Use Your Internet Voucher</h3>
        <ol>
            <li>Connect to the WiFi network: <strong>"{{ $wifiName ?? 'HotSpot-WiFi' }}"</strong></li>
            <li>Open your web browser and navigate to any website</li>
            <li>You will be redirected to the login page automatically</li>
            <li>Enter your username and password from the voucher</li>
            <li>Click "Login" to start your internet session</li>
            <li>Your session will automatically expire after the specified time</li>
        </ol>
        
        <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
            <strong>Important Notes:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Keep your voucher safe - it cannot be replaced if lost</li>
                <li>Each voucher can only be used once</li>
                <li>Session time starts counting from first login</li>
                <li>For support, contact: <strong>{{ $supportContact ?? 'admin@company.com' }}</strong></li>
            </ul>
        </div>
    </div>

    <script>
        // Get voucher data from URL parameters or use sample data
        function getVoucherData() {
            const urlParams = new URLSearchParams(window.location.search);
            const vouchersParam = urlParams.get('vouchers');
            
            if (vouchersParam) {
                try {
                    return JSON.parse(decodeURIComponent(vouchersParam));
                } catch (e) {
                    console.error('Error parsing voucher data:', e);
                }
            }
            
            // Sample data for demonstration
            return [
                {
                    username: 'user001',
                    password: 'pass123',
                    profile: 'basic',
                    duration: '1 Hour',
                    bandwidth: '5M/2M',
                    validUntil: '2024-01-17',
                    code: 'VCH001'
                },
                {
                    username: 'user002',
                    password: 'pass456',
                    profile: 'premium',
                    duration: '24 Hours',
                    bandwidth: '20M/10M',
                    validUntil: '2024-01-18',
                    code: 'VCH002'
                }
            ];
        }
        
        function generateVouchers() {
            const vouchers = getVoucherData();
            const container = document.getElementById('voucherContainer');
            
            vouchers.forEach((voucher, index) => {
                const voucherElement = createVoucherElement(voucher, index);
                container.appendChild(voucherElement);
            });
        }
        
        function createVoucherElement(voucher, index) {
            const div = document.createElement('div');
            const profileClass = `voucher-${voucher.profile}`;
            
            div.className = `voucher ${profileClass}`;
            div.innerHTML = `
                <div class="qr-code">QR</div>
                
                <div class="voucher-header">
                    <div class="logo">HotSpot WiFi</div>
                    <div class="voucher-type">${voucher.profile.toUpperCase()}</div>
                </div>
                
                <div class="voucher-content">
                    <div class="credentials">
                        <div class="credential-row">
                            <span class="credential-label">Username:</span>
                            <span class="credential-value">${voucher.username}</span>
                        </div>
                        <div class="credential-row">
                            <span class="credential-label">Password:</span>
                            <span class="credential-value">${voucher.password}</span>
                        </div>
                    </div>
                    
                    <div class="voucher-info">
                        <div>
                            <div>Duration: ${voucher.duration}</div>
                            <div>Speed: ${voucher.bandwidth}</div>
                        </div>
                        <div>
                            <div>Valid Until: ${voucher.validUntil}</div>
                            <div>Code: ${voucher.code}</div>
                        </div>
                    </div>
                </div>
                
                <div class="watermark">MikroTik RADIUS Management</div>
            `;
            
            return div;
        }
        
        // Generate vouchers when page loads
        document.addEventListener('DOMContentLoaded', generateVouchers);
        
        // Auto-print if requested
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('autoprint') === 'true') {
            window.addEventListener('load', () => {
                setTimeout(() => window.print(), 1000);
            });
        }
    </script>
</body>
</html> 