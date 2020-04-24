require('./bootstrap')

// jQuery Toastr
toastr.options = {
    'closeButton': true,
    'positionClass': 'toast-top-center',
}

// Bootstrap Fileinput
require('bootstrap-fileinput/js/locales/zh')
$.extend($.fn.fileinput.defaults, {
    language: 'zh',
    showClose: false,
    showRemove: false,
    showUpload: false,
    showCaption: false,
    dropZoneEnabled: false,
    allowedFileTypes: ['image']
})

// DataTables
$.extend($.fn.dataTable.defaults, {
    language: {
        url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Chinese.json'
    }
})

// jQuery Extend
$.fn.modalFormSubmit = function (callback) {
    let $form = $(this)
    $form.ajaxSubmit({
        success: function (req) {
            if (req.code != 0) {
                toastr.error(req.message)
                return false
            }
            $('#modal-form').modal('hide')
            toastr.success(req.message)
            callback()
            return this
        },
        error: function (req) {
            let res = req.responseJSON
            if (res.errors) {
                $form.find('.form-group').removeClass('has-error')
                $form.find('.help-block').remove()
                $.each(res.errors, function (field, errors) {
                    let $field = $form.find('#' + field)
                    $field.parent('.form-group').addClass('has-error')
                    $.each(errors, function (i, error) {
                        $field.parent('.form-group').append($('<span></span>').addClass('help-block').text(error))
                    })
                })
            } else if (res.message) {
                toastr.error(res.message)
            } else {
                toastr.error('失败')
            }
            return this
        }
    })
}

$.fn.formInit = function () {
    let $form = $(this)

    // Font Awesome Iconpicker
    $form.find('input.icp').iconpicker({
        placement: 'bottomRight',
        templates: {
            search: '<input type="search" class="form-control iconpicker-search" placeholder="筛选" />'
        }
    })

    // Bootstrap Switch
    $form.find('input.switch').each(function () {
        $(this).bootstrapSwitch({
            onText: '是',
            offText: '否'
        }).bootstrapSwitch('state', $(this).is(':checked'))
    })

    // Bootstrap Fileinput
    $form.find('input:file').each(function () {
        let $file = $(this)
        let value = $file.data('value')
        let preview = []
        if (value) {
            $.each(value.split(','), function (i, v) {
                if (v.length > 0) {
                    preview.push('<img src="' + v + '" class="file-preview-image">')
                }
            })
        }
        $file.fileinput({
            initialPreview: preview
        })
    })

    // iCheck
    $form.find('input.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    })

    // Select2
    $form.find('select.select2').select2()
}

$(function () {
    // Form Initialize
    $(document).formInit()

    // Setting
    if (setting.toastr.type == 'success') {
        toastr.success(setting.toastr.message)
    } else if (setting.toastr.type == 'error') {
        toastr.error(setting.toastr.message)
    }

    // Modal
    $('#modal-form').on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal')
    })
    $('#modal-form').on('shown.bs.modal', function () {
        $(this).formInit()
    })

    $(document).on('click', '.modal-form', function () {
        $('#modal-form').modal({
            remote: $(this).data('remote')
        })
    }).on('click', '.modal-delete', function () {
        $('#modal-delete').attr('action', $(this).data('remote'))
        $('#modal-delete').modal('show')
    })
})