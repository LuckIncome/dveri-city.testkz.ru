<?php $__env->startSection('seo_title',$page->seo_title ? $page->seo_title : $page->title); ?>
<?php $__env->startSection('meta_keywords',$page->meta_keywords); ?>
<?php $__env->startSection('meta_description',$page->meta_description); ?>
<?php $__env->startSection('content'); ?>
    <div class="<?php if($page->slug=='about'): ?> about-page <?php else: ?> sales-page <?php endif; ?> def-page">
        <div class="pre-header">
            <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=> $page->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1><?php echo e($page->title); ?></h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        <?php if($page->slug !='about'): ?>
                            <div class="text-content">
                                <div class="row page-header">
                                    <?php if($page->image): ?>
                                        <div class="col-5">
                                            <picture>
                                                <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($page->image))['extension'],'webp',Voyager::image($page->image))); ?>"
                                                        type="image/webp">
                                                <source srcset="<?php echo e(Voyager::image($page->image)); ?>" type="image/jpeg">
                                                <img src="<?php echo e(Voyager::image($page->image)); ?>" alt="<?php echo e($page->seo_title); ?>">
                                            </picture>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($page->slug=='contacts'): ?>
                                        <div class="col-4"><p><?php echo e($page->excerpt); ?></p><?php echo $page->body; ?></div>
                                        <div class="col-8 frameMap"><?php echo setting('site.js_map'); ?></div>
                                    <?php else: ?>
                                        <div class="col-7"><h2><?php echo e($page->title); ?></h2>
                                            <p><?php echo e($page->excerpt); ?></p></div>
                                        <div class="col-12"><?php echo $page->body; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="render"><h2><?php echo e($page->excerpt); ?></h2></div>
                            <div class="text-content"><?php echo $page->body; ?></div><?php endif; ?> </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($page->slug=='about'): ?>
        <?php echo $__env->make('partials.modalVideo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/pages/show.blade.php ENDPATH**/ ?>