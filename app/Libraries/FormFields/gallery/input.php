<?php $idname = str_replace(['[', ']'], ['__', ''], $config['field']); ?>
<?php
$preloaded = [];
if ($value) {
    $arrayValue = json_decode($value, true);
    if($arrayValue){
        foreach ($arrayValue as $key => $val) {
            if (!file_exists($val['file'])) continue;
            $preloaded[] = [
                'name' => $val['name'],
                'type' => $val['type'],
                'size' => filesize($val['file']),
                'file' => $val['file'],
                'data' => [
                    'url' => isset($val['url']) ? $val['url'] : str_replace('./', base_url(), $val['file']),
                ]
            ];
        }
    }
}
$preloaded = !empty($preloaded) ? json_encode($preloaded) : '[]';
?>
<div>
    <input type="file" id="<?= $idname ?>file" name="<?= $config['field'] ?>file" data-fileuploader-files='<?= $preloaded; ?>' />
</div>
<input type="hidden" id="<?= $idname ?>" name="<?= $config['field'] ?>" value='<?= ($arrayValue ?? null) ? $value : '[]'; ?>'>

<script>
    $(function() {
        var <?= $idname ?>list = JSON.parse($('#<?= $idname ?>').val());

        $('#<?= $idname ?>file').fileuploader({
            extensions: null,
            changeInput: ' ',
            theme: 'thumbnails',
            enableApi: true,
            addMore: true,
            thumbnails: {
                box: '<div class="fileuploader-items">' +
                    '<ul class="fileuploader-items-list">' +
                    '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i>+</i></div></li>' +
                    '</ul>' +
                    '</div>',
                item: '<li class="fileuploader-item">' +
                    '<div class="fileuploader-item-inner">' +
                    '<div class="type-holder">${extension}</div>' +
                    '<div class="actions-holder">' +
                    '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                    '</div>' +
                    '<div class="thumbnail-holder">' +
                    '${image}' +
                    '<span class="fileuploader-action-popup"></span>' +
                    '</div>' +
                    '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                    '<div class="progress-holder">${progressBar}</div>' +
                    '</div>' +
                    '</li>',
                item2: '<li class="fileuploader-item">' +
                    '<div class="fileuploader-item-inner">' +
                    '<div class="type-holder">${extension}</div>' +
                    '<div class="actions-holder">' +
                    '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i class="fileuploader-icon-download"></i></a>' +
                    '<button type="button" class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i class="fileuploader-icon-sort"></i></button>' +
                    '<button type="button" class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="fileuploader-icon-remove"></i></button>' +
                    '</div>' +
                    '<div class="thumbnail-holder">' +
                    '${image}' +
                    '<span class="fileuploader-action-popup"></span>' +
                    '</div>' +
                    '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                    '<div class="progress-holder">${progressBar}</div>' +
                    '</div>' +
                    '</li>',
                startImageRenderer: false,
                canvasImage: false,
                _selectors: {
                    list: '.fileuploader-items-list',
                    item: '.fileuploader-item',
                    start: '.fileuploader-action-start',
                    retry: '.fileuploader-action-retry',
                    remove: '.fileuploader-action-remove'
                },
                onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();

                    if (item.format == 'image') {
                        item.html.find('.fileuploader-item-icon').hide();
                    }
                },
                onItemRemove: function(html, listEl, parentEl, newInputEl, inputEl) {
                    var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                        api = $.fileuploader.getInstance(inputEl.get(0));

                    html.children().animate({
                        'opacity': 0
                    }, 200, function() {
                        html.remove();

                        if (api.getOptions().limit && api.getChoosedFiles().length - 1 < api.getOptions().limit)
                            plusInput.show();
                    });
                }
            },
            dragDrop: {
                container: '.fileuploader-thumbnails-input'
            },
            afterRender: function(listEl, parentEl, newInputEl, inputEl) {
                var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));

                plusInput.on('click', function() {
                    api.open();
                });

                api.getOptions().dragDrop.container = plusInput;
            },
            upload: {
                url: '<?= site_url('entry/upload_multiple/' . ($entry ?? 0) . '/' . $idname . 'file') ?>',
                data: {conf:`<?= base64_encode(json_encode($config)); ?>`},
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,
                beforeSend: null,
                onSuccess: function(data, item) {
                    if (!data.isSuccess) {
                        toastr.error(data.warnings[0]);
                        return;
                    }
                    toastr.success(data.files[0].name + ' uploaded.');

                    item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
                    item.data.url = data.files[0].url;
                    item.data.file = data.files[0].file;

                    setTimeout(function() {
                        item.html.find('.progress-holder').hide();
                        item.renderThumbnail();

                        item.html.find('.fileuploader-action-popup, .fileuploader-item-image').show();
                        item.html.find('.fileuploader-action-remove').before('<button type="button" class="fileuploader-action fileuploader-action-sort" title="Sort"><i class="fileuploader-icon-sort"></i></button>');
                    }, 400);
                },
                onError: function(item) {
                    item.html.find('.progress-holder, .fileuploader-action-popup, .fileuploader-item-image').hide();
                },
                onProgress: function(data, item) {
                    var progressBar = item.html.find('.progress-holder');

                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }

                    item.html.find('.fileuploader-action-popup, .fileuploader-item-image').hide();
                }
            },
            sorter: {
                selectorExclude: null,
                placeholder: null,
                scrollContainer: window,
                onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                    var api = $.fileuploader.getInstance(inputEl.get(0)),
                        fileList = api.getFileList(),
                        _list = [];

                    $.each(fileList, function(i, item) {
                        _list.push({
                            name: item.name,
                            file: item.data.file ?? item.file,
                            size: item.size,
                            url: item.data.url,
                            type: item.type,
                            index: item.index
                        });
                    });

                    <?= $idname ?>list = _list;
                    $('#<?= $idname ?>').val(JSON.stringify(<?= $idname ?>list)).trigger('change');
                }
            },
            onRemove: function(item) {
                $.post('<?= site_url('entry/remove_uploaded/' . ($entry ?? 0) . '/' . $idname . 'file') ?>', {
                    file: item.name
                }, function(data) {
                    var res = JSON.parse(data)
                    if(res.response_code == 200)
                        toastr.success(res.response_message);
                    else
                        toastr.warning(res.response_message);
                });
            }
        });

    });
</script>