var myckeditor = [];
var inputChanged;

function initEntryScript() {
    // Prevent close form before save
    inputChanged = false;
    $('.entryForm').find('input,select,textarea').on('keyup change', function() {
        inputChanged = true;
    })
    $('.entryForm').on('submit', function() {
        inputChanged = false;
    })
    window.addEventListener('beforeunload', function(e) {
        if (inputChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    $('.color').colorPicker({
        opacity: true
    });

    $(".slugify input.title").keyup(function() {
        var title = $(this).val();
        $("input.slug").val(convertToSlug(title));
    });

    var to_reffer = $('.slugify').data('referer');

    $("#" + to_reffer).keyup(function() {
        var content = $(this).val();
        $('.slugify').val(convertToSlug(content));
    });

    $('.btn-connect-relation').click(function() {
        var id = $('#id').val();
        var entry = $('#entry').val();
        var relation = $('#relation').val();
        var choosen = $('#choice input:checked').map(function() {
            return $(this).val();
        });

        $.post(base_url + 'admin/entry/entry/update_relation', {
                id: id,
                entry: entry,
                relation: relation,
                choosen: choosen.get()
            })
            .done(function(data) {
                if (data = 'done') {
                    location.reload();
                }
            });
    });

    // Ace Editor
    let aceEntryEditors = [];
    let codeEditorElms = $('.code_editor');
    codeEditorElms.each(function(i, obj) {
        let editorID = $(obj).attr('id');
        let editorInputID = $(obj).data('input-id');
        aceEntryEditors[editorID] = ace.edit(editorID);
        aceEntryEditors[editorID].session.setMode("ace/mode/" + $(obj).data('mode'));
        document.getElementById(editorID).style.fontSize = '16px';
        aceEntryEditors[editorID].session.setUseWrapMode(true);
        aceEntryEditors[editorID].session.setOption('tabSize', 2);
        aceEntryEditors[editorID].session.on('change', function(delta) {
            $('#' + editorInputID).val(aceEntryEditors[editorID].getValue());
        });
    })

    $('.ajaxupload').on('change', function(e) {
        console.log(e.target.files);
        $.ajax({
            url: "https://madrasahdigital.id/entry/upload",
            type: "POST",
            data: e.target.files,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data)
            }
        });
    })
}
$(function(){
    initEntryScript();

})

/* HELPER FUNCTIONS */
//////////////////////

function convertToSlug(Text) {
    return Text
        .toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for (var i = 0; i < length; i++) {
        if (typeof haystack[i] == 'object') {
            if (arrayCompare(haystack[i], needle)) return true;
        } else {
            if (haystack[i] == needle) return true;
        }
    }
    return false;
}

// CKEditor insert image to editor
function insertImages(editor, url) {
    const imageCommand = editor.commands.get('insertImage');
    if (!imageCommand.isEnabled) {
        const notification = editor.plugins.get('Notification');
        const t = editor.locale.t;
        notification.showWarning(t('Could not insert image at the current position.'), {
            title: t('Inserting image failed'),
            namespace: 'rfm'
        });
        return;
    }
    editor.execute('insertImage', {
        source: url
    });
}

// Add rfm callback to place image to ckeditor
function responsive_filemanager_callback(field_id) {
    let splitID = field_id.split('__');
    if (splitID[1] == 'entry') {
        insertImages(myckeditor[splitID[0]], $('#' + field_id).val());
    }
}