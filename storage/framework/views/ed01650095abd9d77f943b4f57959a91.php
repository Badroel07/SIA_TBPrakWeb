<?php $__env->startSection('title', 'Detail Transaksi #' . $transaction->invoice_number . ' - ePharma POS'); ?>

<?php $__env->startSection('content'); ?>
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-white p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Back Button -->
        <a href="<?php echo e(route('cashier.transaction.history')); ?>" class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 transition-colors font-medium">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Riwayat Transaksi
        </a>

        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-2xl font-bold text-slate-900"><?php echo e($transaction->invoice_number); ?></h1>
                        <?php if($transaction->status == 'completed'): ?>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                Selesai
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                <?php echo e(ucfirst($transaction->status)); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-slate-500"><?php echo e(\Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y, H:i')); ?></p>
                </div>

                <!-- Transaction Type Badge -->
                <div>
                    <?php if($transaction->transaction_type === 'online'): ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-blue-100 text-blue-700">
                            <span class="material-symbols-outlined text-[18px]">language</span>
                            Online Order
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold bg-orange-100 text-orange-700">
                            <span class="material-symbols-outlined text-[18px]">storefront</span>
                            POS (Langsung)
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            <!-- Left Column: Transaction Info -->
            <div class="md:col-span-1 flex flex-col">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 h-full flex flex-col gap-6">
                    <!-- User Info -->
                    <div>
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <span class="material-symbols-outlined text-lg">person</span>
                            <?php echo e($transaction->transaction_type === 'online' ? 'Pelanggan' : 'Kasir'); ?>

                        </h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-500">Nama</p>
                                <?php if($transaction->transaction_type === 'online'): ?>
                                    <p class="font-bold text-slate-900 text-base"><?php echo e($transaction->user_name ?? ($transaction->user->name ?? 'Unknown')); ?></p>
                                <?php else: ?>
                                    <p class="font-bold text-slate-900 text-base"><?php echo e($transaction->cashier_name ?? ($transaction->user->name ?? 'Unknown')); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Email</p>
                                <?php if($transaction->transaction_type === 'online'): ?>
                                    <p class="font-medium text-slate-900"><?php echo e($transaction->user_email ?? ($transaction->user->email ?? '-')); ?></p>
                                <?php else: ?>
                                    <p class="font-medium text-slate-900"><?php echo e($transaction->cashier_email ?? ($transaction->user->email ?? '-')); ?></p>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Nomor Telepon</p>
                                <?php if($transaction->transaction_type === 'online'): ?>
                                    <p class="font-medium text-slate-900"><?php echo e($transaction->user_phone ?? ($transaction->user->phone_number ?? '-')); ?></p>
                                <?php else: ?>
                                    <p class="font-medium text-slate-900"><?php echo e($transaction->cashier_phone ?? ($transaction->user->phone_number ?? '-')); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="flex-1">
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <span class="material-symbols-outlined text-lg">payments</span>
                            Pembayaran
                        </h2>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-slate-500">Metode</p>
                                <p class="font-bold text-slate-900"><?php echo e($transaction->payment_method ?? 'Cash'); ?></p>
                            </div>
                            <?php if($transaction->amount_paid): ?>
                            <div>
                                <p class="text-xs text-slate-500">Jumlah Dibayar</p>
                                <p class="font-bold text-slate-900">Rp <?php echo e(number_format($transaction->amount_paid, 0, ',', '.')); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if($transaction->change_amount): ?>
                            <div>
                                <p class="text-xs text-slate-500">Kembalian</p>
                                <p class="font-bold text-green-600">Rp <?php echo e(number_format($transaction->change_amount, 0, ',', '.')); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Items -->
            <div class="md:col-span-2 flex flex-col">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-full flex flex-col">
                    <div class="p-6 border-b border-slate-100 shrink-0">
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">receipt_long</span>
                            Detail Item
                        </h2>
                    </div>
                    
                    <!-- Table Container (Scrollable) -->
                    <div class="overflow-x-auto overflow-y-auto max-h-[300px] flex-1 bg-white">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 font-bold border-b border-slate-200 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 bg-slate-50">Item</th>
                                    <th class="px-6 py-4 bg-slate-50 text-center">Qty</th>
                                    <th class="px-6 py-4 bg-slate-50 text-right">Harga</th>
                                    <th class="px-6 py-4 bg-slate-50 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php $__currentLoopData = $transaction->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <?php if($detail->medicine && $detail->medicine->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $detail->medicine->image)); ?>" alt="" class="w-10 h-10 object-cover rounded-lg bg-slate-100">
                                            <?php else: ?>
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                                    <span class="material-symbols-outlined text-xl">medication</span>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-bold text-slate-900"><?php echo e($detail->medicine->name ?? 'Item Tidak Diketahui'); ?></p>
                                                <p class="text-xs text-slate-500"><?php echo e($detail->medicine->category ?? 'Umum'); ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium"><?php echo e($detail->quantity); ?></td>
                                    <td class="px-6 py-4 text-right text-slate-500">Rp <?php echo e(number_format($detail->price, 0, ',', '.')); ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-900">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary (Sticky Footer) -->
                    <div class="bg-slate-50 border-t border-slate-200 shrink-0">
                        <div class="flex justify-between px-6 py-4 bg-blue-50/50">
                            <span class="text-lg font-bold text-blue-700">Total</span>
                            <span class="text-lg font-bold text-blue-700">Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Button -->
        <div class="flex justify-end">
            <a href="<?php echo e(route('cashier.transaction.invoice', $transaction->id)); ?>" target="_blank"
                class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-xl hover:bg-slate-200 transition-all">
                <span class="material-symbols-outlined">print</span>
                Cetak Struk
            </a>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cashier.layouts.app', ['activeMenu' => 'history'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/cashier/transaction/show.blade.php ENDPATH**/ ?>