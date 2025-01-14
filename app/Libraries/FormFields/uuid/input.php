<?php $uuid = generate_uuid(); ?>
<input type="text" value="<?= !empty($value) ? hex2uuid($value) : strtoupper(str_replace('-','',$uuid)); ?>" class="form-control" data-caption="<?= $config['label']; ?>" disabled />
<input type="hidden" id="<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" name="<?= $config['field']; ?>" value="<?= !empty($value) ? $value : strtoupper(str_replace('-','',$uuid)); ?>" />
