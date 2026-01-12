<?php $__env->startSection('title', 'Manajemen Pesanan'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Pesanan</h2>
            <p class="text-gray-500 mt-1">Kelola Pesanan Pelanggan dan Transaksi</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Faktur</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Kasir</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Tipe</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                <?php echo e($order->invoice_number); ?>

                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <?php if($order->transaction_type === 'online'): ?>
                                    <?php echo e($order->cashier_name ?? ($order->cashier ? $order->cashier->name : '-')); ?>

                                <?php else: ?>
                                    <?php echo e($order->user_name ?? ($order->user ? $order->user->name : 'Tidak Diketahui')); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <?php echo e($order->created_at->format('d M Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 font-bold text-[#6200EA]">
                                Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    <span class="material-icons-round text-sm">check_circle</span>
                                    Selesai
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($order->transaction_type === 'online'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        <span class="material-icons-round text-sm">language</span>
                                        Online
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                        <span class="material-icons-round text-sm">storefront</span>
                                        POS
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button onclick="openDetailModal(<?php echo e($order->id); ?>)" 
                                    class="text-gray-400 hover:text-[#6200EA] transition-colors" 
                                    title="Lihat Detail">
                                    <span class="material-icons-round">visibility</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-icons-round text-3xl text-gray-400">shopping_bag</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">Tidak Ada Pesanan</h3>
                                <p class="text-gray-500 mb-6">Belum ada transaksi yang tercatat.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($orders->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="bg-white w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="detailContent">
            <!-- Modal Header -->
            <div class="bg-[#6200EA] px-6 py-4 flex justify-between items-center text-white">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <span class="material-icons-round">receipt_long</span>
                    Detail Pesanan
                </h3>
                <button onclick="closeDetailModal()" class="hover:bg-white/20 rounded-lg p-1 transition-colors">
                    <span class="material-icons-round">close</span>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <span class="text-xs text-gray-500 uppercase tracking-wide font-bold">Nomor Faktur</span>
                        <p class="text-lg font-bold text-gray-800 pt-1" id="modal-invoice">-</p>
                        
                        <div class="mt-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wide font-bold">Tipe Transaksi</span>
                            <p class="text-sm font-medium text-gray-800 capitalize" id="modal-type">-</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-gray-500 uppercase tracking-wide font-bold">Tanggal</span>
                        <p class="text-sm text-gray-600 pt-1" id="modal-date">-</p>

                        <div class="mt-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wide font-bold">Kasir</span>
                            <p class="text-sm font-medium text-gray-800" id="modal-cashier">-</p>
                            <p class="text-xs text-gray-500 mt-1" id="modal-cashier-email">-</p>
                            <p class="text-xs text-gray-500" id="modal-cashier-phone">-</p>
                        </div>

                        <div class="mt-3">
                            <span class="text-xs text-gray-500 uppercase tracking-wide font-bold">Pelanggan</span>
                            <p class="text-sm font-medium text-gray-800" id="modal-customer">-</p>
                            <p class="text-xs text-gray-500 mt-1" id="modal-customer-email">-</p>
                            <p class="text-xs text-gray-500" id="modal-customer-phone">-</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address (for online orders) -->
                <div id="modal-shipping-section" class="hidden mb-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <span class="text-xs text-blue-700 uppercase tracking-wide font-bold flex items-center gap-1 mb-2">
                        <span class="material-icons-round text-sm">local_shipping</span>
                        Alamat Pengiriman
                    </span>
                    <p class="text-sm text-gray-800 leading-relaxed" id="modal-shipping-address">-</p>
                </div>

                <div class="border rounded-xl border-gray-100 overflow-hidden mb-6">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left">Item</th>
                                <th class="px-4 py-3 text-center">Jml</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                <th class="px-4 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="modal-items-body" class="divide-y divide-gray-100 text-gray-800">
                            <!-- Items injected by JS -->
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <span class="font-bold text-gray-700">Total Bayar</span>
                    <span class="text-2xl font-bold text-[#6200EA]" id="modal-total">Rp 0</span>
                </div>
            </div>
            
             <!-- Modal Footer -->
             <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                 <button onclick="closeDetailModal()" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-200 transition-colors font-medium">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Script to handle modal -->
    <script>
        function openDetailModal(id) {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');
            const tbody = document.getElementById('modal-items-body');

            // Reset state
            document.getElementById('modal-invoice').innerText = 'Memuat...';
            document.getElementById('modal-type').innerText = '-';
            document.getElementById('modal-cashier').innerText = '-';
            document.getElementById('modal-cashier-email').innerText = '-';
            document.getElementById('modal-cashier-phone').innerText = '-';
            document.getElementById('modal-customer').innerText = '-';
            document.getElementById('modal-customer-email').innerText = '-';
            document.getElementById('modal-customer-phone').innerText = '-';
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-gray-500">Memuat detail...</td></tr>';

            // Show Modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);

                // Fetch Data
            fetch(`/admin/orders/${id}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('modal-invoice').innerText = data.invoice_number;
                    document.getElementById('modal-date').innerText = new Date(data.transaction_date).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });

                    // Transaction Type Logic
                    const isOnline = data.transaction_type === 'online';
                    document.getElementById('modal-type').innerText = isOnline ? 'Pesanan Online' : 'Point of Sale (POS)';
                    
                    // User Label Logic
                    if (isOnline) {
                        document.getElementById('modal-cashier').innerText = data.cashier_name || (data.cashier ? data.cashier.name : '-');
                        document.getElementById('modal-cashier-email').innerText = data.cashier_email || (data.cashier ? data.cashier.email : '-');
                        document.getElementById('modal-cashier-phone').innerText = data.cashier_phone || (data.cashier ? data.cashier.phone_number : '-');
                        document.getElementById('modal-customer').innerText = data.user_name || (data.user ? data.user.name : 'Tidak Diketahui');
                        document.getElementById('modal-customer-email').innerText = data.user_email || (data.user ? data.user.email : '-');
                        document.getElementById('modal-customer-phone').innerText = data.user_phone || (data.user ? data.user.phone_number : '-');
                        
                        // Show shipping address for online orders
                        if (data.customer_order) {
                            const shippingSection = document.getElementById('modal-shipping-section');
                            const shippingAddress = document.getElementById('modal-shipping-address');
                            const order = data.customer_order;
                            shippingAddress.innerHTML = `
                                <strong>${order.recipient_name}</strong><br>
                                ${order.recipient_phone}<br>
                                ${order.shipping_address}<br>
                                ${order.city}, ${order.province} ${order.postal_code}
                            `;
                            shippingSection.classList.remove('hidden');
                        } else {
                            document.getElementById('modal-shipping-section').classList.add('hidden');
                        }
                    } else {
                        document.getElementById('modal-cashier').innerText = data.user_name || (data.user ? data.user.name : 'Tidak Diketahui');
                        document.getElementById('modal-cashier-email').innerText = data.user_email || (data.user ? data.user.email : '-');
                        document.getElementById('modal-cashier-phone').innerText = data.user_phone || (data.user ? data.user.phone_number : '-');
                        document.getElementById('modal-customer').innerText = '-';
                        document.getElementById('modal-customer-email').innerText = '-';
                        document.getElementById('modal-customer-phone').innerText = '-';
                        document.getElementById('modal-shipping-section').classList.add('hidden');
                    }

                    let html = '';
                    data.details.forEach(item => {
                        html += `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="font-bold">${item.medicine ? item.medicine.name : 'Item Tidak Diketahui'}</div>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-500">${item.quantity}</td>
                            <td class="px-4 py-3 text-right text-gray-500">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.price)}</td>
                            <td class="px-4 py-3 text-right font-bold">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.subtotal)}</td>
                        </tr>
                    `;
                    });
                    tbody.innerHTML = html;
                    document.getElementById('modal-total').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total_amount);
                })
                .catch(err => {
                    console.error(err);
                    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-red-500">Gagal memuat detail.</td></tr>';
                });
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            const content = document.getElementById('detailContent');

            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>