$(document).ready(() => {
    $('select').change((event) => {
        let tr = $(event.target).closest('tr');
        let a = tr.find('a.select-user-role');
        let href = a.attr('href');
        let new_href = href.replace(/\?role=.*&/g, '?role=' + $(event.target).find('option:selected').val() + '&');
        a.attr('href', new_href);
    });

    $('.select-user-role,.select-user-remove').on('click', (event) => {
        let element = event.target;
        event.preventDefault();
        let link = $(element).closest('a');
        let controller_action = $(link).attr('href');

        $.get(controller_action, (result) => {
        }).done((result) => {
            $.notify(result.message);
            if ($(link).hasClass('select-user-remove')) window.location.reload();
        });

    });
});