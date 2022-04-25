<input type="date" class="form-control" name="<?php echo e($row->field); ?>"
       placeholder="<?php echo e($row->getTranslatedAttribute('display_name')); ?>"
       value="<?php if(isset($dataTypeContent->{$row->field})): ?><?php echo e(\Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('Y-m-d')); ?><?php else: ?><?php echo e(old($row->field)); ?><?php endif; ?>">
<?php /**PATH /home/users/b/buldoorskz/domains/dveri-city.kz/vendor/tcg/voyager/resources/views/formfields/date.blade.php ENDPATH**/ ?>