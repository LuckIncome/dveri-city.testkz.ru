<div class="panel">
    <div class="page-content settings container-fluid">
        <div id="media_picker_<?php echo e($row->field); ?>">
            <media-manager
                base-path="<?php echo e($options->base_path ?? '/'.$dataType->slug.'/'); ?>"
                filename="<?php echo e($options->rename ?? 'null'); ?>"
                :allow-multi-select="<?php echo e(isset($options->max) && $options->max > 1 ? 'true' : 'false'); ?>"
                :max-selected-files="<?php echo e($options->max ?? 0); ?>"
                :min-selected-files="<?php echo e($options->min ?? 0); ?>"
                :show-folders="<?php echo e(var_export($options->show_folders ?? false, true)); ?>"
                :show-toolbar="<?php echo e(var_export($options->show_toolbar ?? true, true)); ?>"
                :allow-upload="<?php echo e(var_export($options->allow_upload ?? true, true)); ?>"
                :allow-move="<?php echo e(var_export($options->allow_move ?? false, true)); ?>"
                :allow-delete="<?php echo e(var_export($options->allow_delete ?? true, true)); ?>"
                :allow-create-folder="<?php echo e(var_export($options->allow_create_folder ?? true, true)); ?>"
                :allow-rename="<?php echo e(var_export($options->allow_rename ?? true, true)); ?>"
                :allow-crop="<?php echo e(var_export($options->allow_crop ?? true, true)); ?>"
                :allowed-types="<?php echo e(isset($options->allowed) && is_array($options->allowed) ? json_encode($options->allowed) : '[]'); ?>"
                :pre-select="false"
                :expanded="<?php echo e(var_export($options->expanded ?? false, true)); ?>"
                :show-expand-button="true"
                :element="'input[name=&quot;<?php echo e($row->field); ?>&quot;]'"
                :details="<?php echo e(json_encode($options ?? [])); ?>"
            ></media-manager>
            <input type="hidden" :value="<?php echo e($content); ?>" name="<?php echo e($row->field); ?>">
        </div>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<script>
new Vue({
    el: '#media_picker_<?php echo e($row->field); ?>'
});
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/formfields/media_picker.blade.php ENDPATH**/ ?>