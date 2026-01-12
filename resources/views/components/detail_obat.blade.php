{{-- Modal Detail Obat - Material Design --}}
<div id="medicineDetailModal"
    class="hidden fixed inset-0 bg-gray-900/50 z-[60] flex items-center justify-center p-4 backdrop-blur-sm">

    <div class="relative mx-auto w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden animate-[scaleIn_0.2s_ease-out]"
        style="max-height: 90vh;">

        <!-- Header -->
        <div class="relative bg-gradient-to-r from-[#6200EA] to-[#3700B3] px-6 py-4 overflow-hidden shrink-0">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div class="relative z-10 flex justify-between items-center text-white">
                <div>
                    <h3 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-icons-round bg-white/20 p-1.5 rounded-lg">medication</span>
                        Detail Obat
                    </h3>
                </div>
                <button onclick="closeMedicineDetailModal()"
                    class="text-white/70 hover:text-white hover:bg-white/10 transition-all p-2 rounded-full transform hover:rotate-90">
                    <span class="material-icons-round">close</span>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div id="medicineDetailContent" class="p-6 overflow-y-auto bg-gray-50/50"
            style="max-height: calc(90vh - 70px);">
            {{-- Loading State --}}
            <div class="flex flex-col justify-center items-center py-20">
                <span class="material-icons-round text-4xl text-[#6200EA] animate-spin mb-3">refresh</span>
                <p class="text-gray-500 font-medium">Memuat detail...</p>
            </div>
        </div>
    </div>
</div>

<script>
    function openMedicineDetailModal(medicineId) {
        const modal = document.getElementById('medicineDetailModal');
        const content = document.getElementById('medicineDetailContent');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Reset to Loading State
        content.innerHTML = `
            <div class="flex flex-col justify-center items-center py-20">
                <span class="material-icons-round text-4xl text-[#6200EA] animate-spin mb-3">refresh</span>
                <p class="text-gray-500 font-medium">Memuat detail...</p>
            </div>
        `;

        // Fetch Data
        fetch(`/admin/medicines/${medicineId}/detail`)
            .then(response => {
                if (!response.ok) throw new Error('Primary URL failed');
                return response.json();
            })
            .then(data => {
                content.innerHTML = generateDetailHTML(data);
            })
            .catch(error => {
                console.log('Trying secondary URL...', error);
                return fetch(`/cashier/transaction/medicines/${medicineId}/detail`)
                    .then(response => response.json())
                    .then(data => {
                        content.innerHTML = generateDetailHTML(data);
                    });
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                            <span class="material-icons-round text-3xl text-red-500">error_outline</span>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800">Gagal memuat data</h4>
                        <p class="text-gray-500 mt-1">Silakan periksa koneksi Anda dan coba lagi.</p>
                    </div>
                `;
            });
    }

    function generateDetailHTML(medicine) {
        const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(medicine.price);

        return `
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left: Image & Key Info -->
                <div class="space-y-6">
                    <div class="bg-white p-4 rounded-xl border border-purple-100 shadow-sm text-center relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute top-0 left-0 w-full h-1 bg-[#6200EA]"></div>
                        ${medicine.image
                ? `<img src="${medicine.image}" alt="${medicine.name}" class="w-full h-48 object-contain rounded-lg mb-4">`
                : `<div class="w-full h-48 bg-purple-50/50 rounded-lg flex items-center justify-center mb-4 border border-dashed border-purple-100">
                                <span class="material-icons-round text-6xl text-purple-200">image_not_supported</span>
                               </div>`
            }
                        <h4 class="text-lg font-bold text-gray-800">${medicine.name}</h4>
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-bold rounded-full bg-purple-100 text-[#6200EA]">
                            ${medicine.category}
                        </span>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                         <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-500 text-sm flex items-center gap-2">
                                <span class="material-icons-round text-sm text-[#6200EA]">monetization_on</span> Harga
                            </span>
                            <span class="font-bold text-gray-800">${rupiah}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-500 text-sm">Stok</span>
                            <span class="font-bold ${medicine.stock <= 5 ? 'text-red-500' : 'text-gray-800'}">
                                ${medicine.stock} Unit
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-500 text-sm">Terjual</span>
                            <span class="font-bold text-[#6200EA]">${medicine.total_sold || 0} Unit</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Detailed Info -->
                <div class="md:col-span-2 space-y-4">
                    <!-- Cards Loop -->
                    ${generateInfoCard('Deskripsi', 'info', medicine.description)}
                    ${generateInfoCard('Indikasi & Manfaat', 'check_circle', medicine.full_indication, 'text-green-600', 'bg-green-50')}
                    ${generateInfoCard('Penggunaan & Dosis', 'medication', medicine.usage_detail, 'text-blue-600', 'bg-blue-50')}
                    ${generateInfoCard('Efek Samping', 'warning', medicine.side_effects, 'text-orange-500', 'bg-orange-50')}
                    ${generateInfoCard('Kontraindikasi', 'block', medicine.contraindications, 'text-red-500', 'bg-red-50')}
                </div>
            </div>
        `;
    }

    function generateInfoCard(title, icon, content, iconColor = 'text-[#6200EA]', iconBg = 'bg-purple-50') {
        if (!content || content.trim() === '-') return '';
        return `
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm">
                <h5 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                    <div class="w-8 h-8 ${iconBg} rounded-lg flex items-center justify-center">
                        <span class="material-icons-round ${iconColor} text-lg">${icon}</span>
                    </div>
                    ${title}
                </h5>
                <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">${content}</p>
            </div>
        `;
    }

    function closeMedicineDetailModal() {
        const modal = document.getElementById('medicineDetailModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMedicineDetailModal();
    });
</script>