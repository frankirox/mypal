<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use backend\widgets\Alert;

$bundle = \common\widgets\ProfilePicture\assets\ProfilePictureAsset::register($this);

$js = <<<JS

var imgSelect = {
	
	webcamActionUrl: '{$webcamActionUrl}',
	uploadActionUrl: '{$uploadActionUrl}',
	saveActionUrl: '{$saveActionUrl}',
	alert: '.imgSelect-alert', //Response selector
	setImg: '.{$imgReplacingClass}',            //Image src to be replaced 
	crop: {
	    handles: true,
        parent: '.imgSelect-webcam .crop',
		width:  200,  // Default selection width (in pixels)
		height: 200,  // Default selection height (in pixels)
		aspectRatio: '1:1', // A string of the form "width:height" which represents the aspect ratio to maintain (http://andrew.hedges.name/experiments/aspect_ratio/)
		//maxHeight:,	 // Maximum selection height (in pixels)
		//maxWidth:,	 // Maximum selection width (in pixels)
		//minHeight:,	 // Minimum selection height (in pixels)
		//minWidth:,	 // Minimum selection width (in pixels)
	},
	webcamWidth:  500,   //Webcam width
	webcamHeight: 375,   //Webcam height
	
	//Upload image
	upload: function() {
		var alert = $(imgSelect.alert);

		new AjaxUpload( $('.ajaxupload') , {
			action: imgSelect.uploadActionUrl,
			data: {'action': 'upload'},
			name: 'ajax-uploadimage',
			responseType: 'json',
			onSubmit: function(file, ext) {
				imgSelect.removeSelection();
				alert.removeClass('alert-success alert-danger').text('Uploading image...').show();
			},
			onComplete: function(img, data) {
				if (data.success) {
					imgSelect.cancel();
					$('#modal_profile_picture').modal('show');
					$('.imgSelect-container, .imgSelect-upload, .imgSelect-actions').show();
					$('.imgSelect-upload').append( $('<img/>', {src: data.data}) );
					imgSelect.setSelection( $('.imgSelect-upload img') , '.imgSelect-upload');
					alert.hide();
				} 
				else 
					alert.removeClass('alert-success').addClass('alert-danger').text(data.data);
			},
			onChange: function() {
				imgSelect.cancel();
				$('.imgSelect-container, .imgSelect-upload').show();
			}
		});
	},
	
	//Webcam snapshot
	newWebcam: function() {
	
		imgSelect.removeSelection();
		$('.imgSelect-container, .imgSelect-webcam, .imgSelect-upload, .imgSelect-actions').hide();
		$('.imgSelect-upload, .imgSelect-webcam .crop').html('');
		$('.imgSelect-container .new-snap').hide();
		
	  	$('.imgSelect-container, .imgSelect-webcam, .imgSelect-actions').show();
		$('.imgSelect-actions .save').hide();
		$('.imgSelect-actions .capture').show();
		
        Webcam.set({
            width: 320,
            height: 240,
            //force_flash: true,
            image_format: 'jpeg',
			jpeg_quality: 90,
			upload_name: 'webcam',
            swfURL: '{$bundle->baseUrl}' + '/swf/webcam.swf',
        });
        
        Webcam.attach( '.imgSelect-webcam .preview' );
      
	},

	//Webcam snapshot
	webcam: function() {
	
	    imgSelect.cancel();
	  	$('.imgSelect-container, .imgSelect-webcam, .imgSelect-actions').show();
		$('.imgSelect-actions .save').hide();
		$('.imgSelect-actions .capture').show();
        $('#modal_profile_picture').modal('show');
		
        Webcam.set({
            width: 320,
            height: 240,
            //force_flash: true,
            image_format: 'jpeg',
			jpeg_quality: 90,
			upload_name: 'webcam',
            swfURL: '{$bundle->baseUrl}' + '/swf/webcam.swf',
        });
        
        Webcam.attach( '.imgSelect-webcam .preview' );
      
      
	},

	webcamSnap: function() {
		
		Webcam.snap( function(data_uri) {
            // snap complete, image data is in 'data_uri'

            Webcam.upload( data_uri, imgSelect.webcamActionUrl, function(code, text) {
                
                if (text != 0 && code == 200) {
                    $('.imgSelect-actions .capture').hide();
                    Webcam.reset();
                    $('.imgSelect-webcam .preview').html('').removeAttr('style');
                    $('.imgSelect-webcam .crop').append( $('<img/>', {src: text}) );
                    $('.imgSelect-container .new-snap, .imgSelect-actions .save').show();
                    imgSelect.setSelection( $('.imgSelect-webcam img'), '.imgSelect-webcam .crop');
                }
                else {
                    imgSelect.webcam();
                    alert.text('Webcam Error. Try again.');
                }
                
            } );

        });
    
	},

	//Save image after crop
	save: function() {
		var data,
			img = $('.imgSelect-container img'),
			crop = imgSelect.crop,
			alert = $(imgSelect.alert);

		if (img.length) {
			var x1 = $('#x1').val(),
				y1 = $('#y1').val(),
				w  = $('#w').val(),
				h  = $('#h').val();

			if (w == "" || w == 0)
				w  = crop.width;
			if (h == "" || h == 0)
				h  = crop.height;
			
			data = {action:'save', 'x1': x1, 'y1': y1, 'w': w, 'h': h};
			
			$.ajax({
				url: imgSelect.saveActionUrl,
				type: 'POST',
				dataType: 'json',
				data: data,
				beforeSend: function() {
					alert.removeClass('alert-success alert-danger').text('Saving image...').show();
					$('.imgSelect-actions .save').prop('disabled', true);
				},
				success: function(data) {
					if (data.success) {
					    $('#modal_profile_picture').modal('hide');
						$(imgSelect.setImg).attr('src', data.data);
						imgSelect.cancel();
						alert.addClass('alert-success').text('Successfully saved.');
						setTimeout(function(){ alert.fadeOut(); }, 2000);
					}
					else 
						alert.addClass('alert-danger').text(data.data);
				},
				complete: function() { $('.imgSelect-actions .save').prop('disabled', false); },
				error: function() { alert.addClass('alert-danger').text('Ajax Error. Try again.'); }
			});
		}
	},
	setSelection: function(img, parentdiv) {
		img.load(function(){
			var w, h, x1, y1, x2, y2, settings, crop = imgSelect.crop;

			w = img.width();
			h = img.height();
			x1 = Math.round(w/2) - crop.width/2;
			x2 = x1 + crop.width;
			y1 = Math.round(h/2) - crop.height/2;
			y2 = y1 + crop.height;

			settings = {
                parent: parentdiv,
				aspectRatio: crop.aspectRatio, 
				onSelectChange: imgSelect.updateSelection,
				x1: x1, y1: y1, x2: x2, y2: y2
			};

			if (crop.maxWidth)
				settings.maxWidth = crop.maxWidth;
			if (crop.maxHeight)
				settings.maxHeight = crop.maxHeight;
			if (crop.minWidth)
				settings.minWidth = crop.minWidth;
			if (crop.minHeight)
				settings.minHeight = crop.minHeight;

			img.imgAreaSelect(settings);
			
			$('#x1').val(x1);
			$('#y1').val(y1);
		});
	},
	updateSelection: function(img, selection) {
		$('#x1').val(selection.x1);
		$('#y1').val(selection.y1);
		$('#w').val(selection.width);
		$('#h').val(selection.height);
	},
	cancel: function() {
	
	    $('#modal_profile_picture').modal('hide');
		imgSelect.removeSelection();
		Webcam.reset();
		$('.imgSelect-container, .imgSelect-webcam, .imgSelect-upload, .imgSelect-actions').hide();
		$('.imgSelect-upload, .imgSelect-webcam .crop').html('');
		$('.imgSelect-container .new-snap').hide();
	},
	removeSelection: function () {
		if ( $('[class^="imgareaselect-"]').length )
			$('[class^="imgareaselect-"]').remove();
	}
};

$(function() {
	if (!$('#ajax-uploadimage').length)
		imgSelect.upload();	
});

JS;


$this->registerJs($js, \yii\web\View::POS_END, 'imgSelectJS')

?>

<div id="modal_profile_picture" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= Yii::t('miranda/backend', 'Update Profile Picture') ?></h4>
            </div>
            <div class="modal-body" style="padding: 0">
                <div class="imgSelect-alert alert"></div>
                <!-- imgSelect container -->
                <div class="imgSelect-container">
                    <div class="imgSelect-upload"></div>
                    <div class="imgSelect-webcam">
                        <div class="crop"></div>
                        <div class="preview"></div>
                    </div>

                    <input type="hidden" id="x1">
                    <input type="hidden" id="y1">
                    <input type="hidden" id="w">
                    <input type="hidden" id="h">

                    <div class="imgSelect-actions">
                        <button type="button" class="btn btn-primary btn-small save" onclick="imgSelect.save()">Save
                            Image
                        </button>
                        <button type="button" class="btn btn-primary btn-small new-snap"
                                onclick="imgSelect.newWebcam()">New Snapshot
                        </button>
                        <button type="button" class="btn btn-primary btn-small capture"
                                onClick="imgSelect.webcamSnap()">Capture
                        </button>
                        <button type="button" class="btn btn-default btn-small" onClick="imgSelect.cancel()">Cancel
                        </button>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-12">
                <img src="<?= $model->{$attribute} ?>" width="200" height="200"
                     class="img img-thumbnail <?= $imgReplacingClass ?>">
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">
                <!-- Upload/Webcam buttons -->
                <button type="button" class="btn btn-info btn-block ajaxupload">Upload</button>

            </div>
            <div class="col-md-6">
                <!-- Upload/Webcam buttons -->
                <button type="button" class="btn btn-success btn-block" onclick="imgSelect.webcam()">Webcam</button>
            </div>
        </div>


    </div>
</div>
