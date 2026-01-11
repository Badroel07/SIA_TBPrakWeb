@extends('customer.layouts.app')

@section('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet Geocoder (Search) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
@endsection

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Pengaturan Akun
            </h1>
            <p class="text-gray-500 mt-2">Kelola informasi pribadi dan alamat pengiriman Anda</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex items-center gap-3 text-green-700">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200" x-data="profilePage()">
            <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Personal Info Section -->
                <div class="space-y-6">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 border-b pb-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .88.716 3 3 3s3-2.12 3-3m-8 0h.01M19 16v3"></path>
                        </svg>
                        Informasi Pribadi
                    </h2>
                    
                    <div class="grid md:grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors"
                                placeholder="08xxxxxxxxxx">
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                <!-- Address Section -->
                <div class="space-y-6 pt-4">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2 border-b pb-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat Utama
                    </h2>
                    
                    <p class="text-sm text-gray-500">Alamat ini akan digunakan sebagai default saat Anda melakukan checkout.</p>

                    <!-- Address Dropdowns -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Province -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                            <select x-model="form.province" @change="fetchCities" name="province"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors bg-white">
                                <option value="">Pilih Provinsi</option>
                                <template x-for="prov in provinces" :key="prov.id">
                                    <option :value="prov.name" :data-id="prov.id" x-text="prov.name" :selected="prov.name == form.province"></option>
                                </template>
                            </select>
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kota/Kabupaten</label>
                            <select x-model="form.city" @change="fetchDistricts" :disabled="!form.province" name="city"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors bg-white disabled:bg-gray-100">
                                <option value="">Pilih Kota/Kabupaten</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option :value="city.name" :data-id="city.id" x-text="city.name" :selected="city.name == form.city"></option>
                                </template>
                            </select>
                        </div>

                        <!-- District -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
                            <select x-model="form.district" @change="fetchVillages" :disabled="!form.city" name="district"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors bg-white disabled:bg-gray-100">
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="dist in districts" :key="dist.id">
                                    <option :value="dist.name" :data-id="dist.id" x-text="dist.name" :selected="dist.name == form.district"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Village -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Desa/Kelurahan</label>
                            <select x-model="form.village" :disabled="!form.district" name="village"
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors bg-white disabled:bg-gray-100">
                                <option value="">Pilih Desa/Kelurahan</option>
                                <template x-for="vill in villages" :key="vill.id">
                                    <option :value="vill.name" :data-id="vill.id" x-text="vill.name" :selected="vill.name == form.village"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <!-- Street Address -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Jalan / Detail</label>
                        <textarea name="street_address" x-model="form.street_address" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-colors resize-none"
                            placeholder="Contoh: Jl. Kaliurang Km. 5, Gg. Megatruh No. 12">{{ old('street_address', $user->street_address) }}</textarea>
                    </div>

                     <!-- Map Section -->
                     <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Peta</label>
                         <div id="map" class="h-64 w-full rounded-xl border-2 border-gray-200 z-10"></div>
                         <p class="text-xs text-gray-500 mt-1" x-show="form.latitude && form.longitude">
                            Koordinat: <span x-text="form.latitude"></span>, <span x-text="form.longitude"></span>
                         </p>
                         <!-- Hidden Inputs -->
                         <input type="hidden" name="latitude" x-model="form.latitude">
                         <input type="hidden" name="longitude" x-model="form.longitude">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-6 flex justify-end">
                    <button type="submit" 
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-lg rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function profilePage() {
        return {
            map: null,
            marker: null,
            provinces: [],
            cities: [],
            districts: [],
            villages: [],

            form: {
                phone_number: @json(old('phone_number', $user->phone_number ?? '')),
                street_address: @json(old('street_address', $user->street_address ?? '')),
                province: @json(old('province', $user->province ?? '')),
                city: @json(old('city', $user->city ?? '')),
                district: @json(old('district', $user->district ?? '')),
                village: @json(old('village', $user->village ?? '')),
                latitude: @json(old('latitude', $user->latitude ?? '')),
                longitude: @json(old('longitude', $user->longitude ?? ''))
            },

            async init() {
                // Initialize Map
                const defaultLat = this.form.latitude ? parseFloat(this.form.latitude) : -7.7956;
                const defaultLng = this.form.longitude ? parseFloat(this.form.longitude) : 110.3695;

                this.map = L.map('map').setView([defaultLat, defaultLng], 13);
                
                setTimeout(() => { this.map.invalidateSize(); }, 250);

                L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(this.map);

                // Add Search Control
                L.Control.geocoder({
                    defaultMarkGeocode: false,
                }).on('markgeocode', (e) => {
                    const latlng = e.geocode.center;
                    this.map.setView(latlng, 16);
                    this.marker.setLatLng(latlng);
                    this.updateCoordinates(latlng.lat, latlng.lng);
                }).addTo(this.map);

                // Marker
                this.marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(this.map);

                this.marker.on('dragend', (event) => {
                    var position = this.marker.getLatLng();
                    this.updateCoordinates(position.lat, position.lng);
                });
                
                 this.map.on('click', (e) => {
                    this.marker.setLatLng(e.latlng);
                    this.updateCoordinates(e.latlng.lat, e.latlng.lng);
                });

                // Fetch Provinces
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

            async fetchProvinces() {
                try {
                    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await response.json();
                } catch (e) { console.error(e); }
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
        }
    }
</script>
@endsection
