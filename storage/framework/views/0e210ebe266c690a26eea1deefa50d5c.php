<?php $__env->startSection('title', 'Inventory Management'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Inventaris</h2>
            <p class="text-gray-500 mt-1">Kelola stok dan katalog obat Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openMedicineModal()"
                class="flex items-center gap-2 px-4 py-2 bg-[#6200EA] text-white rounded-lg text-sm font-bold hover:bg-[#5000C0] transition-colors shadow-md shadow-purple-200">
                <span class="material-icons-round text-lg">add</span>
                Tambah Obat
            </button>
        </div>
    </div>

    <form action="<?php echo e(route('admin.medicines.index')); ?>" method="GET" x-data="{
                                    searchTimeout: null,
                                    loading: false,
                                    performSearch() {
                                        clearTimeout(this.searchTimeout);
                                        this.searchTimeout = setTimeout(() => {
                                            this.loading = true;
                                            const formData = new FormData($el);
                                            const params = new URLSearchParams(formData);

                                            fetch('<?php echo e(route('admin.medicines.index')); ?>?' + params.toString(), {
                                                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                                            })
                                            .then(response => response.text())
                                            .then(html => {
                                                const parser = new DOMParser();
                                                const doc = parser.parseFromString(html, 'text/html');
                                                const newResults = doc.querySelector('#medicine-table-results');
                                                const currentResults = document.querySelector('#medicine-table-results');
                                                if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }
                                                
                                                // Update URL without reloading
                                                window.history.pushState({}, '', '<?php echo e(route('admin.medicines.index')); ?>?' + params.toString());
                                                
                                                this.loading = false;
                                            })
                                            .catch(error => { console.error('Search error:', error); this.loading = false; });
                                        }, 400);
                                    }
                                }" class="mb-6">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Container Search -->
            <div class="lg:col-span-6 bg-white p-5 rounded-xl border border-gray-100 shadow-sm h-full">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-icons-round text-[#6200EA]">search</span>
                    Cari
                </h3>
                <div class="relative group">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#6200EA] transition-colors">
                        <span class="material-icons-round">search</span>
                    </span>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama obat..."
                        @input="performSearch()"
                        class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-[#6200EA] focus:border-transparent focus:bg-white transition-all outline-none">
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 mt-4">
                    <button type="submit"
                        class="flex-1 bg-[#6200EA] hover:bg-[#5000C0] text-white px-4 py-2.5 rounded-lg text-sm font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                        <span class="material-icons-round text-base animate-spin" x-show="loading"
                            x-cloak>refresh</span>
                        <span class="material-icons-round text-base" x-show="!loading">search</span>
                        Cari
                    </button>
                    <a href="<?php echo e(route('admin.medicines.index')); ?>"
                        class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors flex items-center justify-center"
                        title="Reset Filter">
                        <span class="material-icons-round">restart_alt</span>
                    </a>
                </div>
            </div>

            <!-- Container Filters & Actions -->
            <div class="lg:col-span-6 bg-white p-5 rounded-xl border border-gray-100 shadow-sm h-full">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-icons-round text-[#6200EA]">filter_list</span>
                    Filter
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Category Filter -->
                    <div class="relative"
                        x-data="{ open: false, selectedLabel: '<?php echo e(request('category') == 'all' ? 'Semua Kategori' : (request('category') ?: 'Semua Kategori')); ?>', selectedValue: '<?php echo e(request('category') ?: 'all'); ?>' }"
                        @click.outside="open = false">

                        <input type="hidden" name="category" x-model="selectedValue" @change="performSearch()">

                        <button type="button" @click="open = !open"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 flex justify-between items-center focus:ring-2 focus:ring-[#6200EA] transition-all hover:bg-white">
                            <span class="truncate" x-text="selectedLabel"></span>
                            <span class="material-icons-round text-gray-400 text-lg transition-transform"
                                :class="{ 'rotate-180': open }">expand_more</span>
                        </button>

                        <div x-show="open" x-transition.opacity x-cloak
                            class="absolute z-30 w-full mt-1 bg-white border border-gray-100 rounded-lg shadow-xl max-h-60 overflow-y-auto">

                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="selectedLabel = 'All Categories'; selectedValue = 'all'; open = false; performSearch()">
                                Semua Kategori
                            </a>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                    @click.prevent="selectedLabel = '<?php echo e($cat); ?>'; selectedValue = '<?php echo e($cat); ?>'; open = false; performSearch()">
                                    <?php echo e($cat); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="relative" x-data="{ 
                                                    open: false, 
                                                    sortBy: '<?php echo e(request('sort_by', 'created_at')); ?>',
                                                    sortOrder: '<?php echo e(request('sort_order', 'desc')); ?>',
                                                    getLabel() {
                                                        if(this.sortBy === 'name' && this.sortOrder === 'asc') return 'Nama (A-Z)';
                                                        if(this.sortBy === 'name' && this.sortOrder === 'desc') return 'Nama (Z-A)';
                                                        if(this.sortBy === 'stock' && this.sortOrder === 'asc') return 'Stok (Sedikit-Banyak)';
                                                        if(this.sortBy === 'stock' && this.sortOrder === 'desc') return 'Stok (Banyak-Sedikit)';
                                                        if(this.sortBy === 'created_at' && this.sortOrder === 'desc') return 'Terbaru Ditambahkan';
                                                        if(this.sortBy === 'created_at' && this.sortOrder === 'asc') return 'Terlama Ditambahkan';
                                                        return 'Urutkan';
                                                    },
                                                    setSort(by, order) {
                                                        this.sortBy = by;
                                                        this.sortOrder = order;
                                                        this.open = false;
                                                        this.performSearch();
                                                    }
                                                }" @click.outside="open = false">

                        <input type="hidden" name="sort_by" x-model="sortBy">
                        <input type="hidden" name="sort_order" x-model="sortOrder">

                        <button type="button" @click="open = !open"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 flex justify-between items-center focus:ring-2 focus:ring-[#6200EA] transition-all hover:bg-white">
                            <span class="truncate" x-text="getLabel()"></span>
                            <span class="material-icons-round text-gray-400 text-lg transition-transform"
                                :class="{ 'rotate-180': open }">sort</span>
                        </button>

                        <div x-show="open" x-transition.opacity x-cloak
                            class="absolute z-30 w-full mt-1 bg-white border border-gray-100 rounded-lg shadow-xl overflow-hidden">

                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('name', 'asc')">Nama (A-Z)</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('name', 'desc')">Nama (Z-A)</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('stock', 'asc')">Stok (Sedikit-Banyak)</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('stock', 'desc')">Stok (Banyak-Sedikit)</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('created_at', 'desc')">Terbaru Ditambahkan</a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="setSort('created_at', 'asc')">Terlama Ditambahkan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Table Card -->
    <div id="medicine-table-results" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php $__empty_1 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if($loop->first): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Produk</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Kategori</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Harga</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wide">Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wide">Terjual</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wide">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
            <?php endif; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                                        <?php if($item->image): ?>
                                            <img src="<?php echo e(Storage::disk('public')->url($item->image)); ?>" alt="<?php echo e($item->name); ?>"
                                                class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <span class="material-icons-round text-gray-400">medication</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800"><?php echo e($item->name); ?></p>
                                        <p class="text-xs text-gray-500">#<?php echo e($item->id); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#6200EA]/10 text-[#6200EA] whitespace-nowrap">
                                    <?php echo e($item->category); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php if($item->stock <= 5): ?>
                                    <span
                                        class="inline-flex items-center gap-1 text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded-full text-xs">
                                        <span class="material-icons-round text-[14px]">warning</span>
                                        <?php echo e($item->stock); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-600"><?php echo e($item->stock); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                <?php echo e($item->total_sold ?? 0); ?>

                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openMedicineDetailModal(<?php echo e($item->id); ?>)"
                                        class="p-1.5 text-gray-500 hover:text-[#6200EA] hover:bg-[#6200EA]/10 rounded-lg transition-colors"
                                        title="Lihat Detail">
                                        <span class="material-icons-round text-lg">visibility</span>
                                    </button>
                                    <button onclick="openMedicineEditModal(<?php echo e($item->id); ?>)"
                                        class="p-1.5 text-gray-500 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <span class="material-icons-round text-lg">edit</span>
                                    </button>
                                    <button onclick="deleteMedicine(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->name)); ?>')"
                                        class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Hapus">
                                        <span class="material-icons-round text-lg">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php if($loop->last): ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                                <?php echo e($medicines->links()); ?>

                            </div>
                        <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <span class="material-icons-round text-3xl text-gray-400">inventory_2</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Obat Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Sepertinya Anda belum menambahkan obat apa pun, atau tidak ada hasil yang
                    cocok dengan pencarian Anda.</p>
                <button onclick="openMedicineModal()"
                    class="px-4 py-2 bg-[#6200EA] text-white text-sm font-bold rounded-lg hover:bg-[#5000C0] transition-colors shadow-sm">
                    Tambah Obat Baru
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal"
        class="hidden fixed inset-0 bg-gray-900/50 z-[70] flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6 animate-[scaleIn_0.2s_ease-out]">
            <div class="text-center">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-icons-round text-2xl text-red-600">delete_forever</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Obat?</h3>
                <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus <strong id="deleteItemName"
                        class="text-gray-800"></strong>? Tindakan ini tidak dapat dibatalkan.</p>

                <div class="flex gap-3 justify-center">
                    <button onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-bold rounded-lg hover:bg-gray-200 transition-colors">
                        Batal
                    </button>
                    <button id="confirmDeleteBtn"
                        class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                        <span id="deleteBtnIcon" class="material-icons-round text-sm">delete</span>
                        <span id="deleteBtnText">Hapus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Keeping existing JS logic but updating classes where necessary
        let deleteItemId = null;

        // Refresh medicine table function
        function refreshMedicineTable() {
            const currentUrl = new URL(window.location.href);

            fetch(currentUrl.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newResults = doc.querySelector('#medicine-table-results');
                    const currentResults = document.querySelector('#medicine-table-results');
                    if (newResults && currentResults) {
                        currentResults.innerHTML = newResults.innerHTML;
                    }
                })
                .catch(error => {
                    console.error('Refresh error:', error);
                });
        }

        // Delete medicine function
        function deleteMedicine(id, name) {
            deleteItemId = id;
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteConfirmModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').classList.add('hidden');
            deleteItemId = null;
        }

        // Confirm delete
        document.getElementById('confirmDeleteBtn')?.addEventListener('click', function () {
            if (!deleteItemId) return;

            const btn = this;
            const btnIcon = document.getElementById('deleteBtnIcon');
            const btnText = document.getElementById('deleteBtnText');

            // Show loading
            btn.disabled = true;
            btnIcon.textContent = 'hourglass_empty';
            btnIcon.classList.add('animate-spin');
            btnText.textContent = 'Menghapus...';

            fetch(`<?php echo e(url('/admin/medicines')); ?>/${deleteItemId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                }
            })
                .then(response => response.json())
                .then(data => {
                    closeDeleteModal();
                    if (data.success) {
                        showToast('success', data.message);
                        refreshMedicineTable();
                    } else {
                    showToast('error', data.message || 'Gagal menghapus');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    closeDeleteModal();
                    showToast('error', 'Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btnIcon.textContent = 'delete';
                    btnIcon.classList.remove('animate-spin');
                    btnText.textContent = 'Hapus';
                });
        });
    </script>

    <?php $__env->startPush('modals'); ?>
        <?php echo $__env->make('components.detail_obat', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.medicine.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('admin.medicine.edit', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/medicine/index.blade.php ENDPATH**/ ?>