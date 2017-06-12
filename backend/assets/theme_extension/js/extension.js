/**
 * @copyright Copyright (c) 2015 Yiister
 * @license https://github.com/yiister/yii2-gentelella/blob/master/LICENSE
 * @link http://gentelella.yiister.ru
 */

GentelellaExtension = {
    'init': function () {
        if (this.getCookie('menuIsCollapsed') == 'true') {
            jQuery('#menu_toggle').trigger('click');
        }
        jQuery('#menu_toggle').click(function() {
            GentelellaExtension.setCookie('menuIsCollapsed', jQuery('body').hasClass('nav-sm'), undefined, '/');
        });
    },
    'getCookie': function (name) {
        var cookie = " " + document.cookie;
        var search = " " + name + "=";
        var setStr = null;
        var offset = 0;
        var end = 0;
        if (cookie.length > 0) {
            offset = cookie.indexOf(search);
            if (offset != -1) {
                offset += search.length;
                end = cookie.indexOf(";", offset)
                if (end == -1) {
                    end = cookie.length;
                }
                setStr = unescape(cookie.substring(offset, end));
            }
        }
        return(setStr);
    },
    'setCookie': function (name, value, expires, path, domain, secure) {
        document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
    }
};
/*

jQuery(function() {
    GentelellaExtension.init();
});
*/

$( document ).ready(function() {

    GentelellaExtension.init();

    if ($.fn.mCustomScrollbar) {

        $('.menu_fixed').mCustomScrollbar('destroy');

        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            scrollInertia: 30,
            mouseWheelPixels: 20,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }

    /*if ($(":checkbox")[0] || $(":radio")[0]) {
        $(document).ready(function () {
            $('input[type=checkbox], input[type=radio]').iCheck({
                checkboxClass: 'flat icheckbox_flat-green',
                radioClass: 'flat iradio_flat-green'
            });
        });
    }*/
/*
    $('input.select-on-check-all').on('change', function (event) {

        var chkStatus = $(this).is(':checked');
        var chkToggle;

        chkStatus ? chkToggle = "check" : chkToggle = "uncheck";

        $('.grid-selection').each(function(){ //iterate all listed checkbox items

            $(this).iCheck(chkToggle);

        });

    });*/

});

