

<?php $__env->startSection('title', 'Dashboard - ePharma POS'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex-1 overflow-y-auto bg-background-light p-6">
    <div class="w-full space-y-6">
        
        <!-- Welcome Section -->
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Selamat Datang, <?php echo e(Auth::user()->name); ?>! 👋</h1>
            <p class="text-slate-500">Berikut adalah ringkasan aktivitas toko hari ini.</p>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Revenue -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="absolute right-[-10px] top-[-10px] p-8 rounded-full bg-blue-50 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-bold text-slate-900">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h3>
                    </div>
                    <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div class="relative z-10 mt-auto">
                    <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span>
                        Update Realtime
                    </span>
                </div>
            </div>

            <!-- Customers -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="absolute right-[-10px] top-[-10px] p-8 rounded-full bg-orange-50 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Total Transaksi</p>
                        <h3 class="text-2xl font-bold text-slate-900"><?php echo e($totalCustomers); ?></h3>
                    </div>
                    <div class="p-2 bg-orange-100 text-orange-600 rounded-lg">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                </div>
                <div class="relative z-10 mt-auto">
                    <span class="text-xs text-slate-500">Transaksi hari ini</span>
                </div>
            </div>

            <!-- Low Stock -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="absolute right-[-10px] top-[-10px] p-8 rounded-full bg-red-50 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Stok Menipis</p>
                        <h3 class="text-2xl font-bold text-red-600"><?php echo e($lowStockItems); ?></h3>
                    </div>
                    <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
                <a href="<?php echo e(route('cashier.transaction.index')); ?>" class="relative z-10 mt-auto text-xs text-blue-600 font-bold hover:underline">
                    Periksa Stok &rarr;
                </a>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex flex-col justify-between h-32 relative overflow-hidden group">
                <div class="absolute right-[-10px] top-[-10px] p-8 rounded-full bg-purple-50 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium mb-1">Pesanan Pending</p>
                        <h3 class="text-2xl font-bold text-purple-600"><?php echo e($pendingOrders); ?></h3>
                    </div>
                    <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <a href="<?php echo e(route('cashier.orders.incoming')); ?>" class="relative z-10 mt-auto text-xs text-blue-600 font-bold hover:underline">
                    Lihat Pesanan &rarr;
                </a>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900">Transaksi Terakhir</h3>
                <a href="<?php echo e(route('cashier.transaction.history')); ?>" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 font-bold">No. Invoice</th>
                            <th class="px-6 py-4 font-bold">Waktu</th>
                            <th class="px-6 py-4 font-bold">Kasir</th>
                            <th class="px-6 py-4 font-bold">Total</th>
                            <th class="px-6 py-4 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    <?php echo e($trx->invoice_number); ?>

                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    <?php echo e($trx->created_at->format('H:i')); ?>

                                </td>
                                <td class="px-6 py-4 text-slate-500">
                                    <?php echo e($trx->user ? $trx->user->name : '-'); ?>

                                </td>
                                <td class="px-6 py-4 font-bold text-blue-600">
                                    Rp <?php echo e(number_format($trx->total_amount, 0, ',', '.')); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                        Sukses
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400">
                                    <p>Belum ada transaksi hari ini.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('cashier.layouts.app', ['activeMenu' => 'dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/cashier/dashboard/index.blade.php ENDPATH**/ ?>