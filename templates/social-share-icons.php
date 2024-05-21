<?php
$title = empty( $content ) ?
         Social_Share_Setting::$setting['social_share_title'] :
         $content;
$shape = $shape==null ?
         Social_Share_Setting::$style['social_share_shape'] :
         $shape;
$services = $services==null?
            Social_Share_Setting::$setting['social_share_services']:
            $services;

?>
<h1><?php esc_html_e( $title,'social-share' ) ?></h1>
<div class="social-media-share-icons">
    <?php foreach( SOCIAL_SHARE_SERVICE as $service ): ?>
        <?php if( in_array( $service['id'],$services ) ): ?>
            <?php
            if( $service['id']=='facebook' ){
                $link = add_query_arg( 
                    array(
                    'u' => get_the_permalink(),
                    't' => get_the_title(),
                    ), 
                    $service['share_link'] 
                );
            }else if( $service['id']=='x' ){
                $link = add_query_arg( 
                    array(
                    'url' => get_the_permalink(),
                    'text' => get_the_title(),
                    ), 
                    $service['share_link'] 
                );
            }else if( $service['id']=='linkedin' ){
                $link = add_query_arg( 
                    array(
                    'url' => get_the_permalink(),
                    'title' => get_the_title(),
                    ), 
                    $service['share_link'] 
                );
            }else if( $service['id']=='pinterest' ){
                $link = add_query_arg( 
                    array(
                    'url' => get_the_permalink(),
                    'media' => has_post_thumbnail()?  get_the_post_thumbnail_url(): esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ),
                    'description' => get_the_title(),
                    ), 
                    $service['share_link'] 
                );
            }else if( $service['id']=='whatsapp' ){
                $link = add_query_arg( 
                    array(
                    'text' => get_the_permalink(),
                    ), 
                    $service['share_link'] 
                );
            }
            ?>
            <a href="<?php echo $link ?>" class="social-media-share-icon" target="_blank">
                <i class="<?php echo $shape;?> <?php echo $service['icon'] ?>"></i>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>