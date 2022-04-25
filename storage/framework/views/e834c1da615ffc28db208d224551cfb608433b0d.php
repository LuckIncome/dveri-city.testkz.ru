<?php if($paginator->hasPages()): ?>
    <ul class="pagination">
    
    <!-- Pagination Elements -->
        <?php if(!$paginator->onFirstPage()): ?>
            <li class="pagination-page">
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev"
                   aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&lsaquo;</a>
            </li>
        <?php endif; ?>
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- Array Of Links -->
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--  Use three dots when current page is greater than 4.  -->
                    <?php if($paginator->currentPage() > 4 && $page === 2): ?>
                        <li class="pagination-page">
                            <span class="products__inner-right__content-bottom__dots-item">...</span>
                        </li>
                    <?php endif; ?>

                <!--  Show active page else show the first and last two pages from current page.  -->
                    <?php if($page == $paginator->currentPage()): ?>
                        <li class="pagination-page active">
                            <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>
                    <?php elseif($page === $paginator->currentPage() + 1 || $page === $paginator->currentPage() + 2 || $page === $paginator->currentPage() - 1 || $page === $paginator->currentPage() - 2 || $page === $paginator->lastPage() || $page === 1): ?>
                        <li class="pagination-page">
                            <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                        </li>
                    <?php endif; ?>

                <!--  Use three dots when current page is away from end.  -->
                    <?php if($paginator->currentPage() < $paginator->lastPage() - 3 && $page === $paginator->lastPage() - 1): ?>
                        <li class="pagination-page">
                            <span class="products__inner-right__content-bottom__dots-item">...</span>
                        </li>
                    <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($paginator->hasMorePages()): ?>
            <li class="pagination-page">
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&rsaquo;</a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>

<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/partials/pagination.blade.php ENDPATH**/ ?>