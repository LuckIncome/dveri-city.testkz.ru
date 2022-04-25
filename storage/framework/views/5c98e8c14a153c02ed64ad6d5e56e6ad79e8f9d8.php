<div class="breadcrumbs">
    <ul>
        <li><a href="/">Главная</a></li>
        <li class="arrow"><span class="fa fa-angle-right"></span></li><?php if(isset($subtitle)): ?> <?php if(isset($titleLink)): ?>
            <li><a href="<?php echo e($titleLink); ?>"><?php echo e($title); ?></a></li><?php else: ?>
            <li class="current"><span><?php echo e($title); ?></span></li><?php endif; ?>
        <li class="arrow"><span class="fa fa-angle-right"></span></li>
        <li class="current"><span><?php echo e($subtitle); ?></span></li><?php else: ?>
            <li class="current"><span><?php echo e($title); ?></span></li><?php endif; ?> </ul>
</div><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/partials/breadcrumbs.blade.php ENDPATH**/ ?>