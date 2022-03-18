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

$('.delete-row').click(function (event) {
    $('.deleteConfirm').modal('show');
    $('.deleteConfirm #delete-this').attr('href', '');
});

$('.delete-data').click(function (event) {
    event.preventDefault();
    $('.deleteConfirm').modal('show');
    $('.deleteConfirm #delete-this').attr("href", $(this).attr('href'));
    console.log($(this).attr('href'));

    $target = $(this).data('target');
    $('.deleteConfirm #delete-this').attr("data-target", $target);
});

$('#delete-this').click(function (event) {
    console.log($('.deleteConfirm #delete-this').attr('href'));
    if ($('.deleteConfirm #delete-this').attr('href') == '') {
        event.preventDefault();
        var target = $(this).data('target');
        if (target === undefined) {
            target = '#container';
        }
        
        var data = $(target+" form").serializeArray();

        $.ajax({
            type: 'post',
            url: window.location.href.replace('#', "") + '/delete_row',
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