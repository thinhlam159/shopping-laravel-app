$(function () {
    $(".tags-select-choosen").select2({
        tags: true,
        tokenSeparators: [',']
    })
    $(".select2-init").select2({
        placeholder: {
            id: '-1', // the value of the option
            text: 'Select an option'
        },
        allowClear: true
    })
    let editor_config = {
        path_absolute: "/",
        selector: 'textarea.my-editor',
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback: function (callback, value, meta) {
            let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            let y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            let cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
            if (meta.filetype == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.openUrl({
                url: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no",
                onMessage: (api, message) => {
                    callback(message.content);
                }
            });
        }
    };
    tinymce.init(editor_config);
})
//upload image script
$(function () {
    $.fn.attachmentUploader = function () {
        const uploadControl = $(this).find('.js-form-upload-control');
        const btnClear = $(this).find('.btn-clear');
        $(uploadControl).on('change', function (e) {
            const preview = $(this).closest('.form-upload').children('.form-upload__preview');
            const files = e.target.files;

            function previewUpload(file) {
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    var reader = new FileReader();
                    reader.addEventListener('load', function () {
                        const html =
                            '<div class=\"form-upload__item\">' +
                            '<div class="form-upload__item-thumbnail" style="background-image: url(' + this.result + ')"></div>' +
                            '<p class="form-upload__item-name">' + file.name + '</p>' +
                            '</div>';
                        preview.append(html);
                        btnClear.show()
                    }, false);
                    reader.readAsDataURL(file);
                } else {
                    alert('Please upload image only');
                    uploadControl.val('');
                }
            }

            [].forEach.call(files, previewUpload);

            btnClear.on('click', function () {
                // $('.form-upload__item').remove();
                $(this).closest('.form-upload').find('.form-upload__item').remove()
                uploadControl.val('');
                $(this).hide()
            })
        })
    }
})

$(document).ready( function() {
    $('.form-main-image-upload').attachmentUploader()
    $('.form-image-detail-upload').attachmentUploader()
});



