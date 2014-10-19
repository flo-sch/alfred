$(function() {
    $('[data-toggle="offcanvas"]').on('click', function() {
        $($(this).data('target')).toggleClass('open');
    });
});
