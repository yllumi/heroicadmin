<?php

$idname = str_replace(['[',']'], ['__',''], $config['field']);
$attributes = 'id="'.$idname.'" class="form-select" data-caption="'.$config['label'].'"';
if(strpos(($config['rules'] ?? ''), 'required') !== false)
    $attributes .= ' required';

if(($config['fixed_value'] ?? false) == true && (isset($_GET['filter'][$config['field']]) || isset($_GET[$config['field']]) ))
    $attributes .= ' disabled';

// Disable on Edit
if(($config['disable_edit'] ?? false) == true && in_array('edit', ci()->uri->segment_array()))
    $attributes .= ' disabled';

if ($config['relation'] ?? '')
{
    $options = ['' => '-pilih opsi-'];
    
    if(! ($config['load_after'] ?? '') || $value)
    {
        $relEntry = $config['relation']['entry'];
        if(isset($config['relation']['model'])){
            $modelName = $config['relation']['model'];
            if(! isset($this->{$config['relation']['model']}))
                $this->load->model($config['relation']['model_path']);
        }
        else {
            $modelName = ucfirst($relEntry).'Model';
            $this->$modelName = setup_entry_model($relEntry, $entryConf['dbconnection'] ?? null);
        }

        $caption = $config['relation']['dropdown_caption'] ?? $config['relation']['caption'];
        if($config['filter_by'] ?? ''){
            $filterBy = explode(',',$config['filter_by']);
            foreach($filterBy as $filterField){
                if($filterValue = ci()->input->get($filterField))
                    if($filterValue == "null")
                        ci()->db->where($filterField. ' is null', null, false);
                    else
                        $this->$modelName->where($filterField, $filterValue);
            }
        }
        if($config['relation']['where'] ?? ''){
            foreach($config['relation']['where'] as $whereField => $whereSpec){
                if(is_array($whereSpec))
                    $this->$modelName->where($whereField . ' ' . $whereSpec[0], $whereSpec[1]);
                else
                    $this->$modelName->where($whereField, $whereSpec);
            }
        }

        if(isset($config['relation']['order_by']))
            $this->$modelName->order_by($config['relation']['order_by'][0], $config['relation']['order_by'][1]);
        $data = $this->$modelName->getAll();

        if($data){
            if(is_array($caption)){
                foreach ($data as $row){
                    $options[$row[($entryConf['primary_key'] ?? 'id')]] = "";
                    foreach ($caption as $capt)
                        $options[$row[($entryConf['primary_key'] ?? 'id')]] .= $row[$capt] ?? $capt;
                    $options[$row[($entryConf['primary_key'] ?? 'id')]] = $options[$row[($entryConf['primary_key'] ?? 'id')]];
                }
            } elseif($data) {
                foreach ($data as $row){
                    $options[$row[($entryConf['primary_key'] ?? 'id')]] = $row[$caption] ?? '';
                }
            }
        }
    }
} 

else if($config['option_source'] ?? null)
{
    $options = ci()->shared['ActionClass']->{$config['option_source']}();
    $options = ['' => '-- Pilih ' . $config['label'] .' --'] + $options;
}

else 
{
    $options = $config['options']; 
}

// Get just ID as value
if(is_array($value) && isset($value[($entryConf['primary_key'] ?? 'id')]))
    $value = $value[($entryConf['primary_key'] ?? 'id')];
?>

<!-- Start load_after -->
<?php if($config['load_after'] ?? ''): ?>

<?php if(!$value): ?>
    <p id="loading_<?= $idname;?>" class="text-muted"><em>Pilih dulu <?= $config['load_after']; ?></em></p>
<?php endif; ?>

<div id="dropdown_<?= $idname;?>" class="<?= $value ? '' : 'sr-only'; ?>">
<?= form_dropdown($config['field'], $options, $value, $attributes); ?>
</div>

<script>
  $(function(){
    $('#<?= $config['load_after']; ?>').on('change', function(){
        $('#loading_<?= $idname;?>').addClass('sr-only');
        $('#dropdown_<?= $idname;?>').removeClass('sr-only');
        let caption = '<?= is_array($config['relation']['caption']) ? implode(',',$config['relation']['caption']) : $config['relation']['caption']; ?>';
        let filterField = '<?= $config['load_after'];?>';
        let filterVal = $(this).val();
        $.getJSON(`<?= site_url('api/entry/'.$config['relation']['entry'].'/dropdown');?>?caption=${caption}&filter[${filterField}]=${filterVal}`, function(data){
            $('#<?= $idname;?>').empty();
            $('#<?= $idname;?>').append(`<option value="">-pilih opsi-</option>`);

            if (typeof data !== 'undefined' && data.length > 0 && data[0] != false) {
                data.forEach(function(item,idx){
                    $('#<?= $idname;?>').append(`<option value="${item.id}">${item[caption]}</option>`);
                })
            }
        })
        $('.form-select').select2();
    });
  });
</script>

<!-- End load_after -->
<?php else: ?>

<?= form_dropdown($config['field'], $options, (!empty($value) ? $value : null) ?? $_GET[$config['field']] ?? $_GET['filter'][$config['field']] ?? '', $attributes); ?>

<?php if(($config['fixed_value'] ?? false) == true && (isset($_GET['filter'][$config['field']]) || isset($_GET[$config['field']]) )): ?>
    <input type="hidden" name="<?= $idname;?>" value="<?= (!empty($value) ? $value : null) ?? $_GET[$config['field']] ?? $_GET['filter'][$config['field']] ?? ''; ?>">
<?php endif; ?>

<script>
  $(function(){
    $('#loading_<?= $idname;?>').addClass('sr-only');
    $('#dropdown_<?= $idname;?>').removeClass('sr-only');
    $('.form-select').select2();

    <?php if($config['update_on_change'] ?? ''): ?>
    $('#<?= $config['field']; ?>').on('change', function(){
        const urlSearchParams = new URLSearchParams(window.location.search);
        const params = Object.fromEntries(urlSearchParams.entries());
        params['training_id'] = $(this).val();
        location.href = `<?= current_url(); ?>?` + new URLSearchParams(params).toString();
    });
    <?php endif; ?>
  });
</script>

<?php endif; ?>
<!-- End !load_after -->

<script>
  $(function(){
    $('.form-select').select2();
  });
</script>
