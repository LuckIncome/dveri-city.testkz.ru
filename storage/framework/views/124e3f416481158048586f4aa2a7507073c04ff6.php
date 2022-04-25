<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>

<script type="application/javascript">
    function initMap() {
        <?php $__empty_1 = true; $__currentLoopData = $dataTypeContent->getCoordinates(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            var center = {lat: <?php echo e($point['lat']); ?>, lng: <?php echo e($point['lng']); ?>};
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            var center = {lat: <?php echo e(config('voyager.googlemaps.center.lat')); ?>, lng: <?php echo e(config('voyager.googlemaps.center.lng')); ?>};
        <?php endif; ?>
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: <?php echo e(config('voyager.googlemaps.zoom')); ?>,
            center: center
        });
        var markers = [];
        <?php $__currentLoopData = $dataTypeContent->getCoordinates(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            var marker = new google.maps.Marker({
                    position: {lat: <?php echo e($point['lat']); ?>, lng: <?php echo e($point['lng']); ?>},
                    map: map
                });
            markers.push(marker);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    }
</script>
<div id="map"/>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(config('voyager.googlemaps.key')); ?>&callback=initMap"></script><?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/partials/coordinates.blade.php ENDPATH**/ ?>