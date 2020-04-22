require('./bootstrap')

require('fontawesome-iconpicker')

// jQuery serializeObject
require('form-serializer')

// Toastr
window.toastr = require('toastr')
toastr.options = {
    'closeButton': true,
    'positionClass': 'toast-top-center',
}

// jQuery TreeGrid
require('jquery-treegrid/js/jquery.treegrid')
require('jquery-treegrid/js/jquery.treegrid.bootstrap3')

// Bootstrap Switch
require('bootstrap-switch')

// Bootstrap Fileinput
require('bootstrap-fileinput')
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
fileinputPreview = function (data) {
    if (typeof (data) != 'object') {
        data = [data]
    }
    let preview = []
    $(data).each(function (i, v) {
        if (v.length > 0) {
            preview.push("<img src='" + v + "' class='file-preview-image'>")
        }
    })
    return preview
}

// DataTables
require('datatables.net-bs')
$.extend($.fn.dataTable.defaults, {
    language: {
        url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Chinese.json'
    }
})

// iCheck
require('icheck')

// Select2
require('select2')

// WangEditor
window.wangEditor = require('wangeditor')

// AdminLTE
require('admin-lte')

// jQuery Extend
$.fn.ModalFormSubmit = function (callback) {
    let form = this
    let formData = form.serializeObject()
    let method = 'GET'
    if (formData._method) {
        method = formData._method
    } else if (form.attr('method')) {
        method = form.attr('method')
    }
    $.ajax({
        url: form.attr('action'),
        type: method,
        dataType: 'json',
        data: formData,
        success: function (req) {
            if (req.code != 0) {
                toastr.error(req.message)
                return false
            }
            $('#modal-form').trigger('click.dismiss.bs.modal')
            toastr.success(req.message)
            callback()
            return this
        },
        error: function (req) {
            let res = req.responseJSON
            if (res.errors) {
                form.find('.form-group').removeClass('has-error')
                form.find('.help-block').remove()
                $.each(res.errors, function (field, errors) {
                    let $field = form.find('#' + field)
                    $field.parent('.form-group').addClass('has-error')
                    $.each(errors, function (i, error) {
                        $field.parent('.form-group').append($('<span></span>').addClass('help-block').text(error))
                    })
                })
            } else if (res.message) {
                toastr.error(res.message)
            } else {
                toastr.error("{{__('admin.failed')}}")
            }
            return this
        }
    })
}

$(function () {
    // Setting
    if (setting.toastr.type == 'success') {
        toastr.success(setting.toastr.message)
    } else if (setting.toastr.type == 'error') {
        toastr.error(setting.toastr.message)
    }

    // Form Style
    $('input.icp').iconpicker({
        placement: 'bottomRight',
        templates: {
            search: '<input type="search" class="form-control iconpicker-search" placeholder="筛选" />'
        }
    })

    $('input.switch').each(function () {
        $(this).bootstrapSwitch({
            onText: '是',
            offText: '否'
        }).bootstrapSwitch('state', $(this).is(':checked'))
    })

    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    })

    $('select.select2').select2()

    // Modal
    $("#modal-form").on("hidden.bs.modal", function () {
        $(this).removeData("bs.modal")
    });

    $(document).on('click', '.modal-form', function () {
        $('#modal-form').modal({
            remote: $(this).data('remote')
        })
    }).on('click', '.modal-delete', function () {
        $('#modal-delete').attr('action', $(this).data('remote'))
        $('#modal-delete').modal('show')
    })
})