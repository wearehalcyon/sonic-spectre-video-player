<?php
// This is plugin base post type for working with videos CRUD.
function wptp_create_post_type() {
    $labels = [
        'name'               => __( 'Sonic Spectre Videos' ),
        'singular_name'      => __( 'Sonic Spectre Videos', 'idvp' ),
        'add_new'            => __( 'New Video', 'idvp' ),
        'add_new_item'       => __( 'Add New Video', 'idvp' ),
        'edit_item'          => __( 'Edit Video', 'idvp' ),
        'new_item'           => __( 'New Video', 'idvp' ),
        'view_item'          => __( 'View Video', 'idvp' ),
        'search_items'       => __( 'Search Videos', 'idvp' ),
        'not_found'          => __( 'No Videos Found', 'idvp' ),
        'not_found_in_trash' => __( 'No Videos found in Trash', 'idvp' ),
    ];
    $args = [
        'labels'               => $labels,
        'has_archive'          => false,
        'public'               => true,
        'hierarchical'         => false,
        'menu_position'        => 30,
        'publicly_queryable'   => false,
        'rewrite'              => false,
        'exclude_from_search'  => true,
        'show_in_nav_menus'    => false,
        'show_in_admin_bar'    => true,
        'menu_icon'            => 'dashicons-video-alt3',
        'supports'             => ['title', 'thumbnail'],
    ];
    register_post_type( idvp_plugin_data('post_type'), $args );
}
add_action( 'init', 'wptp_create_post_type' );
