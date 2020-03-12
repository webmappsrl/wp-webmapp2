<?php

function WebMapp_V3FirstWizardCallback(WP_REST_Request $request)
{

    $noauth = false;//set to true to disable user check

    $param = $request->get_params();

    $wizard_id = isset($param["wizard_id"]) ? $param["wizard_id"] : false;
    if (!$wizard_id)
        return new WP_REST_Response(['message' => 'Please provide a wizard id.'], 400);


    $update_id = isset($param["update_id"]) ? $param["update_id"] : false;
    $delete_id = isset($param["delete_id"]) ? $param["delete_id"] : false;
    

    if ( $update_id && $request->get_method() == 'GET' )
    {
        $geoJson = new WebMapp_PostToFeature( $update_id );
        return new WP_REST_Response(
            $geoJson->get_body()
            , 200);
    }

    if ( $update_id )
    {
        $param["post_type"] = get_post_type($update_id);
    }

    $post_type = isset($param["post_type"]) ? $param["post_type"] : false;
    if ( ! $post_type || ! post_type_exists( $post_type ) ) 
        return new WP_REST_Response(['message' => 'You must specify a valid post type in the url.'], 401);

    if (!$noauth) :
        if ($update_id !== FALSE) {//edit
            if (!current_user_can('edit_others_posts'))
                return new WP_REST_Response(['message' => 'You cant edit post type provided.'], 401);
        } elseif ($delete_id !== FALSE) {//delete
            if (!current_user_can('delete_others_posts'))
                return new WP_REST_Response(['message' => 'You cant delete post type provided.'], 401);
        }
        else {//create
            if (!current_user_can('edit_others_posts'))
                return new WP_REST_Response(
                    [
                        'message' => 'You cant create post type provided.'
                    ]
                    , 401);
        }
    endif; //if ( ! $noauth ) :


    /** DELETE OPERATIONS */

    if ($delete_id) {
        $check = wp_delete_post($delete_id);
        if ($check instanceof WP_Post) {
            return new WP_REST_Response(['message' => 'Success, post moved to the trash.'], 200);
        } else {
            return new WP_REST_Response(['message' => 'Ops, something goes wrong.'], 500);
        }
    }

    /** EDIT OPERATIONS / CREATE OPERATIONS **/
    $body = $request->get_body();
    $bodyPhp = json_decode( $body , TRUE );

    if ( ! isset($bodyPhp['properties'] ) )
        return new WP_REST_Response(['message' => 'Missings properties of FeatureCollection.'], 400);

    $featureCollectionProperties = $bodyPhp['properties'];

    $handler = new WebMapp_FeaturePropertiesHandler( $featureCollectionProperties , $post_type );
    if ( $update_id )
        $handler->set_postId( $update_id );

    $check = $handler->createPost();


    if ( $check instanceof WP_Error )
    {
        return new WP_REST_Response(['message' => $check->get_error_message() ], 500);
    }
    else if ( $check == 0 )
    {
        return new WP_REST_Response(['message' => "Impossible create post type provided." ], 500);
    }

    
    return new WP_REST_Response(
        [
            'message' => "$post_type created", 
            'data' => [ 
                'id' => $check,
                'author' => get_current_user_id(),
                'postArr' => $handler->get_postArr(),
                'mapping' => $handler->get_dataModelMapping()
                ]
            ]
        , 200);
}
$namespace = 'webmapp/v3';





$createRoute = '/wizard/(?P<wizard_id>.+)/(?P<post_type>.+)';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $createRoute, $args);

$editRoute = '/wizard/(?P<wizard_id>.+)/(?P<update_id>\d+)';
$args = array(
    'methods' => 'PATCH',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $editRoute, $args);

$createRoute = '/wizard/(?P<wizard_id>.+)/(?P<update_id>\d+)';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $createRoute, $args);

$editRoute = '/wizard/(?P<wizard_id>.+)/(?P<delete_id>\d+)';
$args = array(
    'methods' => 'DELETE',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $editRoute, $args);
