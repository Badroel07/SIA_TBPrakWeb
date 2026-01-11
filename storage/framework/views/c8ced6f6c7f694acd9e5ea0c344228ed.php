<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>

    <!-- Header & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
            <p class="text-gray-500 mt-1">Update user account information.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.users.index')); ?>"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 transition-colors">
                <span class="material-icons-round text-lg">arrow_back</span>
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="material-icons-round text-[#6200EA]">manage_accounts</span>
                    User Information
                </h3>
            </div>

            <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>" class="p-6 md:p-8 space-y-6">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Basic Info -->
                <div class="space-y-5">

                    <!-- Name -->
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1.5">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <span class="material-icons-round text-lg">person</span>
                            </span>
                            <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="e.g. John text">
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <span class="material-icons-round text-lg">email</span>
                            </span>
                            <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="e.g. john@example.com">
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">
                                Password <span class="font-normal text-xs text-gray-400 ml-1">(Optional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-icons-round text-lg">lock</span>
                                </span>
                                <input type="password" name="password" id="password"
                                    class="w-full pl-11 pr-10 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Leave blank to keep current">
                                <!-- Toggle Password Visibility -->
                                <button type="button" onclick="togglePassword('password', 'eyeIconEdit')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#6200EA] transition-colors">
                                    <span id="eyeIconEdit" class="material-icons-round text-lg">visibility</span>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5">Confirm
                                Password</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-icons-round text-lg">lock_reset</span>
                                </span>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:bg-white focus:border-[#6200EA] focus:ring-2 focus:ring-purple-100 transition-all outline-none"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="group">
                        <label for="role-select2" class="block text-sm font-bold text-gray-700 mb-1.5">User Role</label>
                        <select name="role" id="role-select2" class="w-full" required>
                            <option value="">Select Role...</option>
                            <?php $__currentLoopData = $availableRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role); ?>" <?php echo e(old('role', $user->role) == $role ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($role)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="<?php echo e(route('admin.users.index')); ?>"
                        class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors text-center">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-bold text-white bg-[#6200EA] hover:bg-[#5000C0] rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <span class="material-icons-round text-sm">save</span>
                        Update User
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Custom Select2 Styling -->
    <style>
        .select2-container--default .select2-selection--single {
            border-color: #E5E7EB !important;
            background-color: #F9FAFB !important;
            border-radius: 0.5rem !important;
            height: 48px !important;
            display: flex !important;
            align-items: center !important;
            padding-left: 0.5rem;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: #6200EA !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 2px #F3E8FF !important;
        }

        .select2-selection__arrow {
            height: 46px !important;
            top: 0 !important;
            right: 8px !important;
        }

        .select2-dropdown {
            border-color: #E5E7EB !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            margin-top: 4px;
        }
    </style>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function togglePassword(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility';
                }
            }

            $(document).ready(function () {
                $('#role-select2').select2({
                    placeholder: "Select User Role",
                    allowClear: false,
                    minimumResultsForSearch: Infinity,
                    width: '100%'
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>