$(function () {
    $('.colorpicker').colorpicker({
        format: 'rgb'
    }).on('changeColor', function (event) {
        var color = event.color.toRGB();
        $('#site-content-wrapper').css('background', 'rgba(' + color.r + ', ' + color.g + ', ' + color.b + ', ' + color.a + ')');
    });
});
