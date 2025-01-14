<?php
use Symfony\Component\Yaml\Yaml;

if (($config['mode'] ?? null) == 'yaml' && is_array($value))
    $value = Yaml::dump($value, 4);
?>
<div class="d-block">
    <?php $fieldName = str_replace(['[', ']'], ['__', ''], $config['field']); ?>
    <div id="<?= $fieldName; ?>_editor" data-input-id="<?= $fieldName; ?>" data-mode="<?= $config['mode'] ?? 'html'; ?>" class="code_editor mb-4" style="min-height:<?= $config['height'] ?? '400'; ?>px"><?= htmlentities($value); ?></div>
    <input type="hidden" name="<?php echo $config['field']; ?>" id="<?= $fieldName; ?>" value="<?= htmlentities($value); ?>">
</div>