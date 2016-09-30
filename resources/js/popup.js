var popup_number = 0;
var popup_bottom = 0;

function popup(i__type, i__text, i__title, i__seconds) {
    l__title = (typeof i__title == 'undefined') ? 'Info' : i__title;
    l__seconds = (typeof i__seconds == 'undefined') ? 3 : i__seconds;
    l__type = (typeof i__type == 'undefined') ? '' : i__type;
    popup_number += 1;
    var popupid = "popup" + (new Date().getTime());
    $('body').append("<div id='" + popupid + "' class='popup' style='bottom:" + popup_bottom + "px'><h1 class='"+l__type+"'>" + l__title + "<img popupid='" + popupid + "' class='imgpopup' src='/ifogames/resources/img/cross.png'/></h1><p>" + i__text + "</p></div>");
    popup_bottom += parseInt($("#" + popupid).css('height'));
    $('#' + popupid).hide();
    $('#' + popupid).fadeIn('normal', function () {
    });
    $('#' + popupid).click(function () {
        delete_popup(popupid);
    });
    setTimeout("delete_popup('" + popupid + "')", l__seconds * 1000);
}

function delete_popup(popupid) {
    popup_number -= 1;
    var last_height = parseInt($("#" + popupid).css('height'));
    var last_bottom = parseInt($("#" + popupid).css('bottom'));
    popup_bottom -= last_height;
    $('#' + popupid).fadeOut('normal', function () {
        $('#' + popupid).remove();
    });
    $('.popup').each(function () {
        if (last_bottom < parseInt($(this).css('bottom'))) {
            $(this).animate({bottom: '-=' + last_height});
        }
    });
}