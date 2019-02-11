$(document).ready(() => {
    $('select').change((event) => {
        let tr = $(event.target).closest('tr');
        let a = tr.find('a.select-user-role');
        let href = a.attr('href');
        let new_href = href.replace(/role=.*/g, 'role=' + $(event.target).find('option:selected').val());
        a.attr('href', new_href);
    });
});