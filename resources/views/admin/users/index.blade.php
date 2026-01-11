@extends('admin.layouts.app')

@section('title', 'Customer Management')

@section('content')

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Users</h2>
            <p class="text-gray-500 mt-1">Manage user accounts and roles.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.create') }}"
                class="flex items-center gap-2 px-4 py-2 bg-[#6200EA] text-white rounded-lg text-sm font-bold hover:bg-[#5000C0] transition-colors shadow-md shadow-purple-200">
                <span class="material-icons-round text-lg">add</span>
                Add User
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" x-data="{
                        searchTimeout: null,
                        loading: false,
                        performSearch() {
                            clearTimeout(this.searchTimeout);
                            this.searchTimeout = setTimeout(() => {
                                this.loading = true;
                                const formData = new FormData($el);
                                const params = new URLSearchParams(formData);

                                fetch('{{ route('admin.users.index') }}?' + params.toString(), {
                                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                                })
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newResults = doc.querySelector('#users-table-results');
                                    const currentResults = document.querySelector('#users-table-results');
                                    if (newResults && currentResults) { currentResults.innerHTML = newResults.innerHTML; }
                                    
                                    // Update URL without reloading
                                    window.history.pushState({}, '', '{{ route('admin.users.index') }}?' + params.toString());
                                    
                                    this.loading = false;
                                })
                                .catch(error => { console.error('Search error:', error); this.loading = false; });
                            }, 400);
                        }
                    }">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-5 relative group">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#6200EA] transition-colors">
                        <span class="material-icons-round">search</span>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..."
                        @input="performSearch()"
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-[#6200EA] focus:border-transparent focus:bg-white transition-all outline-none">
                </div>

                <!-- Role Filter -->
                <div class="md:col-span-4 relative"
                    x-data="{ open: false, selectedLabel: '{{ request('role') ? ucfirst(request('role')) : 'All Roles' }}', selectedValue: '{{ request('role') ?: '' }}' }"
                    @click.outside="open = false">

                    <input type="hidden" name="role" x-model="selectedValue" @change="performSearch()">

                    <button type="button" @click="open = !open"
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 flex justify-between items-center focus:ring-2 focus:ring-[#6200EA] transition-all hover:bg-white">
                        <span class="truncate" x-text="selectedLabel"></span>
                        <span class="material-icons-round text-gray-400 text-lg transition-transform"
                            :class="{ 'rotate-180': open }">expand_more</span>
                    </button>

                    <div x-show="open" x-transition.opacity
                        class="absolute z-30 w-full mt-1 bg-white border border-gray-100 rounded-lg shadow-xl max-h-60 overflow-y-auto">

                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                            @click.prevent="selectedLabel = 'All Roles'; selectedValue = ''; open = false; performSearch()">
                            All Roles
                        </a>

                        @foreach ($roles as $role)
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="selectedLabel = '{{ ucfirst($role) }}'; selectedValue = '{{ $role }}'; open = false; performSearch()">
                                {{ ucfirst($role) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Buttons -->
                <div class="md:col-span-3 flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-[#6200EA] hover:bg-[#5000C0] text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                        <span class="material-icons-round text-base animate-spin" x-show="loading" x-cloak>refresh</span>
                        <span class="material-icons-round text-base" x-show="!loading">search</span>
                        Search
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-colors flex items-center justify-center">
                        <span class="material-icons-round">restart_alt</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div id="users-table-results" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Email</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Role</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wide">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#6200EA]/10 flex items-center justify-center shrink-0">
                                        @if(isset($user->profile_photo_url) && $user->profile_photo_url)
                                            <img class="w-full h-full rounded-full object-cover"
                                                src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        @else
                                            <span class="font-bold text-[#6200EA]">{{ substr($user->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $roleClass = match ($user->role) {
                                        'admin' => 'bg-green-50 text-green-700',
                                        'cashier' => 'bg-blue-50 text-blue-700',
                                        default => 'bg-purple-50 text-purple-700',
                                    };
                                    $roleIcon = match ($user->role) {
                                        'admin' => 'security',
                                        'cashier' => 'point_of_sale',
                                        default => 'person',
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $roleClass }}">
                                    <span class="material-icons-round text-sm">{{ $roleIcon }}</span>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <span class="material-icons-round text-lg">edit</span>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                            <span class="material-icons-round text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-icons-round text-3xl text-gray-400">group_off</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">No Users Found</h3>
                                <p class="text-gray-500 mb-6">No users match your criteria.</p>
                                <a href="{{ route('admin.users.create') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#6200EA] text-white rounded-lg text-sm font-bold hover:bg-[#5000C0] transition-colors">
                                    <span class="material-icons-round text-lg">add</span>
                                    Add New User
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection