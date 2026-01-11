
<div id="medicineModal"
    class="hidden fixed inset-0 bg-gray-900/50 z-[60] flex items-center justify-center p-4 backdrop-blur-sm">

    <div id="modalContent"
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
                        <span class="material-icons-round bg-white/20 p-1.5 rounded-lg">add_circle</span>
                        Tambah Obat Baru
                    </h3>
                    <p class="text-purple-100 text-xs mt-1 ml-11">Isi detail untuk menambahkan ke inventaris.</p>
                </div>
                <button onclick="closeMedicineModal()"
                    class="text-white/70 hover:text-white hover:bg-white/10 transition-all p-2 rounded-full transform hover:rotate-90">
                    <span class="material-icons-round">close</span>
                </button>
            </div>
        </div>

        <!-- Form Content -->
        <div class="overflow-y-auto p-6 bg-gray-50/50 flex-grow">
            <form id="createMedicineForm" action="<?php echo e(route('admin.medicines.store')); ?>" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Error Alert Placeholder -->
                <div id="createErrorContainer"
                    class="hidden animate-bounce-in bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm mb-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-red-100 text-red-500 rounded-full flex items-center justify-center shrink-0">
                            <span class="material-icons-round">error_outline</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Kesalahan Input</h4>
                            <ul id="createErrorList" class="text-xs text-red-700 mt-1 list-disc list-inside"></ul>
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
                                <input type="text" name="name" required
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-4 focus:ring-purple-50 transition-all outline-none font-medium"
                                    placeholder="contoh: Paracetamol">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Kategori</label>
                            <select name="category" id="category_select2" class="w-full">
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
                                <input type="number" name="price" required min="0"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-4 focus:ring-purple-50 transition-all outline-none font-medium"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Stok Awal</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3.5 top-2.5 text-gray-400 material-icons-round text-sm">inventory</span>
                                <input type="number" name="stock" required min="0"
                                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-4 focus:ring-purple-50 transition-all outline-none font-medium"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="md:col-span-2 group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Gambar Produk</label>
                            <div class="relative">
                                <label id="image-upload-area"
                                    class="flex items-center justify-center w-full h-32 px-4 transition bg-purple-50/30 border-2 border-purple-100 border-dashed rounded-xl appearance-none cursor-pointer hover:border-[#6200EA] hover:bg-purple-50 focus:outline-none group-hover:shadow-inner overflow-hidden">

                                    <!-- Default Content -->
                                    <div id="image-upload-default" class="flex flex-col items-center space-y-1 py-4">
                                        <span
                                            class="material-icons-round text-purple-500 text-3xl group-hover:scale-110 transition-transform">cloud_upload</span>
                                        <span class="font-bold text-purple-700 text-sm">Klik untuk unggah gambar</span>
                                        <span class="text-xs text-gray-500">SVG, PNG, JPG atau GIF</span>
                                    </div>

                                    <!-- Preview Content -->
                                    <img id="image-upload-preview" src="#" alt="Preview"
                                        class="hidden h-full w-auto object-contain">

                                    <input type="file" name="image" id="create-image-input" class="hidden"
                                        accept="image/*">
                                </label>

                                <!-- Remove Button -->
                                <button type="button" id="remove-image-btn"
                                    class="hidden absolute top-2 right-2 bg-white/90 p-1.5 rounded-full text-red-500 hover:text-red-700 shadow-sm hover:shadow transition-all z-10">
                                    <span class="material-icons-round text-sm">close</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Detailed Information Section -->
                <div
                    class="bg-white p-5 rounded-xl border border-blue-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-500"></div>
                    <h4
                        class="text-sm font-bold text-gray-900 mb-5 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <span
                            class="w-8 h-8 rounded-lg text-blue-600 flex items-center justify-center text-lg material-icons-round">description</span>
                        Detail Medis
                    </h4>

                    <div class="space-y-4">
                        <!-- Description -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Deskripsi Singkat</label>
                            <textarea name="description" rows="2"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none"
                                placeholder="Ringkasan singkat untuk katalog..."></textarea>
                        </div>

                        <!-- Indication -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Indikasi & Manfaat</label>
                            <textarea name="full_indication" rows="3"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none"></textarea>
                        </div>

                        <!-- Usage -->
                        <div class="group">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Penggunaan & Dosis</label>
                            <textarea name="usage_detail" rows="2"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none"></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Side Effects -->
                            <div class="group">
                                <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Efek Samping</label>
                                <textarea name="side_effects" rows="3"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none"></textarea>
                            </div>
                            <!-- Contraindications -->
                            <div class="group">
                                <label
                                    class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Kontraindikasi</label>
                                <textarea name="contraindications" rows="3"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition-all outline-none resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
        </div>

        <!-- Footer Actions (Fixed) -->
        <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end gap-3 shrink-0 z-20">
            <button type="button" onclick="closeMedicineModal()"
                class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                Batal
            </button>
            <button type="submit" form="createMedicineForm" id="createMedicineSubmit"
                class="px-6 py-2.5 text-sm font-bold text-white bg-[#6200EA] hover:bg-[#5000C0] rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <span id="createBtnIcon" class="material-icons-round text-sm">save</span>
                <span id="createBtnText">Simpan Obat</span>
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
    $(document).ready(function () {
        // Initialize Select2
        initCreateSelect2();

        // AJAX Form Submission
        document.querySelector('#medicineModal form').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const submitBtn = document.getElementById('createMedicineSubmit');
            const btnIcon = document.getElementById('createBtnIcon');
            const btnText = document.getElementById('createBtnText');
            const errorContainer = document.getElementById('createErrorContainer');
            const errorList = document.getElementById('createErrorList');

            // Reset UI
            submitBtn.disabled = true;
            btnIcon.textContent = 'hourglass_empty';
            btnIcon.classList.add('animate-spin');
            btnText.textContent = 'Menyimpan...';
            errorContainer.classList.add('hidden');
            errorList.innerHTML = '';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json().then(data => ({ status: response.status, body: data })))
                .then(({ status, body }) => {
                    if (status === 200 && body.success) {
                        closeMedicineModal();
                        if (typeof showToast === 'function') {
                            showToast('success', body.message);
                        } else {
                            alert(body.message); // Fallback
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
                        document.getElementById('modalContent').parentElement.scrollTop = 0; // Scroll to top
                    } else {
                        throw new Error('Server error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof showToast === 'function') {
                        showToast('error', 'Something went wrong. Please try again.');
                    }
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    btnIcon.textContent = 'save';
                    btnIcon.classList.remove('animate-spin');
                    btnText.textContent = 'Simpan Obat';
                });
        });
        // Image Preview Logic
        const createImgInput = document.getElementById('create-image-input');
        const createImgPreview = document.getElementById('image-upload-preview');
        const createImgDefault = document.getElementById('image-upload-default');
        const createRemoveBtn = document.getElementById('remove-image-btn');

        if (createImgInput) {
            createImgInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        createImgPreview.src = e.target.result;
                        createImgPreview.classList.remove('hidden');
                        createImgDefault.classList.add('hidden');
                        createRemoveBtn.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            createRemoveBtn.addEventListener('click', function (e) {
                e.preventDefault();
                createImgInput.value = '';
                createImgPreview.src = '#';
                createImgPreview.classList.add('hidden');
                createImgDefault.classList.remove('hidden');
                createRemoveBtn.classList.add('hidden');
            });
        }
    });

    function initCreateSelect2() {
        $('#category_select2').select2({
            placeholder: "Pilih atau ketik kategori...",
            tags: true,
            dropdownParent: $('#medicineModal'),
            width: '100%'
        });
    }

    function openMedicineModal() {
        const modal = document.getElementById('medicineModal');
        const content = document.getElementById('modalContent');

        document.querySelector('#medicineModal form').reset();
        document.getElementById('createErrorContainer').classList.add('hidden');

        // Reset Image Preview
        const preview = document.getElementById('image-upload-preview');
        const def = document.getElementById('image-upload-default');
        const rmv = document.getElementById('remove-image-btn');
        if (preview) {
            preview.classList.add('hidden');
            preview.src = '#';
            def.classList.remove('hidden');
            rmv.classList.add('hidden');
        }

        $('#category_select2').val(null).trigger('change'); // Reset Select2

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeMedicineModal() {
        const modal = document.getElementById('medicineModal');
        const content = document.getElementById('modalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
</script><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/medicine/create.blade.php ENDPATH**/ ?>