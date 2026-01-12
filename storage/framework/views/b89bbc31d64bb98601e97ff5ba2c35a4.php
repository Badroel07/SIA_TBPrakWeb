<?php $__env->startSection('title', 'Customer Management'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Users</h2>
            <p class="text-gray-500 mt-1">Manage user accounts and roles.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.users.create')); ?>"
                class="flex items-center gap-2 px-4 py-2 bg-[#6200EA] text-white rounded-lg text-sm font-bold hover:bg-[#5000C0] transition-colors shadow-md shadow-purple-200">
                <span class="material-icons-round text-lg">add</span>
                Add User
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm mb-6">
        <form action="<?php echo e(route('admin.users.index')); ?>" method="GET" x-data="{
                        searchTimeout: null,
                        loading: false,
                        performSearch() {
                            clearTimeout(this.searchTimeout);
                            this.searchTimeout = setTimeout(() => {
                                this.loading = true;
                                const formData = new FormData($el);
                                const params = new URLSearchParams(formData);

                                fetch('<?php echo e(route('admin.users.index')); ?>?' + params.toString(), {
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
                                    window.history.pushState({}, '', '<?php echo e(route('admin.users.index')); ?>?' + params.toString());
                                    
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
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search by name..."
                        @input="performSearch()"
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-[#6200EA] focus:border-transparent focus:bg-white transition-all outline-none">
                </div>

                <!-- Role Filter -->
                <div class="md:col-span-4 relative"
                    x-data="{ open: false, selectedLabel: '<?php echo e(request('role') ? ucfirst(request('role')) : 'All Roles'); ?>', selectedValue: '<?php echo e(request('role') ?: ''); ?>' }"
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

                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 hover:text-[#6200EA]"
                                @click.prevent="selectedLabel = '<?php echo e(ucfirst($role)); ?>'; selectedValue = '<?php echo e($role); ?>'; open = false; performSearch()">
                                <?php echo e(ucfirst($role)); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <a href="<?php echo e(route('admin.users.index')); ?>"
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
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#6200EA]/10 flex items-center justify-center shrink-0">
                                        <?php if(isset($user->profile_photo_url) && $user->profile_photo_url): ?>
                                            <img class="w-full h-full rounded-full object-cover"
                                                src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->name); ?>">
                                        <?php else: ?>
                                            <span class="font-bold text-[#6200EA]"><?php echo e(substr($user->name, 0, 1)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800"><?php echo e($user->name); ?></p>
                                        <p class="text-xs text-gray-500">ID: #<?php echo e($user->id); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                <?php echo e($user->email); ?>

                            </td>
                            <td class="px-6 py-4">
                                <?php
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
                                ?>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium <?php echo e($roleClass); ?>">
                                    <span class="material-icons-round text-sm"><?php echo e($roleIcon); ?></span>
                                    <?php echo e(ucfirst($user->role)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                        class="p-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                        title="Edit">
                                        <span class="material-icons-round text-lg">edit</span>
                                    </a>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" class="inline"
                                        onsubmit="return confirm('Delete this user?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit"
                                            class="p-1.5 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete">
                                            <span class="material-icons-round text-lg">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-icons-round text-3xl text-gray-400">group_off</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">No Users Found</h3>
                                <p class="text-gray-500 mb-6">No users match your criteria.</p>
                                <a href="<?php echo e(route('admin.users.create')); ?>"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#6200EA] text-white rounded-lg text-sm font-bold hover:bg-[#5000C0] transition-colors">
                                    <span class="material-icons-round text-lg">add</span>
                                    Add New User
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($users->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                <?php echo e($users->links()); ?>

            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/users/index.blade.php ENDPATH**/ ?>