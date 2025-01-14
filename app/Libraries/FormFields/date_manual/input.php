<div class="d-flex">
    <input 
        type="text" 
        class="form-control" 
        id="date_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" 
        style="min-width:50px" 
        value="<?= $value ? date("d", strtotime($value)) : '' ?>">

    <span class="date-separator px-2">/</span>

    <select id="month_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" class="form-select">
        <option <?= $value && date('m', strtotime($value)) == '01' ? 'selected' : ''; ?> value="01">Januari</option>
        <option <?= $value && date('m', strtotime($value)) == '02' ? 'selected' : ''; ?> value="02">Februari</option>
        <option <?= $value && date('m', strtotime($value)) == '03' ? 'selected' : ''; ?> value="03">Maret</option>
        <option <?= $value && date('m', strtotime($value)) == '04' ? 'selected' : ''; ?> value="04">April</option>
        <option <?= $value && date('m', strtotime($value)) == '05' ? 'selected' : ''; ?> value="05">Mei</option>
        <option <?= $value && date('m', strtotime($value)) == '06' ? 'selected' : ''; ?> value="06">Juni</option>
        <option <?= $value && date('m', strtotime($value)) == '07' ? 'selected' : ''; ?> value="07">Juli</option>
        <option <?= $value && date('m', strtotime($value)) == '08' ? 'selected' : ''; ?> value="08">Agustus</option>
        <option <?= $value && date('m', strtotime($value)) == '09' ? 'selected' : ''; ?> value="09">September</option>
        <option <?= $value && date('m', strtotime($value)) == '10' ? 'selected' : ''; ?> value="10">Oktober</option>
        <option <?= $value && date('m', strtotime($value)) == '11' ? 'selected' : ''; ?> value="11">November</option>
        <option <?= $value && date('m', strtotime($value)) == '12' ? 'selected' : ''; ?> value="12">Desember</option>
    </select>

    <span class="date-separator px-2">/</span>

    <input 
        type="text" 
        class="form-control" 
        id="year_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" 
        style="min-width:70px" 
        value="<?= $value ? date("Y", strtotime($value)) : ''; ?>">
</div>
<p class="small invalid-date text-danger d-none" id="invalid_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>">Tanggal tidak valid</p>

<input type="hidden" id="real_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>" name="<?= $config['field']; ?>" value="<?= $value; ?>">
<script>
    $(function() {
        $('#date_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>, #month_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>, #year_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>')
        .on('change', function() {
            let date = $('#date_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').val();
            let month = $('#month_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').val();
            let year = $('#year_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').val();
            let mydate = moment(date + '-' + month + '-' + year, "DD-MM-YYYY").format("YYYY-MM-DD");
            if(mydate == 'Invalid date' || year.length != 4 || date.length > 2) {
                $('#invalid_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').removeClass('d-none');
            } else {
                $('#invalid_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').addClass('d-none');
            }
            console.log(mydate);
            $('#real_<?= str_replace(['[', ']'], ['__', ''], $config['field']); ?>').val(mydate);
        })
    })
</script>