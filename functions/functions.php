<?php
function create_social_share_icons( $title='',$services=[],$shape='rounded' ){
    $output = '';
    $output .= '<h1>';
    $output .= esc_html__( $title,'social-share' );
    $output .= '</h1>';
    $output .= '<div class="social-media-share-icons">';
    if( !empty( $services ) ){
        foreach( SOCIAL_SHARE_SERVICE as $service){
            if( in_array( $service['id'], $services ) ){
                $link = esc_url( create_social_icon_share_link( $service['id'] ) );
                $output .= '<a href="'. $link .'" class="social-media-share-icon '. esc_attr( $service['id'] ) .'" target="_blank">';
                $output .= '<i class="'. esc_attr( $shape ) . ' '.esc_attr( $service['icon'] ) .'"></i>';
                $output .= '</a>';
            }
        }
    }else{
        $output .= '<p>' . esc_html__( 'Please choose social media services','social-share' ) .'</p>';
    }
    $output .= '</div>';
    return $output;
}

function create_social_icon_share_link($service_id){
    $args = array();
    switch ($service_id){
        case 'facebook':
            $args = array(
                'u' => get_the_permalink(),
                't' => get_the_title(),
            );        
            break;
        case 'x':
            $args = array(
                'url' => get_the_permalink(),
                'text' => get_the_title(),
            );
            break;
        case 'linked_in':
            $args = array(
                'url' => get_the_permalink(),
                'title' => get_the_title(),
            );
            break;
        case 'pinterest':
            $args = array(
                'url' => get_the_permalink(),
                'media' => has_post_thumbnail()?  get_the_post_thumbnail_url(): esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ),
                'description' => get_the_title(),
            );
            break;
        case 'whatsapp':
            $args = array(
                'text' => get_the_permalink(),
            );
            break;
    }
    return empty( $args )? 
           '#' : 
           add_query_arg( 
                $args,
                SOCIAL_SHARE_SERVICE[$service_id]['share_link'] 
           );
}