<?php if($paginator->hasPages()): ?>
<nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>" class="flex justify-center">
    
    
    <div class="flex sm:hidden items-center gap-1">
        
        <?php if($paginator->onFirstPage()): ?>
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-xs font-bold">
            «
        </span>
        <?php else: ?>
        <a href="<?php echo e($paginator->url(1)); ?>"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors text-xs font-bold">
            «
        </a>
        <?php endif; ?>

        
        <?php if($paginator->onFirstPage()): ?>
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </span>
        <?php else: ?>
        <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <?php endif; ?>

        
        <span class="px-3 py-2 text-sm font-medium text-gray-700 bg-white rounded-lg border border-gray-200">
            <?php echo e($paginator->currentPage()); ?> / <?php echo e($paginator->lastPage()); ?>

        </span>

        
        <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        <?php else: ?>
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </span>
        <?php endif; ?>

        
        <?php if($paginator->hasMorePages()): ?>
        <a href="<?php echo e($paginator->url($paginator->lastPage())); ?>"
            class="flex items-center justify-center w-9 h-9 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors text-xs font-bold">
            »
        </a>
        <?php else: ?>
        <span class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed text-xs font-bold">
            »
        </span>
        <?php endif; ?>
    </div>

    
    <ul class="hidden sm:flex items-center gap-1">
        
        <?php if($paginator->onFirstPage()): ?>
        <li>
            <span class="flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        </li>
        <?php else: ?>
        <li>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </li>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
            <li>
                <span class="flex items-center justify-center w-10 h-10 text-gray-500 font-medium"><?php echo e($element); ?></span>
            </li>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                    <li>
                        <span class="flex items-center justify-center w-10 h-10 text-white bg-blue-600 rounded-lg font-bold shadow-md shadow-blue-200">
                            <?php echo e($page); ?>

                        </span>
                    </li>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo e($url); ?>"
                            class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 font-medium transition-colors"
                            aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>">
                            <?php echo e($page); ?>

                        </a>
                    </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
        <li>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next"
                class="flex items-center justify-center w-10 h-10 text-gray-700 bg-white rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-300 hover:text-blue-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </li>
        <?php else: ?>
        <li>
            <span class="flex items-center justify-center w-10 h-10 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?><?php /**PATH C:\laragon\www\SIA_TBPrakWeb\resources\views/vendor/pagination/tailwind.blade.php ENDPATH**/ ?>