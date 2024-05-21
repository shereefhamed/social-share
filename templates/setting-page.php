<div class="wrap">
    <h1><?php esc_html_e( get_admin_page_title(),'social-share' ) ?></h1>
    <?php $active_tab = isset( $_GET['tab'] ) ? $_GET['tab']: 'style' ?>
    <div class="nav-tab-wrapper">
        <a href="?page=social-share-settings&tab=style" class="nav-tab <?php echo $active_tab=='style'? 'nav-tab-active': '' ?>"><?php esc_html_e( 'Style','social-share' ) ?></a>
        <a href="?page=social-share-settings&tab=setting" class="nav-tab <?php echo $active_tab=='setting'? 'nav-tab-active': '' ?>"><?php esc_html_e( 'Setting','social-share' ) ?></a>
        <a href="?page=social-share-settings&tab=shortcode" class="nav-tab <?php echo $active_tab=='shortcode'? 'nav-tab-active': '' ?>"><?php esc_html_e( 'Shortcode','social-share' ) ?></a>
    </div>
    <form action="options.php" method="post">
        <?php 
        if( $active_tab=='style' ): 
            settings_fields( 'social_share_group' );
            do_settings_sections( 'social-share-style-page' );
        elseif( $active_tab=='setting' ): 
            settings_fields( 'social_share_setting' );
            do_settings_sections( 'social-share-setting-page' );
        elseif( $active_tab=='shortcode' ): 
            settings_fields( 'social_share_group' );
            do_settings_sections( 'social-shateshortcode-page' );
        endif;
        submit_button( esc_html__( 'Save Settings','social-share' ) ) 
        ?>
    </form>
</div>