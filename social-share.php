<?php
/**
 * Plugin Name: Social Share
 * Description: Share your content over Facebook, Twitter, Google, Linkedin, Whatsapp, Tumblr, Pinterest, Reddit, Gab, Gettr and over 110 more social sharing
 * Text Domain: social-share
 * Domain Path: /languages
 * Version: 1.0.0
 * Author: Shereef Hamed
 * Author URI: https://elafcorp.com/shereef
 * Plugin URI: https://google.com
 */
if( !defined( 'ABSPATH' ) ){
    exit;
}
define( 'SOCIAL_SHARE_PATH',plugin_dir_path( __FILE__ ) );
define( 'SOCIAL_SHARE_URI',plugin_dir_url( __FILE__ ) );
define( 'SOCIAL_SHARE_VERSION','1.0.0' );
define( 'PLUGIN_NAME',plugin_basename(__FILE__) );
define(
    'SOCIAL_SHARE_SERVICE',
    [
        'facebook'  =>  [
            'id'            =>  'facebook',
            'title'         =>  'Facebook',
            'icon'          =>  'fa-brands fa-facebook-f',
            'share_link'    =>  'https://www.facebook.com/sharer/sharer.php',
            'parameters'    =>  [
                'u' =>  get_the_permalink(),
                't' =>  get_the_title(),
                
            ]
        ],
        'x'  =>  [
            'id'            =>  'x',
            'title'         =>  'X',
            'icon'          =>  'fa-brands fa-x-twitter',
            'share_link'    =>  'http://twitter.com/share',
            'parameters'    =>  [
                'url'   =>  get_the_permalink(),
                'text'  =>  get_the_title(),
                
            ]
        ],
        'linked_in'  =>  [
            'id'            =>  'linked_in',
            'title'         =>  'LinkedIn',
            'icon'          =>  'fa-brands fa-linkedin-in',
            'share_link'    =>  'https://www.linkedin.com/sharing/share-offsite/',
            'parameters'    =>  [
                'url'   =>  get_the_permalink(),
                'title' =>  get_the_title(),
                
            ]
        ],
        'pinterest' =>  [
            'id'            =>   'pinterest',
            'title'         =>   'Pinterest',
            'icon'          =>   'fa-brands fa-pinterest-p',
            'share_link'    =>   'https://pinterest.com/pin/create/link/',
        ],
        'whatsapp'  =>  [
            'id'            =>  'whatsapp',
            'title'         =>  'WhatsApp',
            'icon'          =>  'fa-brands fa-whatsapp',
            'share_link'    =>  'https://wa.me/',
        ],
    ]
);

require_once( SOCIAL_SHARE_PATH . 'includes/class-social-share.php' );
require_once( SOCIAL_SHARE_PATH . 'includes/class-social-share-setting.php' );
require_once( SOCIAL_SHARE_PATH . 'includes/class-social-share-shortcode.php' );
require( SOCIAL_SHARE_PATH . 'functions/functions.php' );

load_plugin_textdomain(
    'social-share',
    false,
    dirname( plugin_basename( __FILE__ ) ) . '/languages'
);

register_activation_hook( __FILE__,array( 'Social_share','social_share_activatin_hook' ) );
register_deactivation_hook( __FILE__,array( 'Social_share','social_share_dectivation_hook' ) );
register_uninstall_hook( __FILE__,array( 'Social_share','social_share_uninstall_hook' ) );

$social_share = new Social_Share();
