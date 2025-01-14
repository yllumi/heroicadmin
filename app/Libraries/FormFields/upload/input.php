<?php $idname = str_replace(['[', ']'], ['__', ''], $config['field']); ?>
<div class="input-group">
  <button type="button" id="<?= $idname; ?>Btn" class="btn btn-outline-info px-2"><?= $value ? 'Ganti File' : 'Upload File'; ?></button>
  <a class="btn btn-outline-secondary <?= $value ?? null ? 'px-2' : 'd-none'; ?>" id="btn-preview-<?= $idname ?>" title="Lihat gambar" data-fancybox="gallery" href="<?= strpos($value, 'http') !== 0 ? base_url('uploads/' . $_ENV['SITENAME'] . '/entry_files/' . ($value ?? '-')) : ($value ?? '-'); ?>"><img src="<?= base_url('views/admin/assets/images/card-image.svg'); ?>"></a>
  <input type="text" class="form-control" name="<?= $config['field']; ?>" id="<?= $idname; ?>" value="<?= $value; ?>" data-caption="<?= $config['label']; ?>" <?= strpos($config['rules'] ?? '', 'required') !== false ? 'required' : ''; ?> readonly>
</div>
<small class="d-block" id="<?= $idname; ?>msgBox"></small>
<div id="<?= $idname; ?>progressOuter" class="progress progress-striped active" style="display:none;">
  <div id="<?= $idname; ?>progressBar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>

<script>
  $(function() {
    let btn = document.getElementById('<?= $idname; ?>Btn'),
      btnPreview = document.getElementById('btn-preview-<?= $idname ?>'),
      progressBar = document.getElementById('<?= $idname; ?>progressBar'),
      progressOuter = document.getElementById('<?= $idname; ?>progressOuter'),
      inputText = document.getElementById('<?= $idname; ?>'),
      msgBox = document.getElementById('<?= $idname; ?>msgBox');

    var <?= $idname; ?>_uploader = new ss.SimpleUpload({
      button: btn,
      url: '<?= site_url('entry/upload/' . ($entry ?? 0) . '/' . $config['field']); ?>',
      data: {conf:`<?= base64_encode(json_encode($config)); ?>`},
      name: '<?= $config['field'] ?>',
      allowedExtensions: ['jpg', 'jpeg', 'png', 'doc', 'docx', 'xls', 'xlsx', 'pdf', 'gz'],
      // allowedExtensions: <?= json_encode($config['allowed_types'] ?? "['jpg', 'jpeg', 'png']") ?>,
      multipart: true,
      hoverClass: 'hover',
      focusClass: 'focus',
      responseType: 'json',
      startXHR: function() {
        progressOuter.style.display = 'block'; // make progress bar visible
        this.setProgressBar(progressBar);
      },
      onSubmit: function() {
        msgBox.innerHTML = ''; // empty the message box
        btn.innerHTML = 'Mengunggah...'; // change button text to "Uploading..."
      },
      onComplete: function(filename, response) {
        console.log(response)
        btn.innerHTML = 'Ganti File';
        progressOuter.style.display = 'none'; // hide progress bar when upload is completed

        if (!response) {
          msgBox.innerHTML = response.response_message;
          return;
        }

        if (response.response_code === 200) {
          toastr.success(escapeTags(response.data.file_name) + ' berhasil diunggah.');
          btnPreview.setAttribute('href', response.data.url);
          inputText.value = response.data.url;
          inputText.dispatchEvent(new Event("change"));
        } else {
          if (response.response_message) {
            toastr.warning(escapeTags(response.response_message));

          } else {
            toastr.error('Terjadi kesalahan saat proses upload.');
          }
        }
      },
      onError: function(filename, errorType, status, statusText, response, uploadBtn, fileSize) {
        console.log(filename, errorType, status, statusText, response, uploadBtn, fileSize)
        progressOuter.style.display = 'none';
        msgBox.innerHTML = errorType + ': Error saat mengunggah ke server: ' + status + ' ' + statusText;
      }
    });
  });
</script>