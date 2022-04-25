<input type="hidden" class="form-control" name="<?php echo e($row->field); ?>"
       placeholder="<?php echo e($row->getTranslatedAttribute('display_name')); ?>"
       <?php echo isBreadSlugAutoGenerator($options); ?>

       value="<?php echo e(old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '')); ?>">
<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/formfields/hidden.blade.php ENDPATH**/ ?>