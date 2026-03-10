<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Gaji - #INV-<?= str_pad($payment->id, 5, '0', STR_PAD_LEFT) ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; margin: 0; padding: 0; color: #333; }
        .container { width: 100%; max-width: 400px; margin: 0 auto; border: 1px dashed #aaa; padding: 20px; box-sizing: border-box; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 1px dashed #aaa; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; color: #4F46E5; }
        .header p { margin: 5px 0 0; font-size: 12px; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
        .label { font-weight: bold; }
        .amount { font-size: 18px; font-weight: bold; text-align: center; margin: 20px 0; border: 1px solid #ddd; padding: 10px; background: #f9f9f9; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #777; border-top: 1px dashed #aaa; padding-top: 10px; }
        .print-btn { display: block; width: 100%; padding: 10px; background: #4F46E5; color: white; text-align: center; text-decoration: none; border: none; border-radius: 5px; margin-top: 20px; cursor: pointer; font-family: sans-serif; font-weight: bold; }
        @media print {
            .print-btn { display: none; }
            .container { border: none; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="container bg-white shadow-lg">
        <div class="header">
            <h1>Raaster Shuttel</h1>
            <p>SLIP PEMBAYARAN GAJI MITRA</p>
            <p><?= date('d F Y, H:i', strtotime($payment->payment_date)) ?></p>
        </div>

        <div class="detail-row">
            <span class="label">Invoice:</span>
            <span>#INV-<?= str_pad($payment->id, 5, '0', STR_PAD_LEFT) ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Driver:</span>
            <span><?= $payment->driver_name ?></span>
        </div>
        <div class="detail-row">
            <span class="label">Admin:</span>
            <span><?= $payment->admin_name ?: 'System' ?></span>
        </div>

        <hr style="border: 0; border-top: 1px dashed #ddd; margin: 15px 0;">

        <div style="font-size: 14px; margin-bottom: 5px; font-weight: bold;">Keterangan:</div>
        <div style="font-size: 13px; margin-bottom: 15px;"><?= $payment->note ?: '-' ?></div>

        <div class="amount">
            Rp <?= number_format($payment->amount, 0, ',', '.') ?>
        </div>

        <div style="text-align: center; font-size: 14px; font-weight: bold; color: green;">
            [ L U N A S ]
        </div>

        <div class="footer">
            <p>Terima kasih atas kerja keras Anda!</p>
            <p>PT. Raaster Shuttle Indonesia</p>
        </div>
    </div>

    <!-- html2canvas CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        window.onload = function() {
            downloadImage();
        };

        function downloadImage() {
            var container = document.querySelector(".container");

            html2canvas(container, {
                scale: 2, // Better quality
                backgroundColor: "#ffffff"
            }).then(canvas => {
                // Trigger download
                var link = document.createElement('a');
                link.download = 'Struk-Gaji-INV-<?= str_pad($payment->id, 5, '0', STR_PAD_LEFT) ?>.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
                
                // Clear page after download to prevent "preview"
                document.body.innerHTML = '';
            });
        }
    </script>
</body>
</html>
