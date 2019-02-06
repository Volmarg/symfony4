$(document).ready(function () {
    $(document).delegate('.circle', 'click', function (event) {
        $(this).addClass('oppenned');
        event.stopPropagation();
    });
    $(document).delegate('body', 'click', function (event) {
        $('.circle').removeClass('oppenned');
    });
});