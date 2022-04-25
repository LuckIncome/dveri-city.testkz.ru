<?php $__env->startSection('meta_description',$description ? $description : 'Партнеры'); ?><?php $__env->startSection('seo_title',$seoTitle ? $seoTitle : 'Партнеры'); ?><?php $__env->startSection('meta_keywords',$keywords ? $keywords : 'Партнеры'); ?><?php $__env->startSection('content'); ?>
    <div class="sales-page partners-page def-page">
        <div class="pre-header">
            <div class="container"> <?php echo $__env->make('partials.breadcrumbs',['title'=> 'Партнеры'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1>Партнеры</h1></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        <div class="text">
                            <div class="row page-header partners">
                                <div class="row col-12">
                                    <div class="col-3">
                                        <div class="nav flex-column nav-pills sticky-top" data-offset-top="205"
                                             id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical"> <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a
                                                    class="nav-link <?php if($partner->id==1): ?> active <?php endif; ?>"
                                                    id="v-pills-<?php echo e($partner->id); ?>-tab" data-toggle="pill"
                                                    href="#v-pills-<?php echo e($partner->id); ?>" role="tab"
                                                    aria-controls="v-pills-<?php echo e($partner->id); ?>"
                                                    aria-selected="<?php echo e($partner->id==1 ? 'true' : 'false'); ?>"><?php echo e($partner->name); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content"
                                             id="v-pills-tabContent"> <?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="tab-pane fade <?php if($partner->id==1): ?> show active <?php endif; ?>"
                                                     id="v-pills-<?php echo e($partner->id); ?>" role="tabpanel"
                                                     aria-labelledby="v-pills-<?php echo e($partner->id); ?>-tab">
                                                    <div class="mb-5 pt-5 col-12"><h4
                                                                class="mb-5"><?php echo e($partner->name); ?></h4>
                                                        <div class="content"> <?php if($partner->logo): ?>
                                                                <div class="media col-3 mt-5 mb-5">
                                                                    <picture>
                                                                        <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($partner->logo))['extension'],'webp',Voyager::image($partner->logo))); ?>"
                                                                                type="image/webp">
                                                                        <source srcset="<?php echo e(Voyager::image($partner->logo)); ?>"
                                                                                type="image/jpeg">
                                                                        <img src="<?php echo e(Voyager::image($partner->logo)); ?>"
                                                                             alt="<?php echo e($partner->name); ?>"></picture>
                                                                </div><?php endif; ?>
                                                            <div class="row">
                                                                <div class="partner-content <?php if(json_decode($partner->gallery) != null): ?> col-6 <?php else: ?> col-12 <?php endif; ?>"><?php echo $partner->content; ?></div>
                                                                <?php if(json_decode($partner->gallery) != null): ?>
                                                                    <div class="slider col-6">
                                                                        <div class="sliderContent">
                                                                            <?php $__currentLoopData = json_decode($partner->gallery); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <div class="item">
                                                                                    <picture>
                                                                                        <source srcset="<?php echo e(str_replace(pathinfo(Voyager::image($img))['extension'],'webp',Voyager::image($img))); ?>"
                                                                                                type="image/webp">
                                                                                        <source srcset="<?php echo e(Voyager::image($img)); ?>"
                                                                                                type="image/jpeg">
                                                                                        <img src="<?php echo e(Voyager::image($img)); ?>"
                                                                                             alt="<?php echo e($partner->name); ?>">
                                                                                    </picture>
                                                                                </div>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </div>
                                                                        <div class="sliderArrows">
                                                                            <a class="prevSlide">Previous</a>
                                                                            <p>1/10</p>
                                                                            <a class="nextSlide">Next</a>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/pages/partners.blade.php ENDPATH**/ ?>