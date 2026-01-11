@extends('customer.layouts.app')

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet Geocoder (Search) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endsection

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-full mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Checkout
            </h1>
            <p class="text-gray-500 mt-2">Lengkapi data pengiriman untuk melanjutkan pesanan</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8" x-data="checkoutPage()">
            
            <!-- Shipping Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Pengiriman
                    </h2>

                    <form @submit.prevent="processCheckout" class="space-y-4">
                        <!-- Recipient Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penerima</label>
                            <input type="text" x-model="form.recipient_name" readonly
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none"
                                placeholder="Nama lengkap penerima">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" x-model="form.recipient_phone" readonly
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none"
                                placeholder="08xxxxxxxxxx">
                        </div>

                        <!-- Address Dropdowns -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Province -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                                <select x-model="form.province" @change="fetchCities" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none transition-colors">
                                    <option value="">Pilih Provinsi</option>
                                    <template x-for="prov in provinces" :key="prov.id">
                                        <option :value="prov.name" :data-id="prov.id" x-text="prov.name"></option>
                                    </template>
                                </select>
                            </div>
    
                            <!-- City -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kota/Kabupaten</label>
                                <select x-model="form.city" @change="fetchDistricts" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none transition-colors">
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    <template x-for="city in cities" :key="city.id">
                                        <option :value="city.name" :data-id="city.id" x-text="city.name"></option>
                                    </template>
                                </select>
                            </div>
    
                            <!-- District -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
                                <select x-model="form.district" @change="fetchVillages" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none transition-colors">
                                    <option value="">Pilih Kecamatan</option>
                                    <template x-for="dist in districts" :key="dist.id">
                                        <option :value="dist.name" :data-id="dist.id" x-text="dist.name"></option>
                                    </template>
                                </select>
                            </div>
    
                            <!-- Village -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Desa/Kelurahan</label>
                                <select x-model="form.village" disabled
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none transition-colors">
                                    <option value="">Pilih Desa/Kelurahan</option>
                                    <template x-for="vill in villages" :key="vill.id">
                                        <option :value="vill.name" :data-id="vill.id" x-text="vill.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Street Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Jalan / Detail (Jalan, No. Rumah, RT/RW)</label>
                            <textarea x-model="form.street_address" readonly rows="3"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-100 text-gray-500 cursor-not-allowed focus:outline-none transition-colors resize-none"
                                placeholder="Contoh: Jl. Kaliurang Km. 5, Gg. Megatruh No. 12, RT 04 RW 02"></textarea>
                            <p class="text-sm text-gray-500 mt-1">Pengiriman hanya mencakup area lokal (Flat Rate Rp {{ number_format($fixedShippingCost, 0, ',', '.') }}).</p>
                        </div>

                        <!-- Map Section (Read Only) -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Pengiriman</label>
                            @if($user->latitude && $user->longitude)
                             <div id="map" class="h-48 w-full rounded-xl border-2 border-gray-200 z-10"></div>
                             <p class="text-xs text-gray-500 mt-1">
                                Koordinat: <span x-text="form.latitude"></span>, <span x-text="form.longitude"></span>
                                <span class="text-blue-600 ml-2">(Dari Pengaturan Akun)</span>
                             </p>
                            @else
                             <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl border border-yellow-200">
                                <p class="font-medium">Anda belum mengatur lokasi pinpoint.</p>
                                <p class="text-sm mt-1">Silakan atur lokasi di <a href="{{ route('customer.profile.edit') }}" class="text-blue-600 underline">Pengaturan Akun</a> terlebih dahulu.</p>
                             </div>
                            @endif
                             <!-- Hidden Inputs -->
                             <input type="hidden" x-model="form.latitude">
                             <input type="hidden" x-model="form.longitude">
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 sticky top-24">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                    <!-- Items -->
                    <div class="space-y-4 max-h-60 overflow-y-auto mb-6">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3 items-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                @if($item->medicine->image)
                                <img src="{{ asset('storage/' . $item->medicine->image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate">{{ $item->medicine->name }}</p>
                                <p class="text-gray-500 text-xs">{{ $item->quantity }}x @ Rp {{ number_format($item->medicine->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-gray-900 text-sm">Rp {{ number_format($item->medicine->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ongkos Kirim (Flat)</span>
                            <span class="font-medium text-green-600">Rp {{ number_format($fixedShippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t pt-3">
                            <span>Total</span>
                            <span class="text-blue-600" x-text="'Rp ' + formatNumber(totalAmount)"></span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <button 
                        @click="processCheckout"
                        :disabled="loading"
                        class="w-full mt-6 py-4 px-6 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold text-lg rounded-xl shadow-lg shadow-green-500/30 transition-all disabled:opacity-50 flex items-center justify-center gap-2">
                        <template x-if="loading">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </template>
                        <template x-if="!loading">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </template>
                        <span x-text="loading ? 'Memproses...' : 'Bayar Sekarang'"></span>
                    </button>

                    <p class="text-xs text-gray-400 text-center mt-4">
                        Pembayaran akan diproses melalui Midtrans
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function checkoutPage() {
        return {
            loading: false,
            subtotal: {{ $subtotal }},
            shippingCost: {{ $fixedShippingCost }},
            map: null,
            marker: null,
            
            // Region Data
            provinces: [],
            cities: [],
            districts: [],
            villages: [],

            form: {
                recipient_name: @json($user->name ?? ''),
                recipient_phone: @json($user->phone_number ?? ''),
                street_address: @json($user->street_address ?? ''),
                province: @json($user->province ?? ''),
                city: @json($user->city ?? ''),
                district: @json($user->district ?? ''),
                village: @json($user->village ?? ''),
                latitude: @json($user->latitude ?? ''),
                longitude: @json($user->longitude ?? '')
            },

            get totalAmount() {
                return this.subtotal + this.shippingCost;
            },

            formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            },

            async init() {
                // Initialize Map (Read Only - from profile settings)
                const defaultLat = this.form.latitude ? parseFloat(this.form.latitude) : null;
                const defaultLng = this.form.longitude ? parseFloat(this.form.longitude) : null;

                // Only show map if coordinates exist
                if (defaultLat && defaultLng) {
                    this.map = L.map('map', {
                        dragging: false,
                        touchZoom: false,
                        scrollWheelZoom: false,
                        doubleClickZoom: false,
                        boxZoom: false,
                        keyboard: false,
                        zoomControl: true
                    }).setView([defaultLat, defaultLng], 15);
                    
                    setTimeout(() => {
                        this.map.invalidateSize();
                    }, 250);

                    const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        maxZoom: 20,
                        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                    });

                    googleStreets.addTo(this.map);

                    // Add static marker (not draggable)
                    this.marker = L.marker([defaultLat, defaultLng], {
                        draggable: false
                    }).addTo(this.map);
                }
                
                // Fetch Provinces on init
                await this.fetchProvinces();

                // Logic to pre-fill by using $nextTick to ensure options are rendered before setting value
                const savedProvince = this.form.province;
                const savedCity = this.form.city;
                const savedDistrict = this.form.district;
                const savedVillage = this.form.village;
                
                // Temporarily clear to allow Alpine to bind fresh
                this.form.province = '';
                this.form.city = '';
                this.form.district = '';
                this.form.village = '';

                // Wait for DOM update, then restore and chain fetches
                await this.$nextTick();

                if (savedProvince) {
                    const provId = this.findIdByName(this.provinces, savedProvince);
                    if (provId) {
                        const provObj = this.provinces.find(p => p.id === provId);
                        this.form.province = provObj.name;
                        
                        await this.$nextTick();
                        await this.fetchCities(null, true);
                        await this.$nextTick();
                        
                        if (savedCity) {
                            const cityId = this.findIdByName(this.cities, savedCity);
                            if (cityId) {
                                const cityObj = this.cities.find(c => c.id === cityId);
                                this.form.city = cityObj.name;

                                await this.$nextTick();
                                await this.fetchDistricts(null, true);
                                await this.$nextTick();

                                if (savedDistrict) {
                                    const distId = this.findIdByName(this.districts, savedDistrict);
                                    if (distId) {
                                        const distObj = this.districts.find(d => d.id === distId);
                                        this.form.district = distObj.name;

                                        await this.$nextTick();
                                        await this.fetchVillages(null, true);
                                        await this.$nextTick();

                                        if (savedVillage) {
                                            const villId = this.findIdByName(this.villages, savedVillage);
                                            if (villId) {
                                                const villObj = this.villages.find(v => v.id === villId);
                                                this.form.village = villObj.name;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            },

            updateCoordinates(lat, lng) {
                this.form.latitude = lat;
                this.form.longitude = lng;
            },

            findIdByName(array, name) {
                if (!name) return null;
                const item = array.find(i => i.name.toUpperCase() === name.toUpperCase().trim());
                return item ? item.id : null;
            },
            
            // --- Region Fetching Logic ---
            async fetchProvinces() {
                try {
                    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await response.json();
                } catch (e) {
                    console.error('Failed to fetch provinces', e);
                }
            },

            async fetchCities(e, isInit = false) {
                // Determine ID: from event or by finding ID from name if init
                let provinceId;
                if (isInit) {
                    provinceId = this.findIdByName(this.provinces, this.form.province);
                } else {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                     provinceId = selectedOption.dataset.id;
                     // Reset child fields on manual change
                     this.cities = []; this.districts = []; this.villages = [];
                     this.form.city = ''; this.form.district = ''; this.form.village = '';
                }

                if (provinceId) {
                    try {
                        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
                        this.cities = await response.json();
                    } catch (e) { console.error(e); }
                }
            },

            async fetchDistricts(e, isInit = false) {
                let cityId;
                if (isInit) {
                    cityId = this.findIdByName(this.cities, this.form.city);
                } else {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    cityId = selectedOption.dataset.id;
                    this.districts = []; this.villages = [];
                    this.form.district = ''; this.form.village = '';
                }

                if (cityId) {
                    try {
                        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`);
                        this.districts = await response.json();
                    } catch (e) { console.error(e); }
                }
            },

            async fetchVillages(e, isInit = false) {
                let districtId;
                if (isInit) {
                    districtId = this.findIdByName(this.districts, this.form.district);
                } else {
                    const selectedOption = e.target.options[e.target.selectedIndex];
                    districtId = selectedOption.dataset.id;
                    this.villages = [];
                    this.form.village = '';
                }

                if (districtId) {
                    try {
                        const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`);
                        this.villages = await response.json();
                    } catch (e) { console.error(e); }
                }
            },

            async processCheckout() {
                if (!this.form.recipient_name || !this.form.recipient_phone || !this.form.street_address || 
                    !this.form.province || !this.form.city || !this.form.district || !this.form.village) {
                    alert('Mohon lengkapi semua data pengiriman (termasuk wilayah).');
                    return;
                }
                
                if (!this.form.latitude || !this.form.longitude) {
                    alert('Mohon tentukan lokasi pengiriman pada peta.');
                    return;
                }

                this.loading = true;
                try {
                    const response = await fetch('{{ route("customer.checkout.process") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();

                    if (data.success) {
                         if (data.snap_token) {
                            snap.pay(data.snap_token, {
                                onSuccess: function(result){
                                    window.location.href = data.redirect_url + '?status=success';
                                },
                                onPending: function(result){
                                    window.location.href = data.redirect_url + '?status=pending';
                                },
                                onError: function(result){
                                    alert("Pembayaran gagal!");
                                    console.log(result);
                                },
                                onClose: function(){
                                    // User closed the popup without finishing
                                }
                            });
                        } else {
                             alert(data.message);
                             window.location.href = data.redirect_url;
                        }
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    console.error(error);
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endsection
