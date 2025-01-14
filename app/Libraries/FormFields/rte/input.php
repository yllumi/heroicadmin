<?php
$akey = md5($_ENV['SITENAME'] . $_ENV['ENC_KEY']);
$permissionEncoded = get_media_permission(true);
$fieldName = str_replace(['[', ']'], ['__', ''], $config['field']);
$fieldID = $config['id'] ?? $fieldName;
?>

<div class="editor-container" id="<?= $fieldID; ?>_container" data-id="<?= $fieldID; ?>">
    <div id="<?= $fieldID; ?>_editor"><?= $value; ?></div>
    <div id="<?= $fieldID; ?>msgBox"></div>
    <input type="hidden" class="<?= $fieldID; ?>_input_text" name="<?php echo $config['field']; ?>" id="<?= $fieldID; ?>_hidden" value="<?= htmlentities($value); ?>" <?= $config['minlength'] ?? null ? 'minlength="' . $config['minlength'] . '"' : ''; ?>>
    <input type="text" style="display:none" id="<?= $fieldID; ?>__entry__rfm_image_input" value="">
</div>

<?php if (isset($config['minlength'])) : ?>
    <div><small><?= $config['label']; ?> wajib diisi.</small></div>
<?php endif; ?>

<script>
    var toolbar = [
        'heading', '|',
        'bold', 'italic', 'underline', 'strikethrough', 'subscript',
        'superscript', 'code', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
        'alignment', 'outdent', 'indent', 'undo', 'redo', '|',
        <?= $config['enable_image'] ?? true ? "'rfm_image'," : ''; ?>
        <?= $config['enable_table'] ?? true ? "'insertTable'," : ''; ?>
        <?= $config['enable_media_embed'] ?? true ? "'mediaEmbed'," : ''; ?>
        <?= $config['enable_html_embed'] ?? true ? "'htmlEmbed'," : ''; ?>
        <?= $config['enable_source'] ?? true ? "'sourceEditing'," : ''; ?>
    ];
    $(function() {
        ClassicEditor.create(document.querySelector('#<?= $fieldID; ?>_editor'), {
                placeholder: 'Tulis konten disini ..',
                toolbar: toolbar
            })
            .then(editor => {
                myckeditor['<?= $fieldID; ?>'] = editor;

                // Update real input each time editor value change
                myckeditor['<?= $fieldID; ?>'].model.document.on('change:data', () => {
                    $('#<?= $fieldID; ?>_hidden').val(myckeditor['<?= $fieldID; ?>'].getData());
                    $('#<?= $fieldID; ?>_hidden').trigger('change');
                });

                <?php if (($config['image_upload'] ?? 'rfm') == 'direct') : ?>
                    // Direct Upload
                    let btn = document.querySelector('.editor-container#<?= $fieldID; ?>_container .rfm_image'),
                        btnIcon = btn.innerHTML,
                        msgBox = document.getElementById('<?= $fieldID; ?>msgBox');
                    var <?= $fieldID; ?>_uploader = new ss.SimpleUpload({
                        button: btn,
                        url: '<?= site_url('entry/upload/' . ($entry ?? 0) . '/' . $config['field']); ?>',
                        data: {
                            conf: `<?= base64_encode(json_encode($config)); ?>`
                        },
                        name: '<?= $config['field'] ?>',
                        multipart: true,
                        allowedExtensions: ['jpg', 'jpeg', 'png'],
                        hoverClass: 'hover',
                        focusClass: 'focus',
                        responseType: 'json',
                        onSubmit: function() {
                            btn.innerHTML = 'Mengunggah..'
                            toastr.info('Sedang mengunggah..');
                            $('body').css('cursor', 'wait');
                        },
                        onComplete: function(filename, response) {
                            // console.log(response)
                            btn.innerHTML = btnIcon;
                            if (!response) {
                                msgBox.innerHTML = response.response_message;
                                return;
                            }
                            if (response.response_code === 200) {
                                toastr.success(escapeTags(response.data.file_name) + ' berhasil diunggah.');
                                myckeditor['<?= $fieldID; ?>'].execute('insertImage', {
                                    source: response.data.url
                                });
                            } else {
                                if (response.response_message) {
                                    toastr.warning(escapeTags(response.response_message));
                                } else {
                                    toastr.error('Terjadi kesalahan saat proses upload.');
                                }
                            }
                            $('body').css('cursor', 'default');
                        },
                        onError: function(filename, errorType, status, statusText, response, uploadBtn, fileSize) {
                            btn.innerHTML = btnIcon;
                            toastr.error(errorType + ': Error saat mengunggah ke server: ' + status + ' ' + statusText);
                            $('body').css('cursor', 'default');
                        }
                    });
                    // END Direct Upload Script
                <?php endif; ?>

            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });

        <?php if (($config['image_upload'] ?? 'rfm') == 'rfm') : ?>
            // Responsive File Manager image chooser
            $('.editor-container#<?= $fieldID; ?>_container').on('click', '.rfm_image', function() {
                $.fancybox.open({
                    src: `<?= base_url(); ?>filemanager/dialog.php?type=1&field_id=<?= $fieldID; ?>__entry__rfm_image_input&akey=<?= $akey; ?>&p=<?= $permissionEncoded; ?>`,
                    type: 'iframe'
                });
            })
            // END Responsive File Manager image chooser
        <?php endif; ?>

    })
</script>

<?php if (isset($config['minlength'])) : ?>
    <script>
        /**
         * Handle form count
         * 
         * Karena CKE word cound dan limiter plugin berbayar, kepaksa bikin sendiri.
         */
        $("form").submit(function(e) {

            let id = "<?= $fieldID; ?>";

            let count = jQuery($('.' + id + '_input_text').val()).text().length;
            let minlength = "<?php echo $config['minlength']; ?>";

            if (count < minlength) {
                alert('Minimal pengisian catatan adalah ' + minlength + ' karakter, harap isi catatan selengkap-lengkapnya, sekarang baru terisi ' + count + ' karakter.');

                return false;
            } else {
                // Boleh lanjut.
                $("form").submit();
            }
        });
    </script>
<?php endif; ?>