<?php $__env->startSection('seo_title',$post->seo_title ? $post->seo_title : $post->title); ?><?php $__env->startSection('meta_keywords',$post->meta_keywords); ?><?php $__env->startSection('meta_description',$post->meta_description); ?><?php $__env->startSection('content'); ?> <div class="sales-page def-page"> <div class="pre-header"> <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=>'Новости','subtitle'=> $post->title,'titleLink'=> route('posts.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1><?php echo e($post->title); ?></h1> </div></div><div class="container"> <div class="row"> <div class="content col-12"> <div class="about-content"> <div class="text-content"> <div class="row page-header"> <div class="col-5"> <picture> <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($post->image), PATHINFO_EXTENSION),'webp',Voyager::image($post->image))); ?>" type="image/webp"> <source srcset="<?php echo e(Voyager::image($post->image)); ?>" type="image/jpeg"> <img src="<?php echo e(Voyager::image($post->image)); ?>" alt="<?php echo e($post->title); ?>"> </picture> </div><div class="col-7"> <h2><?php echo e($post->title); ?></h2> <p><?php echo e($post->excerpt); ?></p></div></div><?php echo $post->body; ?></div></div></div></div></div></div><?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/posts/show.blade.php ENDPATH**/ ?>