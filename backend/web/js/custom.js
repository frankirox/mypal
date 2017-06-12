/**
 * Created by Franchesco on 27/09/14.
 */

/**
 * Document Index:
 * A) On Document Ready Event Section
 * A1) convert conventional select boxes into bootstrap-select boxes
 * A2) Trigger tooltips for object with the .tooltip class
 * A3) Close automatically Bootstrap alerts in 5 secs
 *
 * B) Common Helpers
 * B1) common helper to prevent  a form submit event by pressing the enter key
 * B2) common helper to change any letter to Uppercase by pressing it
 *
 * C)Line to hide the loading page applied in the dashboard if the load is completed.
 *
 */

// A - On Document Ready Event Section
$(document).on('ready',function(){

    //fix modal issues with select2
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

   /* $('form').on('submit', function (e) {

        if ($(this).hasClass('avoidDisableOnSubmit') == false) {
            $(this).find('button[type=submit], input[type=submit]').prop('disabled', true);
        }

        return true;
    });

    $('form').on('ajaxComplete', function (e) {

        if ($(this).find('.has-error').length) {
            alert();
            $(this).find('button[type=submit], input[type=submit]').removeAttr('disabled');
        }

        return true;
    });

    $('form').keydown(function (e) {

        if ($(this).hasClass('allowEnter') == false) {
            var key = e.which;

            if (key == 13) {
                e.preventDefault();
                return false;
            }
        }

    });*/


    // A1) convert conventional select boxes into bootstrap-select boxes
    //$('select').selectpicker();

    // A2) Trigger tooltips for object with the .tooltip class
    $('.triggerTooltip').tooltip();

    // A3) Close automatically Bootstrap alerts in 5 secs
    window.setTimeout(function(){
        if(!$(".alert").hasClass('static')){
            $(".alert").alert('close');
        }
    }, 10000);

    $('.kv-editable-link').on('click', function(e) {
        $('.popover').each(function() {
            $(this).popover('hide');
        });
    });



    //resizable grid control
    function resizeGrid() {

        var height = 0;
        var body = window.document.body;
        var extraHeigth = 0;
        if (window.innerHeight) {
            height = window.innerHeight;
        } else if (body.parentElement.clientHeight) {
            height = body.parentElement.clientHeight;
        } else if (body && body.clientHeight) {
            height = body.clientHeight;
        }



        if(height >= 600){

            $('.auto-resizable-grid').each(function( index ) {

                if($(this).hasClass('extra-grid-height')){

                    extraHeigth = $(this).data('extra-height');
                }

                ///if($(this).find('table').height() >= ((height - $(this).offset().top) - 300 )){
                $(this).height( (height - $(this).offset().top) - 100  + extraHeigth);

            });

        }
        if(height < 600 && height >= 480){

            $('.auto-resizable-grid').each(function( index ) {

                if($(this).hasClass('extra-grid-height')){

                    extraHeigth = $(this).data('extra-height');
                }

                ///if($(this).find('table').height() >= ((height - $(this).offset().top) - 300 )){
                $(this).height( 400 + extraHeigth);

            });

        }

        if(height < 480){

            $('.auto-resizable-grid').each(function( index ) {

                if($(this).hasClass('extra-grid-height')){

                    extraHeigth = $(this).data('extra-height');
                }

                ///if($(this).find('table').height() >= ((height - $(this).offset().top) - 300 )){
                $(this).height( 300 + extraHeigth );

            });

        }


    }

    if ( $( '.auto-resizable-grid' ).length ) {

        $( window ).resize(function() {
            resizeGrid();
        });


        $(document).on('pjax:beforeSend', function(event, data, status, xhr, options) {

            $('.auto-resizable-grid').scrollLeft(0);
            $('.auto-resizable-grid').scrollTop(0);

            $(".auto-resizable-grid").LoadingOverlay("show", {
                resizeInterval : 20,
                image       : "",
                fontawesome : "fa fa-spinner fa-spin"
            });

        });

        resizeGrid();

        $(document).on('pjax:end', function(event, data, status, xhr, options) {

            resizeGrid();
            $(".auto-resizable-grid").LoadingOverlay("hide", true);
        });

        $('#main-alert-widget').on('closed.bs.alert', function(event) {

            resizeGrid();
        });



    }

    $(document).on("pjax:click", "a.no-pjax", false);


    var $BODY = $('body'),
        $MENU_TOGGLE = $('#menu_toggle');
        
    // toggle small or large menu
    /*$MENU_TOGGLE.on('click', function() {
        if ($BODY.hasClass('nav-md')) {

            $('#md-logo').show();
            $('#sm-logo').hide();
        } else {

            $('#md-logo').hide();
            $('#sm-logo').show();
        }
    });*/

    /*if ($BODY.hasClass('nav-md')) {

        $('#md-logo').show();
        $('#sm-logo').hide();
    } else {

        $('#md-logo').hide();
        $('#sm-logo').show();
    }*/
    
});


//C - Line to hide the loading page applied in the dashboard if the load is completed.
if(typeof Pace !== "undefined"){
    Pace.on("hide", function () {
    $("div.loading-page").hide();
});
}


//partial printing
function printContent(el) {

    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}


jQuery(function($) { $.extend({
    form: function(url, data, method) {
        if (method == null) method = 'POST';
        if (data == null) data = {};

        var form = $('<form>').attr({
            method: method,
            action: url
        }).css({
            display: 'none'
        });

        var addData = function(name, data) {
            if ($.isArray(data)) {
                for (var i = 0; i < data.length; i++) {
                    var value = data[i];
                    addData(name + '[]', value);
                }
            } else if (typeof data === 'object') {
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        addData(name + '[' + key + ']', data[key]);
                    }
                }
            } else if (data != null) {
                form.append($('<input>').attr({
                    type: 'hidden',
                    name: String(name),
                    value: String(data)
                }));
            }
        };

        for (var key in data) {
            if (data.hasOwnProperty(key)) {
                addData(key, data[key]);
            }
        }

        return form.appendTo('body');
    }
}); });



function generateAnimatedNotification(type, text, layout, inAnimation, outAnimation){

    if(layout == '' || layout == undefined){

        layout = 'bottomRight'
    }

    if(inAnimation == '' || inAnimation == undefined){

        inAnimation = 'bounceInRight'
    }

    if(outAnimation == '' || outAnimation == undefined){

        outAnimation = 'bounceOutRight'
    }
    //console.log('html: ' + n.options.id);
    //generateAnimatedNotification('warning', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');
    //generateAnimatedNotification('error', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');
    //generateAnimatedNotification('information', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');
    //generateAnimatedNotification('success', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');
    //generateAnimatedNotification('notification', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');
    //generateAnimatedNotification('success', 'message here','bottomRight', 'bounceInRight', 'bounceOutRight');

    /*
     * layouts:
     * Top, TopLeft, TopCenter, TopRight,
     * CenterLeft, Center, CenterRight,
     * BottomLeft, BottomCenter, BottomRight, Bottom
     */

    /*
    * Animate CSS effects:
    * bounce, flash, pulse, rubberBand, shake, headShake, swing, tada, wobble, jello, bounceIn, bounceInDown, bounceInLeft
    * bounceInUp, bounceOut, bounceOutDown, bounceOutLeft, bounceOutRight, bounceOutUp, fadeIn, fadeInDown, fadeInDownBig
    * fadeInLeft, fadeInLeftBig, fadeInRight, fadeInRightBig, fadeInUp, fadeInUpBig, fadeOut, fadeOutDown, fadeOutDownBig
    * fadeOutLeft, fadeOutLeftBig, fadeOutRight, fadeOutRightBig, fadeOutUp, fadeOutUpBig, flipInX, flipInY, flipOutX
    * flipOutY, lightSpeedIn, lightSpeedOut, rotateIn, rotateInDownLeft, rotateInDownRight, rotateInUpLeft, rotateInUpRight
    * rotateOut, rotateOutDownLeft, rotateOutDownRight, rotateOutUpLeft, rotateOutUpRight, hinge, rollIn, rollOut, zoomIn
    * zoomInDown, zoomInLeft,, slideInRight, slideInUp, slideOutDown, slideOutLeft, slideOutRight, slideOutUp
    * */

    var n = noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        layout      : layout,
        timeout     : 5000,
        closeWith   : ['click'],
        theme       : 'relax',
        template    : '<div class=\"noty_message\"><span class=\"noty_text\"></span><div class=\"noty_close\"></div></div>',
        maxVisible  : 5,
        animation   : {
            open  : 'animated ' + inAnimation,
            close : 'animated ' + outAnimation,
            easing: 'swing',
            speed : 500
        }
    });

}
