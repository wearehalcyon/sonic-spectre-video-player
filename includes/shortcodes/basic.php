<?php
add_shortcode('sonic-spectre-video-player', 'idvp_vsinema_basic');
if (!function_exists('idvp_vsinema_basic')) {
    function idvp_vsinema_basic($atts){
        $params = shortcode_atts(
    		[
                'id'    => 286,
                'theme' => 'default'
            ],
    		$atts
    	);
        $data = get_post($params['id']);
        $video = get_post_meta($params['id'], '_idvp_video', true);
        $source = wp_get_attachment_url( $video );
        $poster = get_the_post_thumbnail_url($data->ID, 'medium');
        $duration = get_post_meta($video, '_wp_attachment_metadata', true)['length'];

        $user = wp_get_current_user();
        $allowed_roles = array('administrator');

        ob_start();
    ?>
        <div class="idvp_svidia_player_container not_played <?php echo strtolower($params['theme']); ?>" data-idvplayer-container="<?php echo $params['id']; ?>" oncontextmenu="return false;" onmousemove="idvp_showControls(<?php echo $params['id']; ?>)">
            <div class="idvp_video_title">
                <div class="idvp_video_title_header">
                    <?php echo $data->post_title; ?>
                </div>
                <div class="idvp_svidia_player_logo">
                    <a href="<?php echo idvp_plugin_data('devurl'); ?>" class="idvp_svidia_player_logo" target="_blank"><img src="<?php echo IDVP_URL . '/assets/images/sonic-spectre-logo-white-beta.svg' ?>" class="idvp_svidia_player_logo" alt="Sonic Spectre Video Player" title="Sonic Spectre Video Player for WordPress"></a>
                </div>
            </div>
            <video src="<?php echo $source; ?>" class="idvp_svidia_player" data-svidia-id="<?php echo $params['id']; ?>" onended="idvp_stop(<?php echo $params['id']; ?>)"<?php echo $poster ? 'poster="' . $poster . '"' : null; ?>></video>
            <div class="idvp_video_controls">
                <div class="idvp_video_progress">
                    <div class="idvp_player_duration_time idvp_playert_start_time">
                        <?php echo $duration < 3600 ? '00:00' : '00:00:00'; ?>
                    </div>
                    <progress class="idvp_video_progress_bar" value="0" max="100" data-svidia-id="<?php echo $params['id']; ?>" onclick="idvp_videoewind(<?php echo $params['id']; ?>)"></progress>
                    <div class="idvp_player_duration_time idvp_playert_end_time">
                        <?php echo $duration < 3600 ? gmdate('i:s', $duration) : gmdate('H:i:s', $duration); ?>
                    </div>
                </div>
                <div class="idvp_video_controls_container">
                    <div class="idvp_video_controls_buttons">
                        <button class="idvp_player_svidia_button idvp_svidia_player_btn_play" onclick="idvp_play(<?php echo $params['id']; ?>)"><img src="<?php echo IDVP_URL . '/assets/images/play.svg' ?>" alt="Play Button"></button>
                        <button class="idvp_player_svidia_button idvp_svidia_player_btn_pause" onclick="idvp_pause(<?php echo $params['id']; ?>)"><img src="<?php echo IDVP_URL . '/assets/images/pause.svg' ?>" alt="Pause Button"></button>
                        <button class="idvp_player_svidia_button idvp_svidia_player_btn_stop" onclick="idvp_stop(<?php echo $params['id']; ?>)"><img src="<?php echo IDVP_URL . '/assets/images/stop.svg' ?>" alt="Stop Button"></button>
                        <div class="idvp_player_svidia_speedup" data-svidia-id="<?php echo $params['id']; ?>">
                            <img src="<?php echo IDVP_URL . '/assets/images/speedup.svg' ?>" alt="Speed Up to 1.25 Button">
                            <div class="idvp_player_svidia_speedup_values">
                                <button class="idvp_player_svidia_button idvp_svidia_speedup_button idvp_svidia_player_btn_speedreset idvp_active" onclick="idvp_speedReset(<?php echo $params['id']; ?>)">x1</button>
                                <button class="idvp_player_svidia_button idvp_svidia_speedup_button idvp_svidia_player_btn_speedup" onclick="idvp_speedUp(<?php echo $params['id']; ?>)">x1.25</button>
                                <button class="idvp_player_svidia_button idvp_svidia_speedup_button idvp_svidia_player_btn_speedupmore" onclick="idvp_speedUpMore(<?php echo $params['id']; ?>)">x1.5</button>
                                <button class="idvp_player_svidia_button idvp_svidia_speedup_button idvp_svidia_player_btn_speedupmaximum" onclick="idvp_speedUpMax(<?php echo $params['id']; ?>)">x2</button>
                            </div>
                        </div>
                    </div>
                    <div class="idvp_video_controls_volume">
                        <input type="range" class="idvp_svidia_player_volume" value="70" min="0" max="100" oninput="idvp_videoVolume(<?php echo $params['id']; ?>)">
                        <span class="idvp_svidia_speedup_button idvp_svidia_player_fullscreen_button idvp_open idvp_active" onclick="idvp_fullscreen(<?php echo $params['id']; ?>)"><img src="<?php echo IDVP_URL . '/assets/images/fullscreen.svg' ?>" alt="Fullscreen"></span>
                        <span class="idvp_svidia_open_settings" onclick="idvp_open_settings(<?php echo $params['id']; ?>)"><img src="<?php echo IDVP_URL . '/assets/images/cog.svg'; ?>" alt="SVidia Open Settings"></span>
                    </div>
                </div>
            </div>
            <div class="idvp_player_menu_layer main_menu">
                <div class="idvp_player_menu">
                    <div class="idvp_player_menu_item"><a href="<?php echo $source; ?>" download>Download this video</a></div>
                    <div class="idvp_player_menu_item"><a href="javascript:;" onclick="idvp_speedReset(<?php echo $params['id']; ?>)">Reset playback speed</a></div>
                    <hr class="idvp_player_menu_divider">
                    <?php if( array_intersect($allowed_roles, $user->roles ) ) : ?>
                        <div class="idvp_player_menu_item"><a href="<?php echo idvp_plugin_data('repourl'); ?>" target="_blank">Go to WP plugin page</a></div>
                    <?php endif; ?>
                    <hr class="idvp_player_menu_divider">
                    <div class="idvp_player_menu_item"><a href="javascript:;" onclick="idvp_open_about_player(<?php echo $params['id']; ?>)"><?php _e('About ' . idvp_plugin_data('name'), 'idvp'); ?></a></div>
                </div>
                <div class="idvp_player_menu_bg"></div>
            </div>
            <div class="idvp_player_menu_layer about_window">
                <div class="idvp_player_menu">
                    <strong class="title"><?php _e('Sonic Spectre Video Player', 'idvp') ?></strong>
                    <p class="textdata"><?php echo idvp_plugin_data('version'); ?></p>
                    <p class="textdata"><a href="<?php echo idvp_plugin_data('devurl'); ?>" target="_blank">Visit official website</a></p>
                </div>
                <div class="idvp_player_menu_bg"></div>
            </div>
        </div>
    <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}
