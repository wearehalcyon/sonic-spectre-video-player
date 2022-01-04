<?php
/**
 * Plugin Name: Sonic Spectre Video Player
 * Description: Simple pretty video player by INTAKE Digital.
 * Plugin URI:  https://github.com/wearehalcyon/sonic-spectre-video-player/
 * Author URI:  https://sonicspectre.com/
 * Author:      INTAKE DIgital
 * Version:     1.0.0
 *
 * Text Domain: idvp
 * Domain Path: /languages
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Network:     true
 */

defined( 'ABSPATH' ) or die( 'No Trespassing!' ); // Security

// Data
function idvp_plugin_data($value){
    $data = [
        'name'      => __('Sonic Spectre Video Player', 'idvp'),
        'slug'      => 'idevp-general-settings',
        'version'   => '1.0.0 (BETA Public)',
        'post_type' => 'sonic-spectre-videos',
        'devurl'    => 'https://sonicspectre.com/',
        'repourl'   => 'https://github.com/wearehalcyon/sonic-spectre-video-player/'
    ];
    return $data[$value];
}

// Define constants
if ( !defined('IDVP_ROOT') ) {
    define('IDVP_ROOT', plugin_dir_path(__FILE__));
} else {
    die( 'IDVP_ROOT constant is already defined!' );
}

if ( !defined('IDVP_URL') ) {
    define('IDVP_URL', plugin_dir_url(__FILE__));
} else {
    die( 'IDVP_URL constant is already defined!' );
}

// Including files from INC directory
require_once IDVP_ROOT . '/includes/kernel.php';
