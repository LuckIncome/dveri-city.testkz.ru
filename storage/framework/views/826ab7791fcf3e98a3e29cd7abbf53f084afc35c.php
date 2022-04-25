<?php $__env->startSection('seo_title',$page->seo_title ? $page->seo_title : $page->title); ?>
<?php $__env->startSection('meta_keywords',$page->meta_keywords); ?>
<?php $__env->startSection('meta_description',$page->meta_description); ?>
<?php $__env->startSection('content'); ?>
    <div class="sales-page def-page">
        <div class="pre-header">
            <div class="container">
                <?php echo $__env->make('partials.breadcrumbs',['title'=> $page->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <h1><?php echo e($page->title); ?></h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-12">
                    <div class="about-content">
                        <div class="text-content">
                            <div class="row page-header">
                                <div class="contacts d-flex flex-wrap w-100">
                                    <div class="nav flex-column nav-pills col-3" id="v-pills-tab" role="tablist"
                                         aria-orientation="vertical">
                                        <?php $__currentLoopData = $contacts->groupBy('city'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city=>$items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="nav-link <?php if($loop->first): ?> active <?php endif; ?>"
                                               id="v-pills-<?php echo e($city); ?>-tab" data-toggle="pill"
                                               href="#v-pills-<?php echo e($city); ?>" role="tab" aria-controls="v-pills-<?php echo e($city); ?>"
                                               aria-selected="true">Магазин в г. <?php echo e($city); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class="tab-content col-9" id="v-pills-tabContent">
                                        <?php $__currentLoopData = $contacts->groupBy('city'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city=>$items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="tab-pane fade <?php if($loop->first): ?>show active <?php endif; ?> row d-flex flex-wrap"
                                                 id="v-pills-<?php echo e($city); ?>" role="tabpanel"
                                                 aria-labelledby="v-pills-<?php echo e($city); ?>-tab">
                                                <div class="maps col-7">
                                                    <div class="map" data-city="<?php echo e($city); ?>">
                                                        <?php echo $items->where('type','map')->first()->value; ?>

                                                    </div>
                                                </div>
                                                <div class="texts col-5">
                                                    <div class="city-texts" data-city="<?php echo e($city); ?>">
                                                        <?php if($items->where('type','address')->count()): ?>
                                                            <div class="text">
                                                                <span>Заходите в гости:</span>
                                                                <?php $__currentLoopData = $items->where('type','address'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <p><?php echo e($address->value); ?></p>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($items->where('type','email')->count()): ?>
                                                            <div class="text">
                                                                <span>Пишите нам:</span>
                                                                <p><?php echo e($items->where('type','email')->first()->value); ?></p>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($items->where('type','phone')->count()): ?>
                                                            <div class="text">
                                                                <span>Звоните нам:</span>
                                                                <?php $__currentLoopData = $items->where('type','phone'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <a href="<?php echo e($phone->link); ?>"
                                                                       class="phone"><?php echo e($phone->value); ?></a>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if($items->where('type','social')->count()): ?>
                                                            <div class="text">
                                                                <span>Заходите в наши соц. сети:</span>
                                                                <?php $__currentLoopData = $items->where('type','social'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="social">
                                                                        <a rel="nofollow"  href="<?php echo e($social->link); ?>" class="phone">
                                                                            <img src="<?php echo e(Voyager::image($social->icon)); ?>"
                                                                                 alt="<?php echo e($social->value); ?>">
                                                                            <span><?php echo e($social->value); ?></span>
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('partials.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/resources/views/pages/contacts.blade.php ENDPATH**/ ?>