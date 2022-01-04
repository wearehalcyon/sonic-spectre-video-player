<?php
// Including files from ASSETS directory
require_once IDVP_ROOT . '/assets/assets.php';

// Including files from INCLUDES directory
require_once IDVP_ROOT . '/includes/post-type.php';

// Including files from SHORTCODES directory
require_once IDVP_ROOT . '/includes/shortcodes/basic.php';

// Kernel code
add_action('edit_form_top', 'idvp_actions_description', 5); // Description
function idvp_actions_description(){
    global $post;
    if (get_post_type() == idvp_plugin_data('post_type')) {
        echo '<div class="idvp_description">';
            echo '<strong>Description:</strong> Thumbnail will be used as video poster.<br><strong>Basic use:</strong> this shortcode <i>[sonic-spectre-video-player id=' . $post->ID . ']</i>';
        echo '</div>';
    }
}

add_action('edit_form_top', 'idvp_video_title', 5); // Title
function idvp_video_title(){
    echo '<h2 class="idvp_title">Video title</h2>';
}

add_action('edit_form_after_title', 'idvp_video_uploader', 5); // Video uploader
function idvp_video_uploader(){
    global $post;

    $video_id = get_post_meta($post->ID, '_idvp_video', true);
    $video_metadata = get_post_meta($video_id, '_wp_attachment_metadata', true);
    $video = wp_get_attachment_url( $video_id );

    echo '<h2 class="idvp_uploader_title">Uploader</h2>';
    echo '<div class="idvp_uploader_button">';
        if( $video ) {
            echo '<a href="#" class="idvp_upload_btn button" style="display: none;">Select video</a>';
        } else {
            echo '<a href="#" class="idvp_upload_btn button">Select video</a>';
        }
    echo '</div>';
    if( $video ) {
        echo '<div class="idvp_video_preview">
                  <div class="idvp_preview_container">
                        <video class="idvp_video_preview_player" controls src="' . $video . '"></video>
                        <input type="text" name="idvp_video_source" readonly disabled value="' . $video . '">
                        <button class="idvp_remove_btn">×</button>
                  </div>
                  <div class="idvp_preview_data">
                        <h4 class="idvp_video_information_title">Video meta data:</h4>
                        <p><strong>File name:</strong> ' . get_the_title($video_id) . '.' . $video_metadata['fileformat'] . '</p>
                        <p><strong>Length:</strong> ' . $video_metadata['length_formatted'] . '</p>
                        <p><strong>Video added at:</strong> ' . get_the_date('F d, Y', $video_id) . '</p>
                        <p><strong>Size:</strong> ' . size_format($video_metadata['filesize']) . '</p>
                  </div>
              </div>';
    } else {
        echo '<div class="idvp_video_preview empty"></div>';
    }

    add_meta_box( 'idvp_video_advanced_settings', 'Advanced Player Settings', 'idvp_video_advanced_settings', idvp_plugin_data('post_type'), 'normal',  'high', null);
    function idvp_video_advanced_settings(){
        global $post;

        $video_id = get_post_meta($post->ID, '_idvp_video', true);
        $video_theme = get_post_meta($post->ID, '_idvp_video_theme', true);

        echo '<input type="hidden" name="idvp_video" value="' . $video_id . '">';
        echo '<div class="idvp_advanced_settings_container">
                    <div class="idvp_column">
                        <p>
                            <strong>Player theme: </strong>
                            <select name="idvp_player_theme">
                                <option value="default"' . ($video_theme == 'default' ? ' selected' : null) . '>Default</option>
                                <option value="acrylic"' . ($video_theme == 'acrylic' ? ' selected' : null) . '>Acrylic (Unsupported in FireFox)</option>
                            </select>
                        </p>
                    </div>
                    <div class="idvp_column">
                        <p>
                            <strong>Shortcode: </strong>[sonic-spectre-video-player id="' . $post->ID . '" theme="' . ucfirst($video_theme) . '"]
                        </p>
                    </div>
              </div>';
    }

	add_post_meta( $post->ID, '_idvp_video', $video );
}

add_action( 'save_post', 'idvp_save_video_metabox_data' ); // Save, update or delete video data
function idvp_save_video_metabox_data( $post_id ) {
    if (isset($_POST['idvp_video'])) {
        $video = sanitize_text_field( $_POST['idvp_video'] );
    } else {
        $video = null;
    }
    if (isset($_POST['idvp_player_theme'])) {
        $theme = sanitize_text_field( $_POST['idvp_player_theme'] );
    } else {
        $theme = null;
    }

    // work with postmeta table
    if ($video) {
        update_post_meta( $post_id, '_idvp_video', $video );
        update_post_meta( $post_id, '_idvp_video_theme', $theme );
    } else {
        delete_post_meta( $post_id, '_idvp_video', $video );
        delete_post_meta( $post_id, '_idvp_video_theme', $theme );
    }
}



// Make custom admin columns
function idvp_admin_custom_column($columns) {
    $crunchify_columns = [];
    $title = 'title';
    foreach($columns as $key => $value) {
        if ($key==$title){
            $crunchify_columns['video_poster'] = 'Preview Poster';
            $crunchify_columns['title'] = 'Video Title';
            $crunchify_columns['video_length'] = 'Length';
            $crunchify_columns['video_size'] = 'Size';
            $crunchify_columns['date'] = 'Date';
            $crunchify_columns['author'] = 'Author';
        }
        $crunchify_columns[$key] = $value;
    }
    return $crunchify_columns;
}
add_filter('manage_sonic-spectre-videos_posts_columns', 'idvp_admin_custom_column');

add_action( 'manage_sonic-spectre-videos_posts_custom_column' , 'idvp_admin_custom_column_content', 10, 2 );
function idvp_admin_custom_column_content( $column, $video_id ) {
    $videofile_id = get_post_meta($video_id, '_idvp_video', true);
    $video_metadata = get_post_meta($videofile_id, '_wp_attachment_metadata', true);
    if ( $column == 'video_poster' ) {
        if ( has_post_thumbnail($video_id) ) {
            echo '<a href="' . get_edit_post_link($video_id) . '"><img src="' . get_the_post_thumbnail_url($video_id, 'medium') . '" title="' . get_the_title() . '" alt="' . get_the_title() . '" class="idvp_custom_column_thumbnail"></a>';
        } else {
            echo '<a href="' . get_edit_post_link($video_id) . '"><img src="' . IDVP_URL . '/assets/images/no-preview.svg" title="' . get_the_title() . '" alt="' . get_the_title() . '" class="idvp_custom_column_thumbnail"></a>';
        }
    }
    if ( $column == 'video_length' ) {
        echo $video_metadata['length_formatted'];
    }
    if ( $column == 'video_size' ) {
        echo size_format($video_metadata['filesize']);
    }
}

function idv_remove_quick_edit( $actions ) {
    unset($actions['inline hide-if-no-js']);
    return $actions;
}
add_filter('post_row_actions', 'idv_remove_quick_edit', 10, 1);
