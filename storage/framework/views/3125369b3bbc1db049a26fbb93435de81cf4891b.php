<br>
<?php $checked = false; ?>
<?php if(isset($options->options)): ?>
    <?php $__currentLoopData = $options->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($dataTypeContent->{$row->field}) || old($row->field)): ?>
            <?php
                $checkedData = old($row->field, $dataTypeContent->{$row->field});
                $checkedData = is_array($checkedData) ? $checkedData : json_decode($checkedData, true);
                $checked = in_array($key, $checkedData);
            ?>
        <?php else: ?>
            <?php $checked = isset($options->checked) && $options->checked ? true : false; ?>
        <?php endif; ?>

        <input type="checkbox" name="<?php echo e($row->field); ?>[<?php echo e($key); ?>]" <?php echo $checked ? 'checked="checked"' : ''; ?> value="<?php echo e($key); ?>" id="<?php echo e($key); ?>"/>
        <label for="<?php echo e($key); ?>"><?php echo e($label); ?></label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/formfields/multiple_checkbox.blade.php ENDPATH**/ ?>