showApp.controller('formController', function ($scope, $compile) {
    $scope.submit = function ($event) {
        $event.preventDefault();

        $form = angular.element($event.target).closest('form');
        $filter = $form.serializeArray();

        $target = $form.data('target');

        if ($target === undefined) {
            $target = '#container';
        }

        ajax_data($filter, $compile, $scope, $form, $target);
    }
});

showApp.controller('sortController', function ($scope, $compile) {
    $scope.sort = function ($event, val) {
        $scope.sort_type = !val;
        var order = '';
        if ($scope.sort_type) {
            order = 'asc';
        } else {
            order = 'desc';
        }
        var field = $event.target.href.split('?sort_field=')[1];
        $form = angular.element($event.target).closest('form');
        $filter = $form.serializeArray();
        $filter.push({name: 'sort_field', value: field}, {name: 'sort_type', value: order});

        $target = $form.data('target');

        if ($target === undefined) {
            $target = '#container';
        }

        ajax_data($filter, $compile, $scope, $form, $target);
    }
});

showApp.controller('containerController', function ($scope, $compile) {
    $scope.refresh = function ($filter, $target) {
        if ($target === undefined) {
            $target = '#container';
        }
        $form = angular.element($target).find('form');
        ajax_data($filter, $compile, $scope, $form, $target);
    }
    $scope.compiled = function ($data, $target) {
        $($target).html($compile($data)($scope));
        $.getScript("/assets/js/deleteRows.js");
    }
});

function ajax_data($filter, $compile, $scope, $form, $target) {
    if ($target === undefined) {
        $target = '#container';
    }
    $.ajax({
        url: $form.attr("action"),
        type: "get",
        datatype: "html",
        data: $filter,
        cache: true,
        beforeSend: function ()
        {
            $($target).append('<div class="loader"><img src="/assets/images/preloader.svg"/></div>');
        }
    }).done(function (data){
        $($target).html($compile(data)($scope), $target);
        $.getScript("/assets/js/deleteRows.js");
    });
}

$(document).ready(function () {
    $(document).on('click', '.table-list-footer .pagination a', function (event){
        $('.table-list-footer li').removeClass('active');
        $(this).parent('.table-list-footer li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
        var filter = $(this).attr('href').split('?')[1];
        
        $form = angular.element($(this)).closest('form');
        $target = $form.data('target');
        
        if ($target === undefined) {
            $target = '#container';
        }
                
        var scope = angular.element($target).scope();

        scope.refresh(filter, $target);
        scope.$apply();
    });

    $(document).on('click', '.ordering a', function (event) {
        event.preventDefault();
    });
});