<?php
add_action('admin_head', 'idevp_admin_assets');
function idevp_admin_assets(){

    if (get_post_type() == idvp_plugin_data('post_type')) {
        // Styles
        wp_enqueue_style( 'idvp-admin-styles', IDVP_URL . 'assets/admin/css/admin.css' );

        // Scripts
        wp_enqueue_script( 'idvp-admin-scripts', IDVP_URL . 'assets/admin/js/admin.js', array('jquery'), true );
    }
}

add_action('wp_print_styles', 'idvp_assets', 11);
function idvp_assets(){
    // Styles
    wp_enqueue_style( 'idvp-gfonts', '//fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap' );
    wp_enqueue_style( 'idvp-styles', IDVP_URL . 'assets/css/main.css' );
}

add_action('wp_footer', 'idvp_scripts', 11);
function idvp_scripts(){
    wp_enqueue_script( 'idvp-scripts', IDVP_URL . 'assets/js/main.js', array('jquery'), null, true );
}
