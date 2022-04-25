<?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old(
    $row->field,
                $dataTypeContent->{$row->field}
))) ? old(
                    $row->field,
        $dataTypeContent->{$row->field}
                ) : old($row->field); ?>
                                        <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : null; ?>
<ul class="radio">
    <?php if(isset($options->options)): ?>
        <?php $__currentLoopData = $options->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <input type="radio" id="option-<?php echo e(\Illuminate\Support\Str::slug($row->field, '-')); ?>-<?php echo e(\Illuminate\Support\Str::slug($key, '-')); ?>"
                       name="<?php echo e($row->field); ?>"
                       value="<?php echo e($key); ?>" <?php if($default == $key && $selected_value === NULL): ?> checked <?php endif; ?> <?php if($selected_value == $key): ?> checked <?php endif; ?>>
                <label for="option-<?php echo e(\Illuminate\Support\Str::slug($row->field, '-')); ?>-<?php echo e(\Illuminate\Support\Str::slug($key, '-')); ?>"><?php echo e($option); ?></label>
                <div class="check"></div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</ul>
<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/formfields/radio_btn.blade.php ENDPATH**/ ?>