'use strict';

jQuery(document).ready(function($){
    // on upload button click
	$('body').on( 'click', '.idvp_upload_btn', function(e){

		e.preventDefault();

		var button = $(this),
		custom_uploader = wp.media({
			title: 'Insert video',
			library : {
				type : 'video'
			},
			button: {
				text: 'Use this video'
			},
			multiple: false
		}).on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
            console.log(attachment);
            button.hide();
			$('.idvp_video_preview').removeClass('empty').prepend(`
                <div class="idvp_preview_container">
                    <video class="idvp_video_preview_player" controls src="` + attachment.url + `"></video>
                    <input type="text" name="idvp_video_source" readonly disabled value="` + attachment.url + `">
                    <button class="idvp_remove_btn">×</button>
                </div>
                <div class="idvp_preview_data">
                    <h4 class="idvp_video_information_title">Video meta data:</h4>
                    <p><strong>File name:</strong> ` + attachment.filename + `</p>
                    <p><strong>Length:</strong> ` + attachment.fileLength + `</p>
                    <p><strong>Video added at:</strong> ` + attachment.dateFormatted + `</p>
                    <p><strong>Size:</strong> ` + attachment.filesizeHumanReadable + `</p>
                </div>
            `);
            $('input[name="idvp_video"]').val(attachment.id);
		}).open();

	});

	// on remove button click
	$('body').on('click', '.idvp_remove_btn', function(e){

		e.preventDefault();

		var button = $('.idvp_upload_btn');
		$('input[name="idvp_video"]').val('');
        $('.idvp_video_preview').addClass('empty');
        $('.idvp_preview_container, .idvp_preview_data').remove();
		button.show();
	});

	// Chanhe theme in select
	$('.idvp_player_theme').on('change', function(){
		let value = $(this).val();
		if (value == 'default') {
			$('span.idvp_theme_value').text('Default');
		} else {
			$('span.idvp_theme_value').text('Acrylic');
		}
	});
});