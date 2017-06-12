/**
 * Override the default yii confirm dialog. This function is
 * called by yii when a confirmation is requested.
 *
 * @param string message the message to display
 * @param string ok callback triggered when confirmation is true
 * @param string cancelCallback callback triggered when cancelled
 */
yii.confirm = function (message, okCallback, cancelCallback) {

    if(typeof message === 'object'){

        swal({
            html: message.isHTML,
            title: message.title,
            text: message.text,
            type: message.type,
            confirmButtonText: message.confirmButtonText,
            cancelButtonText: message.cancelButtonText,
            showConfirmButton : ((message.confirmButtonText == undefined || message.confirmButtonText == '')? false :  true),
            showCancelButton: ((message.cancelButtonText == undefined || message.cancelButtonText == '')? false :  true),
            imageUrl: ((message.imageUrl == undefined || message.imageUrl == '')? "" : message.imageUrl),
            closeOnConfirm: true,
            allowOutsideClick: true,
            confirmButtonColor:  ((message.confirmButtonColor == undefined || message.confirmButtonColor == '')? "#31708F" :  message.confirmButtonColor),
            animation: "pop",
        }, okCallback);

    }else{

        if (confirm(message)) {
            !okCallback || okCallback();
        } else {
            !cancelCallback || cancelCallback();
        }

    }


};