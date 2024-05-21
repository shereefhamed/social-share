<?php
class Social_Share{

    public function __construct() {
        add_filter( 'plugin_action_links_' . PLUGIN_NAME, array( $this,'social_share_action_links' ) );
        add_action( 'admin_menu',array( $this,'social_share_menu' ) );
        $social_share_setting = new Social_Share_setting();
        $social_share_short_code = new Social_Share_Shortcode();
        add_action( 'wp_enqueue_scripts',array( $this,'register_scripts' ),999 );
        add_action( 'wp_head',array( $this,'add_social_share_meta' ) );
        add_filter( 'the_content',array( $this,'add_social_media_share_icons' ) );
    }

    public static function social_share_activatin_hook(){

    }

    public static function social_share_dectivation_hook(){

    }

    public static function social_share_uninstall_hook(){

    }

    public function social_share_action_links( $actions  ){
        $actions[] = '<a href="'. esc_url( get_admin_url(null, '?page=social-share-settings') ) .'">Settings</a>';
        return $actions;
    }

    public function social_share_menu(){
        add_menu_page(
            esc_html__( 'Social Share','social-share' ),
            esc_html__( 'Social Share','social-share' ),
            'manage_options',
            'social-share-settings',
            array( $this,'social_share_menu_cb_function' ),
            'dashicons-share-alt2',
        );
    }

    public function register_scripts(){
        wp_register_style(
            'fontawesome-front',
            SOCIAL_SHARE_URI . 'assets/css/all.css',
            array(),
            SOCIAL_SHARE_VERSION,
            'all',
        );
        wp_register_style(
            'social-share-style',
            SOCIAL_SHARE_URI . 'assets/css/style.css',
            array(),
            SOCIAL_SHARE_VERSION,
            'all',
        );
    }

    public function add_social_share_meta(){
        if( isset( Social_Share_Setting::$setting['social_share_services'] ) ){
            foreach( SOCIAL_SHARE_SERVICE as $service){
                if( in_array( $service['id'], Social_Share_Setting::$setting['social_share_services']) ){
                    if( $service['id']=='facebook' ){
                        ?>
                        <meta property="og:url"           content="<?php the_permalink() ?>" />
                        <meta property="og:type"          content="website" />
                        <meta property="og:title"         content="<?php the_title() ?>" />
                        <meta property="og:description"   content="Your description" />
                        <meta property="og:image"         content="<?php echo has_post_thumbnail()?  get_the_post_thumbnail_url(): esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ); ?>" />
                        <?php
                    }

                    if( $service['id']=='x' ){
                        ?>
                        <meta name="twitter:card" content="summary_large_image">
                        <meta name="twitter:site" content="@idream">
                        <meta name="twitter:creator" content="@idream">
                        <meta name="twitter:title" content="<?php the_title() ?>">
                        <meta name="twitter:description" content="<?php the_title() ?>">
                        <meta name="twitter:image" content="<?php echo has_post_thumbnail()?  get_the_post_thumbnail_url(): esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ); ?>">
                        <?php
                    }
                }
            }
        }
    }

    public function social_share_menu_cb_function(){
        if( !current_user_can( 'manage_options' ) ){
            return;
        }
        if( isset( $_GET['settings-updated'] ) ){
            add_settings_error( 
                'social_share_style',
                'social_share_message',
                'Setting updated',
                'success',
            );
        }
        settings_errors( 'social_share_style' );
        require_once( SOCIAL_SHARE_PATH . 'templates/setting-page.php' );
    }

    public function add_social_media_share_icons($content){
        $post_types = isset( Social_Share_Setting::$setting['social_share_post_types'] )?
                      Social_Share_Setting::$setting['social_share_post_types'] :
                      [];
        wp_enqueue_style( 'fontawesome-front' );
        wp_enqueue_style( 'social-share-style' );
        if( !is_front_page() && is_singular() && in_array( get_post_type(),$post_types )){
            $title = isset( Social_Share_Setting::$setting['social_share_title'] )
                ? esc_html__( Social_Share_Setting::$setting['social_share_title'], 'social-share')
                : esc_html__('Share', 'social-sharre'); 
            $services = isset( Social_Share_Setting::$setting['social_share_services'] )
                        ? Social_Share_Setting::$setting['social_share_services'] 
                        :[];
            $shape = isset( Social_Share_Setting::$style['social_share_shape'] ) ? 
                     Social_Share_Setting::$style['social_share_shape'] : 
                     'rounded';
            return create_social_share_icons( $title,$services,$shape ) . $content;
        }
        return $content;
    }
}