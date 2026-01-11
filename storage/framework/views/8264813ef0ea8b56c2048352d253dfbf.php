<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur <?php echo e($transaction->invoice_number); ?> - ePharma POS</title>
    
    <!-- Fonts -->
    <?php echo $__env->make('components.fonts.parkin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Parkinsans', sans-serif;
            background: #f8fafc;
            color: #1e293b;
        }

        .invoice-container {
            max-width: 400px;
            margin: 20px auto;
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 2px dashed #e2e8f0;
            margin-bottom: 16px;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            color: #2563eb;
            margin-bottom: 4px;
        }

        .sublogo {
            font-size: 12px;
            color: #64748b;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 16px;
        }

        .invoice-number {
            font-weight: 700;
            color: #1e293b;
            font-size: 14px;
        }

        .items-table {
            width: 100%;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .items-table th {
            text-align: left;
            padding: 8px 4px;
            border-bottom: 1px solid #e2e8f0;
            color: #64748b;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 10px 4px;
            border-bottom: 1px solid #f1f5f9;
        }

        .items-table .qty {
            text-align: center;
        }

        .items-table .price {
            text-align: right;
        }

        .summary {
            border-top: 2px dashed #e2e8f0;
            padding-top: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 13px;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 800;
            color: #2563eb;
            padding: 12px 0;
            border-top: 2px solid #e2e8f0;
            margin-top: 8px;
        }

        .summary-row.change {
            background: #f0fdf4;
            padding: 12px;
            border-radius: 8px;
            margin-top: 8px;
            color: #16a34a;
            font-weight: 700;
        }

        .footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 2px dashed #e2e8f0;
        }

        .footer p {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .footer .thanks {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            padding: 12px 16px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            text-align: center;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        @media print {
            body {
                background: white;
            }
            
            .invoice-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">ePharma POS</div>
            <div class="sublogo">Apotek Terpercaya</div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div>
                <div class="invoice-number"><?php echo e($transaction->invoice_number); ?></div>
                <div><?php echo e($transaction->transaction_date->format('d M Y, H:i')); ?></div>
            </div>
            <div style="text-align: right;">
                <div>Kasir:</div>
                <div style="font-weight: 600; color: #1e293b;"><?php echo e($transaction->user->name ?? 'N/A'); ?></div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Harga</th>
                    <th class="price">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $transaction->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($detail->medicine->name ?? 'Item Dihapus'); ?></td>
                    <td class="qty"><?php echo e($detail->quantity); ?></td>
                    <td class="price"><?php echo e(number_format($detail->price, 0, ',', '.')); ?></td>
                    <td class="price"><?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row total">
                <span>TOTAL</span>
                <span>Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></span>
            </div>
            <div class="summary-row">
                <span>Tunai</span>
                <span>Rp <?php echo e(number_format($transaction->cash_received ?? 0, 0, ',', '.')); ?></span>
            </div>
            <div class="summary-row change">
                <span>Kembalian</span>
                <span>Rp <?php echo e(number_format(($transaction->cash_received ?? 0) - $transaction->total_amount, 0, ',', '.')); ?></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="thanks">Terima Kasih!</p>
            <p>Semoga lekas sembuh</p>
        </div>

        <!-- Actions (hidden on print) -->
        <div class="actions">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak
            </button>
            <a href="<?php echo e(route('cashier.transaction.index')); ?>" class="btn btn-secondary">
                ← Kembali ke POS
            </a>
        </div>
    </div>

    <script>
        // Auto print on page load
        window.onload = function() {
            // Clear cart from local storage when invoice is generated (payment success)
            localStorage.removeItem('pos_cart');
            
            // Optional: uncomment to auto-print
            // window.print();
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/cashier/transaction/invoice.blade.php ENDPATH**/ ?>