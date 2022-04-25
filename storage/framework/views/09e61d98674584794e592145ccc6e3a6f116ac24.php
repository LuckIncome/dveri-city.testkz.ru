<?php $__env->startSection('meta_description',$description ? $description : 'Новости'); ?><?php $__env->startSection('seo_title',$seoTitle ? $seoTitle  : 'Новости'); ?><?php $__env->startSection('meta_keywords',$keywords ? $keywords  : 'Новости'); ?><?php $__env->startSection('content'); ?>
    <div class="sales-page def-page">
        <div class="pre-header">
            <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=> 'Новости'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1>Новости</h1></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="sales"> <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="sale-block">
                                <div class="image col-5">
                                    <picture>
                                        <source
                                            srcset="<?php echo e(str_replace(pathinfo(Voyager::image($post->getThumbnail($post->image, 'medium')), PATHINFO_EXTENSION),'webp',Voyager::image($post->getThumbnail($post->image, 'medium')))); ?>"
                                            type="image/webp">
                                        <source srcset="<?php echo e(Voyager::image($post->getThumbnail($post->image, 'medium'))); ?>"
                                                type="image/jpeg">
                                        <img src="<?php echo e(Voyager::image($post->getThumbnail($post->image, 'medium'))); ?>"
                                             alt="<?php echo e($post->getTranslatedAttribute('title',$locale,$fallbackLocale)); ?>">
                                    </picture>
                                </div>
                                <div class="info col-7"><a class="title"
                                                           href="<?php echo e(route('posts.show',$post->slug)); ?>"><?php echo e($post->getTranslatedAttribute('title',$locale,$fallbackLocale)); ?></a>
                                    <p class="text"><?php echo e($post->getTranslatedAttribute('excerpt',$locale,$fallbackLocale)); ?></p>
                                    <span
                                        class="date"><?php echo e(Carbon\Carbon::parse($post->created_at)->format('d.m.Y')); ?></span>
                                </div>
                            </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $posts->links('partials.pagination'); ?>

                            </div>
                </div>
            </div>
        </div>
    </div><?php $__env->stopSection(); ?>

<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/posts/index.blade.php ENDPATH**/ ?>