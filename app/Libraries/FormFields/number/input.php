<?php
$attrs = '';
if (isset($config['attr']))
	foreach ($config['attr'] as $key => $val) {
		$attrs .= $key . '="' . $val . '" ';
	}
?>
<div class="col-sm-6 pl-0 mb-0">
<input id="<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" 
	type="number" 
	name="<?php echo $config['field']; ?>" 
	value="<?= $value ? $value : $config['default'] ?? ''; ?>" 
	class="form-control" 
	<?= $attrs; ?> 
	data-caption="<?= $config['label']; ?>" 
	<?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> 
	autocomplete="off" />
</div>