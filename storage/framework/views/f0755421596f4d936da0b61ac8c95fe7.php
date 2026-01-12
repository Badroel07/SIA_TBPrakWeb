
<div id="medicineEditModal"
    class="hidden fixed inset-0 bg-gray-900/50 z-[60] flex items-center justify-center p-4 backdrop-blur-sm">

    <div id="editModalContent"
        class="relative mx-auto w-full max-w-3xl bg-white rounded-xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col"
        style="max-height: 90vh;">

        <!-- Header -->
        <div class="relative bg-gradient-to-r from-[#6200EA] to-[#3700B3] px-6 py-4 overflow-hidden shrink-0">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="relative z-10 flex justify-between items-center text-white">
                <div>
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-icons-round bg-white/20 p-1.5 rounded-lg">edit</span>
                        Edit Obat
                    </h3>
                    <p class="text-purple-100 text-xs mt-1 ml-11">Perbarui detail inventaris.</p>
                </div>
                <button onclick="closeEditMedicineModal()"
                    class="text-white/70 hover:text-white hover:bg-white/10 transition-all p-2 rounded-full transform hover:rotate-90">
                    <span class="material-icons-round">close</span>
                </button>
            </div>
        </div>

        <!-- Form Content -->
        <div class="overflow-y-auto p-6 bg-gray-50/50 flex-grow">
            <form id="editMedicineForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Error Alert Placeholder -->
                <div id="editErrorContainer"
                    class="hidden animate-bounce-in bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm mb-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-red-100 text-red-500 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-icons-round">error_outline</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Gagal Memperbarui</h4>
                            <ul id="editErrorList" class="text-xs text-red-700 mt-1 list-disc list-inside"></ul>
                        </div>
                    </div>
                </div>

                <!-- Basic Information Section -->
                <div
                    class="bg-white p-5 rounded-xl border border-purple-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 left-0 w-1 h-full bg-[#6200EA]"></div>
                    <h4
                        class="text-sm font-bold text-gray-900 mb-5 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span
                            class="w-8 h-8 rounded-lg text-[#6200EA] flex items-center justify-center text-lg material-icons-round">local_offer</span>
                        Informasi Dasar
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <!-- Name -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Nama Obat</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3.5 top-2.5 text-gray-400 material-icons-round text-sm">badge</span>
                                <input type="text" name="name" id="edit-name" required
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-4 focus:ring-purple-50 transition-all outline-none font-medium">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Kategori</label>
                            <select name="category" id="edit-category-select2" class="w-full">
                                <option value="">Pilih Kategori...</option>
                                <?php $__currentLoopData = $existingCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat); ?>"><?php echo e($cat); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Price -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Harga</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-2.5 text-[#6200EA] font-bold text-sm">Rp</span>
                                <input type="number" name="price" id="edit-price" required min="0"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-4 focus:ring-purple-50 transition-all outline-none font-medium">
                            </div>
                        </div>

                        <!-- Current Stock (Read Only) -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Stok Saat Ini</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3.5 top-2.5 text-gray-400 material-icons-round text-sm">inventory</span>
                                <input type="text" id="edit-current-stock" disabled
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-100 border border-gray-200 rounded-xl text-sm text-gray-500 cursor-not-allowed font-medium">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Management Section -->
                <div class="bg-[#6200EA]/5 rounded-xl p-5 border border-[#6200EA]/20 relative overflow-hidden group hover:shadow-md transition-shadow"
                    x-data="{ mode: 'adjust' }">
                    <div class="absolute top-0 left-0 w-1 h-full bg-[#6200EA]"></div>
                    <div class="flex items-center justify-between mb-4 border-b border-[#6200EA]/20 pb-3">
                        <h4 class="text-sm font-bold text-[#3700B3] flex items-center gap-2">
                            <span
                                class="w-8 h-8 rounded-lg text-[#6200EA] flex items-center justify-center text-lg material-icons-round">inventory_2</span>
                            Manajemen Stok
                        </h4>

                        <div class="bg-white rounded-lg p-1 flex shadow-sm border border-[#6200EA]/30">
                            <button type="button"
                                @click="mode = 'adjust'; document.getElementById('edit-stock-manual').value = ''"
                                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all"
                                :class="mode === 'adjust' ? 'bg-[#6200EA] text-white shadow-sm' : 'text-gray-500 hover:bg-[#6200EA]/10'">
                                Atur (+/-)
                            </button>
                            <button type="button"
                                @click="mode = 'manual'; document.getElementById('edit-stock-adjustment').value = ''"
                                class="px-3 py-1.5 text-xs font-bold rounded-md transition-all"
                                :class="mode === 'manual' ? 'bg-[#6200EA] text-white shadow-sm' : 'text-gray-500 hover:bg-[#6200EA]/10'">
                                Stok Tetap
                            </button>
                        </div>
                    </div>

                    <!-- Adjust Mode -->
                    <div x-show="mode === 'adjust'" class="animate-[fadeIn_0.2s_ease-out]">
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-[#6200EA] font-bold text-sm">+/-</span>
                            <input type="number" name="stock_adjustment" id="edit-stock-adjustment"
                                placeholder="contoh: +10 (tambah), -5 (kurang)"
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#6200EA]/30 rounded-xl text-sm text-gray-800 focus:border-[#6200EA] focus:ring-4 focus:ring-[#6200EA]/10 transition-all outline-none font-medium">
                        </div>


                    </div>

                    <!-- Manual Mode -->
                    <div x-show="mode === 'manual'" class="animate-[fadeIn_0.2s_ease-out]" style="display: none;">
                        <input type="number" name="stock_manual" id="edit-stock-manual" min="0"
                            placeholder="Masukkan jumlah stok baru"
                            class="w-full px-4 py-2.5 bg-white border border-[#6200EA]/30 rounded-xl text-sm text-gray-800 focus:border-[#6200EA] focus:ring-4 focus:ring-[#6200EA]/10 transition-all outline-none font-medium">
                        <p
                            class="text-xs text-[#6200EA] mt-2 flex items-center gap-1 font-medium bg-[#6200EA]/10 p-2 rounded-lg inline-block">
                            <span class="material-icons-round text-[14px]">info</span>
                            Ini akan menimpa stok saat ini.
                        </p>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200 shadow-sm relative overflow-hidden">
                    <h4
                        class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2 border-b border-gray-200 pb-2">
                        <span class="material-icons-round text-gray-500 text-lg">image</span>
                        Gambar Produk
                    </h4>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-20 h-20 bg-white rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden shrink-0">
                            <img id="edit-current-image" src="" class="w-full h-full object-cover hidden">
                            <span id="edit-no-image"
                                class="material-icons-round text-3xl text-gray-300">image_not_supported</span>
                        </div>
                        <div class="flex-grow">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Ubah Gambar</label>
                            <input type="file" name="image" id="edit-image-input" accept="image/*" class="block w-full text-xs text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-purple-50 file:text-purple-700
                                hover:file:bg-purple-100
                            " />
                        </div>
                    </div>
                </div>

                <!-- Detailed Information Section -->
                <div>
                    <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span
                            class="w-8 h-8 rounded-lg text-[#6200EA] flex items-center justify-center text-lg material-icons-round">description</span>
                        Detail Medis
                    </h4>

                    <div class="space-y-4">
                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Deskripsi Singkat</label>
                            <textarea name="description" id="edit-description" rows="2"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none resize-none"></textarea>
                        </div>
                        <!-- Indication -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Indikasi & Manfaat</label>
                            <textarea name="full_indication" id="edit-full_indication" rows="3"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none resize-none"></textarea>
                        </div>
                        <!-- Usage -->
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Penggunaan & Dosis</label>
                            <textarea name="usage_detail" id="edit-usage_detail" rows="2"
                                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Side Effects -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Efek Samping</label>
                                <textarea name="side_effects" id="edit-side_effects" rows="3"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none resize-none"></textarea>
                            </div>
                            <!-- Contraindications -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">Kontraindikasi</label>
                                <textarea name="contraindications" id="edit-contraindications" rows="3"
                                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
        </div>

        <!-- Footer Actions (Fixed) -->
        <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end gap-3 shrink-0 z-20">
            <button type="button" onclick="closeEditMedicineModal()"
                class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                Batal
            </button>
            <button type="submit" form="editMedicineForm" id="editMedicineSubmit"
                class="px-6 py-2.5 text-sm font-bold text-white bg-[#6200EA] hover:bg-[#5000C0] rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <span id="editBtnIcon" class="material-icons-round text-sm">save</span>
                <span id="editBtnText">Simpan Perubahan</span>
            </button>
        </div>
    </div>
</div>

<style>
    /* Custom Select2 Styling to match Tailwind Inputs */
    .select2-container--default .select2-selection--single {
        border-color: #E5E7EB !important;
        background-color: #F9FAFB !important;
        border-radius: 0.75rem !important;
        /* rounded-xl */
        height: 46px !important;
        /* Match input height py-2.5 + text-sm */
        display: flex !important;
        align-items: center !important;
        padding-left: 0.5rem !important;
    }

    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #6200EA !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 4px rgba(98, 0, 234, 0.1) !important;
    }

    .select2-selection__arrow {
        height: 44px !important;
        top: 0 !important;
        right: 8px !important;
    }

    .select2-selection__rendered {
        line-height: 46px !important;
        padding-left: 8px !important;
        color: #1f2937 !important;
        /* text-gray-800 */
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        /* text-sm */
    }

    .select2-dropdown {
        border-color: #E5E7EB !important;
        border-radius: 0.75rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        overflow: hidden !important;
        margin-top: 4px !important;
    }

    .select2-results__option {
        padding: 8px 12px !important;
        font-size: 0.875rem !important;
    }

    .select2-results__option--highlighted {
        background-color: #6200EA !important;
        color: white !important;
    }
</style>

<script>
    const baseUrl = "<?php echo e(url('/')); ?>";

    $(document).ready(function () {



        // AJAX Submit
        document.getElementById('editMedicineForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const submitBtn = document.getElementById('editMedicineSubmit');
            const btnIcon = document.getElementById('editBtnIcon');
            const btnText = document.getElementById('editBtnText');
            const errorContainer = document.getElementById('editErrorContainer');
            const errorList = document.getElementById('editErrorList');

            // Reset UI
            submitBtn.disabled = true;
            btnIcon.textContent = 'hourglass_empty';
            btnIcon.classList.add('animate-spin');
            btnText.textContent = 'Memperbarui...';
            errorContainer.classList.add('hidden');
            errorList.innerHTML = '';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST', // Method spoofing is handled by <?php echo method_field('PUT'); ?> in blade, but FormData needs POST
                body: formData, // FormData automatically sets Content-Type multipart/form-data
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 200 && body.success) {
                        closeEditMedicineModal();
                        if (typeof showToast === 'function') {
                            showToast('success', body.message);
                        } else {
                            alert(body.message);
                        }
                        if (typeof refreshMedicineTable === 'function') {
                            refreshMedicineTable();
                        }
                    } else if (status === 422) {
                        // Validation Errors
                        if (body.errors) {
                            Object.values(body.errors).forEach(errors => {
                                errors.forEach(err => {
                                    const li = document.createElement('li');
                                    li.textContent = err;
                                    errorList.appendChild(li);
                                });
                            });
                        } else if (body.message) {
                            const li = document.createElement('li');
                            li.textContent = body.message;
                            errorList.appendChild(li);
                        }
                        errorContainer.classList.remove('hidden');
                        document.getElementById('editModalContent').parentElement.scrollTop = 0;
                    } else {
                        throw new Error('Server error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('error', 'Update failed. Please try again.');
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    btnIcon.textContent = 'save';
                    btnIcon.classList.remove('animate-spin');
                    btnText.textContent = 'Simpan Perubahan';
                });
        });

        // Image Preview Listener
        const editImgInput = document.getElementById('edit-image-input');
        const editImgPreview = document.getElementById('edit-current-image');
        const editNoImg = document.getElementById('edit-no-image');

        if (editImgInput) {
            editImgInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (editImgPreview && editNoImg) {
                            editImgPreview.src = e.target.result;
                            editImgPreview.classList.remove('hidden');
                            editNoImg.classList.add('hidden');
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    function initEditSelect2(currentCategory) {
        const select = $('#edit-category-select2');
        if (select.data('select2')) {
            select.select2('destroy');
        }

        const categoryToSelect = currentCategory || '';
        // Add option if not exists
        if (categoryToSelect && select.find('option[value="' + categoryToSelect + '"]').length === 0) {
            const newOption = new Option(categoryToSelect, categoryToSelect, true, true);
            select.append(newOption);
        }

        select.select2({
            placeholder: "Pilih atau ketik kategori...",
            dropdownParent: $('#medicineEditModal'),
            allowClear: true,
            tags: true,
            width: '100%'
        });

        select.val(categoryToSelect).trigger('change');
    }

    function openMedicineEditModal(id) {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');
        const form = document.getElementById('editMedicineForm');

        form.reset();
        document.getElementById('editErrorContainer').classList.add('hidden');
        document.getElementById('edit-stock-adjustment').value = '';
        if (document.getElementById('edit-stock-manual')) document.getElementById('edit-stock-manual').value = '';

        // Load Data
        $.getJSON(baseUrl + '/admin/medicines/' + id + '/detail', function (data) {
            form.action = baseUrl + '/admin/medicines/' + id;

            // Populate Fields
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-price').value = data.price;
            document.getElementById('edit-current-stock').value = data.stock + ' Units';

            document.getElementById('edit-description').value = data.description || '';
            document.getElementById('edit-full_indication').value = data.full_indication || '';
            document.getElementById('edit-usage_detail').value = data.usage_detail || '';
            document.getElementById('edit-side_effects').value = data.side_effects || '';
            document.getElementById('edit-contraindications').value = data.contraindications || '';

            // Handle Image
            const img = document.getElementById('edit-current-image');
            const noImgSpan = document.getElementById('edit-no-image');

            if (data.image) {
                img.src = data.image_url || data.image; // Use helper if available, or direct path logic
                // Ensure helper creates correct public URL if needed
                if (!img.src.startsWith('http')) img.src = '/storage/' + data.image;

                img.classList.remove('hidden');
                noImgSpan.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                noImgSpan.classList.remove('hidden');
            }

            // Init Select2
            initEditSelect2(data.category);

            // Show Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    function closeEditMedicineModal() {
        const modal = document.getElementById('medicineEditModal');
        const modalContent = document.getElementById('editModalContent');

        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
</script><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/medicine/edit.blade.php ENDPATH**/ ?>