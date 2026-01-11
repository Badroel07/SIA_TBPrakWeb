<?php $__env->startSection('title', 'Riwayat Transaksi - ePharma POS'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Main Content -->
    <main class="flex-1 overflow-hidden flex flex-col bg-background-light p-6">
        <div class="w-full max-w-7xl mx-auto flex flex-col h-full gap-6">

            <!-- Header & Search -->
            <div
                class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 py-8 px-8 rounded-2xl shadow-sm border border-slate-200">
                <div>
                    <h1 class="text-2xl font-bold">Riwayat Transaksi</h1>
                    <p class="text-slate-500 text-sm">Lihat dan kelola riwayat transaksi</p>
                </div>

                <form action="<?php echo e(route('cashier.transaction.history')); ?>" method="GET" class="w-full md:w-auto relative"
                    x-data="{ 
                      typing: false,
                      submit() { this.$el.submit(); }
                  }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">search</span>
                    </div>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                        class="pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm w-full md:w-80 focus:ring-blue-600 focus:border-blue-600 placeholder-slate-400 transition-shadow"
                        placeholder="Cari berdasarkan Nomor Faktur...">
                </form>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead
                            class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 font-bold">Faktur</th>
                                <th class="px-6 py-4 font-bold">Tanggal</th>
                                <th class="px-6 py-4 font-bold">Total</th>
                                <th class="px-6 py-4 font-bold">Status</th>
                                <th class="px-6 py-4 font-bold">Tipe</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        <?php echo e($transaction->invoice_number); ?>

                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-medium text-slate-900"><?php echo e(date('d M Y', strtotime($transaction->transaction_date))); ?></span>
                                            <span
                                                class="text-xs"><?php echo e(date('H:i', strtotime($transaction->transaction_date))); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-blue-600">
                                        Rp <?php echo e(number_format($transaction->total_amount, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($transaction->status == 'completed'): ?>
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-emerald-100 text-emerald-700">
                                                <span class="material-symbols-outlined text-[14px]">check_circle</span>
                                                Selesai
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700">
                                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                                <?php echo e(ucfirst($transaction->status)); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($transaction->transaction_type === 'online'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                                                <span class="material-symbols-outlined text-[14px]">language</span>
                                                Online
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-bold bg-orange-100 text-orange-700">
                                                <span class="material-symbols-outlined text-[14px]">storefront</span>
                                                POS
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="<?php echo e(route('cashier.transaction.showDetails', $transaction->id)); ?>"
                                            class="size-9 rounded-lg flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all mx-auto">
                                            <span class="material-symbols-outlined">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-slate-400">
                                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">receipt_long</span>
                                        <p>Tidak ada riwayat transaksi ditemukan.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($transactions->hasPages()): ?>
                    <div class="p-4 border-t border-slate-200 bg-slate-50">
                        <?php echo e($transactions->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('cashier.layouts.app', ['activeMenu' => 'history'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/cashier/transaction/history.blade.php ENDPATH**/ ?>