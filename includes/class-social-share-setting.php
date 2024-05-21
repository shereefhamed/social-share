<?php
class Social_Share_Setting{
    static $style;
    static $setting;

    public function __construct() {
        self::$style = get_option( 'social_share_style' );
        self::$setting = get_option( 'social_share_setting' );
        add_action( 'admin_enqueue_scripts',array( $this,'admin_enqueue_scripts' ) );
        add_action( 'admin_init',array( $this,'register_social_share_setting' ) );
        add_action( 'admin_init',array( $this,'add_section_fields' ) );
    }

    public function register_social_share_setting(){
        
        register_setting(
            'social_share_group',
            'social_share_style',
            array( $this,'validate_inputs' ),

        );
        register_setting(
            'social_share_setting',
            'social_share_setting',
            array( $this,'validate_inputs' ),
        );
    }

    public function admin_enqueue_scripts(){
        wp_enqueue_style(
            'admin-fontawesome',
            SOCIAL_SHARE_URI . 'assets/css/all.css',
        );
    }


    public function add_section_fields(){
        add_settings_section(
            'social-share-style-setting',
            esc_html__( 'Style','social-share' ),
            null,
            'social-share-style-page',
        );

        add_settings_section(
            'social-share-setting-setting',
            esc_html__( 'Settings','social-share' ),
            null,
            'social-share-setting-page',
        );

        add_settings_section(
            'social-share-setting-shortcode',
            esc_html__( 'Shortcode','social-share' ),
            null,
            'social-shateshortcode-page',
        );

        add_settings_field(
            'social_share_title',
            esc_html__( 'Title','social-share' ),
            array( $this,'social_shate_title_render' ),
            'social-share-setting-page',
            'social-share-setting-setting',
        );

        add_settings_field(
            'social_share_shape',
            esc_html__( 'Shape','social-share' ),
            array( $this,'social_share_shape_render' ),
            'social-share-style-page',
            'social-share-style-setting',
            array(
                'shapes'    =>  array(
                    'rounded',
                    'squared'
                )
            )
        );
        add_settings_field(
            'social_share_services', 
            esc_html__( 'Select Sharing Services','social-share' ), 
            array( $this,'social_share_services_render' ),
            'social-share-setting-page',
            'social-share-setting-setting',
            array(
                'services'  =>  array(
                    'facebook',
                    'linkedIn',
                    'x',
                )
            ),
        );

        add_settings_field(
            'social_share_post_types',
            esc_html__( 'Select Post Type','social-share' ),
            array( $this,'social_share_post_type_render' ),
            'social-share-setting-page',
            'social-share-setting-setting',
        );

        add_settings_field(
            'social-share-shortcode-field',
            esc_html__( 'Shortcode','social-share' ),
            array( $this,'social_share_setting_shortcode_field_cb_function' ),
            'social-shateshortcode-page',
            'social-share-setting-shortcode'
        );
        add_settings_field(
            'social-share-shortcode-advanced',
            esc_html__( 'Advanced','social-share' ),
            array( $this,'social_share_setting_shortcode_advanced_cb_function' ),
            'social-shateshortcode-page',
            'social-share-setting-shortcode'
        );
    }

    public function social_share_shape_render( $args ){
        ?>
        <select name="social_share_style[social_share_shape]" id="social_share_shape">
            <?php foreach( $args['shapes'] as $shape ): ?>
                <option 
                    value="<?php echo  esc_html( $shape ) ?>"
                    <?php isset( self::$style['social_share_shape'] )? selected(self::$style['social_share_shape'], $shape, true):'' ?>
                >
                    <?php esc_html_e( ucfirst( $shape ),'social-share' ) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function social_shate_title_render(){
        ?>
        <input 
            type="text"
            value="<?php echo  isset( self::$setting['social_share_title'] )? esc_html( self::$setting['social_share_title'],'social-share' ) : esc_html( 'Share','social-share' ) ?>"
            id="social_share_title"
            name="social_share_setting[social_share_title]"
        >
        <?php
    }

    public function social_share_services_render( $args ){
        foreach( SOCIAL_SHARE_SERVICE  as $service){
        ?>
        <div>
            <input 
                type="checkbox" 
                name="social_share_setting[social_share_services][]" 
                id="social_share_services"
                value="<?php echo $service['id'] ?>"
                <?php 
                if( isset( self::$setting['social_share_services' ] ) ){
                    echo in_array( $service['id'], self::$setting['social_share_services' ])? 'checked':'';
                }
                ?>
            >
            <label for="social_share_services"><span><i class="<?php echo $service['icon'] ?>"></i></span> <?php echo $service['title'] ?></label>
        </div>
        <?php
        }
    }

    public function social_share_post_type_render(){
        $args = array(
            'public'   => true,
        );
        $post_types = get_post_types( $args );
        foreach( $post_types as $post_type ){
            ?>
            <div>
            <input 
                type="checkbox" 
                name="social_share_setting[social_share_post_types][]" 
                id="social_share_post_types"
                value="<?php echo $post_type ?>"
                <?php 
                if( isset( self::$setting['social_share_post_types' ] ) ){
                    echo in_array( $post_type, self::$setting['social_share_post_types' ])? 'checked':'';
                }
                ?>
            >
            <label for="social_share_post_types"> <?php echo $post_type ?></label>
        </div>
        <?php
        }
    }

    public function social_share_setting_shortcode_field_cb_function(){
        ?>
        <p><?php esc_html_e( 'Copy This Shortcode [social_share] To Any Page Or Post','social-share' ) ?></p>
        <?php
    }

    public function social_share_setting_shortcode_advanced_cb_function(){
        ?>
        <p>[social_share shape="rounded" servrices="facebook,twitter,whastapp,linked_id,pinterest"]This is custom title[/social_share]</p>
        <?php
    }

    public  function  validate_inputs( $inputs ){
        $new_inputs = [];
        foreach( $inputs as $key=> $value ){
            if( $key=='social_share_post_types' ){
                foreach( $inputs['social_share_post_types'] as $post_type ){
                    $new_inputs['social_share_post_types'][]= sanitize_text_field( $post_type );
                }
            }else if( $key=='social_share_services' ){
                foreach( $inputs['social_share_services']  as $service){
                    $new_inputs['social_share_services'][]=sanitize_text_field( $service );
                }
            }else{
                $new_inputs[$key] = sanitize_text_field( $value );
            }
        }
        return $new_inputs;
    }
}