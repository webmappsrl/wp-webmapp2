<?php


class WebMapp_TemplateSingle
{
    public $geoJson_php;
    public $geoJson_properties = array();
    public $post_type;

    function __construct( $geoJson_php = '' )
    {
        $this->geoJson_php = $geoJson_php;

        if ( isset( $this->geoJson_php->properties ) )
            $this->geoJson_properties = WebMapp_Utils::object_to_array( $this->geoJson_php->properties );

    }

    function getShortInfo()
    {
        $r = false;


        $this->post_type = get_post_type();

        $difficulty_key = $this->post_type == 'route' ? 'n7webmapp_route_difficulty' : 'cai_scale';


        $fields_key = array(
            'difficulty' => $difficulty_key,//CAI SCALE or n7webmapp_route_difficulty
            'rating' => 'wm_poi_stars',//rating
            'ascent' => 'ascent',//ascent
            'descent' => 'descent',//discent
            'distance' => 'distance',//distance
            'duration' => 'duration:forward'//duration:forward
        );
        $fields = $this->getFields( $fields_key );
        if ( $fields )
            $r = $fields;

        return $r;
    }

    function theShortInfo()
    {

        global $WebMapp_IconsConf;
        $shortInfo = $this->getShortInfo();

        $html = '<p class="webmapp-theshortinfo">';


        if ( $shortInfo )
        {


            foreach ( $shortInfo as $key => $info )
            {


                $html_s = "<span class='webmapp-theshortinfo-detail webmapp-theshortinfo-detail-$key'>";


                if ( $key == 'difficulty'
                    && get_post_type() == 'route'
                    && isset( $WebMapp_IconsConf[ 'difficulty' ] )
                    && isset( $WebMapp_IconsConf[ 'difficulty' ]['full'] )
                    && isset( $WebMapp_IconsConf[ 'difficulty' ]['empty'] )
                )
                {

                    $info_numeric = ! is_numeric( $info ) || $info > 5 ? 5 : ( int ) $info ;
                    $html_s .= __( 'Difficulty' , WebMapp_TEXTDOMAIN );

                    for ( $i = 0 ; $i < 5 ; $i++ )
                    {
                        if ( $i < $info_numeric )
                            $html_s .= "<i class='" . $WebMapp_IconsConf[ 'difficulty' ]['full'] . "'></i>";
                        else
                            $html_s .= "<i class='" . $WebMapp_IconsConf[ 'difficulty' ]['empty'] . "'></i>";

                    }




                }
                elseif ( $key == 'rating'
                    && isset( $WebMapp_IconsConf[ 'rating' ] )
                )
                {
                    $info_numeric = ! is_numeric( $info ) || $info > 5 ? 5 : ( int ) $info ;
                    $html_s .= __( 'Rating' , WebMapp_TEXTDOMAIN );

                    for ( $i = 0 ; $i < $info_numeric ; $i++ )
                    {
                        $html_s .= "<i class='" . $WebMapp_IconsConf[ 'rating' ] . "'></i>";
                    }


                }
                else
                {
                    $icon = isset( $WebMapp_IconsConf[$key] ) ? "<i class='$WebMapp_IconsConf[$key]'></i>" : '';
                    $html_s .= "$icon $info";
                }



                $html_s .= "</span>";

                $html_s = apply_filters('WebMapp_TemplateSingle_theShortInfo', $html_s, $key , $info );

                $html .= $html_s;

            }
        }
        echo $html . '</p>';
    }

    function getInfo()
    {
        //todo controllare i fields a seconda del post type
        $fields_key = array(
            'phone' => 'contact:phone',//phone
            'email' => 'contact:email',//email
            'links' => 'n7webmap_rpt_related_url'//links
        );

        $t = $this->getFields( $fields_key );

        if ( isset( $t['links'] ) && $t['links'] )
        {
            $temp =  array_map( function( $i ){
                if ( is_array($i ) && ! empty( $i ) )
                    return current( $i);
                else
                    return false;
            }, $t['links'] ) ;
            $temp = array_filter( $temp );

            if ( ! empty( $temp ) )
                $t['links'] = $temp;
            else
                unset( $t['links'] );
        }


        $address = $this->getAddress();

        if ( $address )
            $t['address'] = $address;


        return $t;
    }

    function theInfo()
    {
        global $WebMapp_IconsConf;
        $t = $this->getInfo();
        //rendering

        $post_title = get_the_title();

        if ( is_array( $t ) && ! empty( $t ) )
        {

            $html = '<div class="webmapp-theInfo-template-single"><table>';
            foreach ( $t as $key => $data )
            {
                if ( ! empty( $data ) ) :
                ob_start();
                ?>
                <tr>
                   <?php
                   if ( isset( $WebMapp_IconsConf[$key] ) )
                       echo "<th><i class='$WebMapp_IconsConf[$key]'></i></th>";
                   ?>
                    <td>
                        <?php
                        if ( is_array($data ) )
                        {
                            echo "<ul>";
                            foreach ( $data as $d )
                            {
                                echo "<li>";

                                if ( $key == 'links' )
                                {
                                    $link_title = $post_title . ' Link';
                                    echo "<a href='$d' target='_blank' title='$link_title'>$d</a>";
                                }
                                else
                                    echo $d;

                                echo "</li>";

                            }
                            echo "</ul>";

                        }
                        else
                            echo $data;
                        ?>
                    </td>
                </tr>



                <?php
                $html .= ob_get_clean();
                endif;//if ( ! empty( $data ) ) :
            }

            $html .= '</table></div>';

            echo $html;

        }//if ( is_array( $t ) && ! empty( $t ) )

    }


    function getAddress()
    {
        $r = false;

        $fields_key = array(
            'street' => 'addr:street',//street
            'house_number' => 'addr:housenumber',//house number
            'postcode' => 'addr:postcode',//postcode
            'city' => 'addr:city'//city
        );

        $address_fields = $this->getFields( $fields_key );

        if ( $address_fields && is_array($address_fields ) && ! empty( $address_fields ) )
            $r = implode(', ' ,  $address_fields );
        elseif ( ! empty( $address_fields ) )
            $r = $address_fields;

        return $r;
    }

    function getRelatedObjects()
    {
        $r = array();
        if ( $this->geoJson_php )
        {
            $temp = $this->geoJson_php->properties->related;

            if( isset($temp->poi) || isset($temp->track) || isset($temp->route) )
            {
                $r = WebMapp_Utils::object_to_array( $temp );
                $r = array_filter( $r );

            }

        }

        return $r;
    }

    function getFields( $fields , $post_id = '' )
    {
        $t = array();

        if ( !$post_id )
            $post_id = get_the_ID();

        foreach( $fields as $key => $field )
        {
            if ( ! empty( $this->geoJson_properties )
                && isset( $this->geoJson_properties[$field] )
                && ! empty( $this->geoJson_properties[$field] )
            )
                $t[$key] = $this->geoJson_properties[$field];//get field from geoJson
            else
            {
                $temp = get_field($field ,$post_id);//get field from wp database
                if ( $temp && ! empty( $temp) )
                    $t[$key] = $temp;
            }



        }



        return $t;

    }

    function getSimilarObjects()
    {
        $r = '';
        $post_type = get_post_type();
        $post_id = get_the_ID();

        $posts = get_posts(
            array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'fields' => 'ids',
                'post__not_in' => array( $post_id ),
                'posts_per_page' => 3
            )
        );

        if ( $posts && is_array( $posts ) && ! empty( $posts ) )
        {
            $posts_string = implode( ',',$posts);
            $r = do_shortcode("[webmapp_anypost posts_per_page='3' post_count='3' rows='1' post_ids='" . $posts_string . "']");
        }


        return $r;

    }

}