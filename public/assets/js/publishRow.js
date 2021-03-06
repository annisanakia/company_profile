$('.table-check').find('.group_check').on('ifChanged', function(){
    var set = $(this).attr("data-set");
    var checked = $(this).is(":checked");
    $(set).each(function () {
        if (checked) {
            $(this).iCheck('check');
            $(this).prop("checked", true);
            $(this).parents('tr').addClass("active");
        } else {
            $(this).iCheck('uncheck');
            $(this).prop("checked", false);
            $(this).parents('tr').removeClass("active");
        }
    });
});

$('.table-check').on('ifChanged', 'tbody tr .checkboxes', function(){
    $(this).parents('tr').toggleClass("active");
});

$('.publish-row').click(function (event) {
    $('.publishConfirm').modal('show');
    $('.publishConfirm #publish-this').attr('href', '');
});

$('#publish-this').click(function (event) {
    if ($('.publishConfirm #publish-this').attr('href') == '') {
        event.preventDefault();
        var target = $(this).data('target');
        if (target === undefined) {
            target = '#container';
        }
        
        var data = $(target+" form").serializeArray();

        $.ajax({
            type: 'post',
            url: window.location.href.replace('#', "") + '/publish',
            data: data
        }).done(function (data) {
            location.reload();
        });
    }
});

$('.copy-row').click(function (event) {
    var url = $(this).data('url');
    if (url != '' || url != '#') {
        $(this).closest('form').attr('action', url);
        $(this).closest('form').submit();
    }
});