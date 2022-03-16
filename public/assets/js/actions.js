$(document).ready(function() {
    $('.iCheck').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    
    function linkPage(url, target) {
        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            data: {},
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
                $('.modal-backdrop').remove();
                $('.menu-vertical').removeClass('modal-open');
                $('.menu-vertical').removeAttr('style');
            }
        });
    }

    $('#container .add-data').click(function (event) {
        event.preventDefault();
        var $this = $(this),
                url = $this.attr('href'),
                data = {},
                target = $this.attr('data-target2');

        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            data: data,
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
            }
        });
    });

    $('#container .save-data').click(function (e) {
        if ($("#container-add .form-validation").valid()) {
            var $this = $(this),
                linkIndex = $this.attr('linkIndex'),
                target = '#container-add';

            $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

            $('#container-add #form-tab-ajax').ajaxForm({
                success: function (e) {
                    if(e == true){
                        $('#addModal').modal('hide');
                        linkPage(linkIndex, '#container');
                    }else{
                        var scope = angular.element(target).scope();
                        scope.compiled(e, target);
                        scope.$apply();
                    }
                }
            }).submit();
        }
        scrollBack("#container-add .form-validation");
    });

    $('#container .table-list .edit-data').click(function (event) {
        event.preventDefault();
        var $this = $(this),
                url = $this.attr('href'),
                data = {},
                target = $this.attr('data-target2');

        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            data: data,
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
            }
        });
    });

    $('#container .update-data').click(function (e) {
        if ($("#container-edit .form-validation").valid()) {
            var $this = $(this),
                linkIndex = $this.attr('linkIndex'),
                target = '#container-edit';

            $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

            $('#container-edit #form-tab-ajax').ajaxForm({
                success: function (e) {
                    if(e == true){
                        $('#editModal').modal('hide');
                        linkPage(linkIndex, '#container');
                    }else{
                        var scope = angular.element(target).scope();
                        scope.compiled(e, target);
                        scope.$apply();
                    }
                }
            }).submit();
        }
        scrollBack("#container-edit .form-validation");
    });

    $('#container .table-list .detail-data').click(function (event) {
        event.preventDefault();
        var $this = $(this),
                url = $this.attr('href'),
                data = {},
                target = $this.attr('data-target2');

        $(target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');

        $.ajax({
            url: url,
            data: data,
            success: function (e) {
                var scope = angular.element(target).scope();
                scope.compiled(e, target);
                scope.$apply();
            }
        });
    });
});