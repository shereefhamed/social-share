<?php
class Social_Share_Shortcode{
    public function __construct() {
        add_shortcode( 'social_share',array( $this,'social_share_sortcode' ) );
    }

    public function social_share_sortcode( $atts=array(),$content='',$shortcode_tag='' ){
        $atts = array_change_key_case( $atts,CASE_LOWER );
        extract(
            shortcode_atts(
                array(
                    'shape'     =>  '',
                    'services'  =>  '',
                ),
                $atts,
                $shortcode_tag,
            )
        );
        if( !empty( $services ) ){
            $services = explode( ',',$services );
        }
        $title = empty( $content ) ?
                 Social_Share_Setting::$setting['social_share_title'] :
                 $content;
        $shape = $shape==null ?
                 Social_Share_Setting::$style['social_share_shape'] :
                 $shape;
        $services = $services==null ?
                    Social_Share_Setting::$setting['social_share_services']:
                    $services;
        return create_social_share_icons( $title,$services,$shape );
    }
}