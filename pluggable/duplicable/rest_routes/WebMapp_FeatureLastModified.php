<?php

/**
 * Check the last modification of a feature
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_FeatureLastModified( WP_REST_Request $request ) {
 
    $resp=array();
    $feature_id = $request->get_param("id");
    $feature = get_post($feature_id);
    $feature_type = $feature->post_type;
    

    // Get the list of availible languages
    $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );

    // Get the default language 
    $default_lang = apply_filters('wpml_default_language', NULL );

    $enabled_languages = array();

    if ( !empty( $languages ) ) {
        foreach( $languages as $l ) {
            if ( $l['language_code'] !== $default_lang)
            $enabled_languages[] = $l['language_code'];
        }
    }
    $feature_modified = new DateTime($feature->post_modified);
    if(!empty( $enabled_languages )) {
        foreach($enabled_languages as $l) {
            $post_lang_id = apply_filters( 'wpml_object_id', $feature_id, $feature_type, FALSE, $l );
            $post = get_post($post_lang_id);
            $post_last_modified = new DateTime($post->post_modified);
            if ($feature_modified > $post_last_modified){
                $last_modified = $feature_modified;
            }else {
                $last_modified = $post_last_modified;
            }
        }
        $last_modified = $last_modified->format('Y-m-d H:i:s');
        $resp['last_modified']=$last_modified;
    } else {
        $resp['last_modified']=$feature->post_modified;
    }
    
    return new WP_REST_Response($resp,200);

}

$namespace = 'webmapp/v1';
$route = '/feature/last_modified';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_FeatureLastModified'
);
$WebMapp_FeatureLastModified = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


