<?php

function WebMapp_V3FirstWizardCallback(WP_REST_Request $request)
{

    $noauth = true;//set to true to disable user check

    $param = $request->get_params();

    $wizard_id = isset($param["wizard_id"]) ? $param["wizard_id"] : false;
    if (!$wizard_id)
        return new WP_REST_Response(['message' => 'Please provide a wizard id.'], 400);


    $update_id = isset($param["update_id"]) ? $param["update_id"] : false;
    $delete_id = isset($param["delete_id"]) ? $param["delete_id"] : false;


    if (!$noauth) :
        if ($update_id !== FALSE) {//edit
            if (!current_user_can('edit_others_posts'))
                return new WP_REST_Response(['message' => 'You cant edit routes.'], 401);
        } elseif ($delete_id !== FALSE) {//delete
            if (!current_user_can('delete_others_posts'))
                return new WP_REST_Response(['message' => 'You cant delete routes.'], 401);
        }
        else {//create
            if (!current_user_can('edit_others_posts'))
                return new WP_REST_Response(
                    [
                        'message' => 'You cant create routes.'
                    ]
                    , 401);
        }
    endif; //if ( ! $noauth ) :


    /** DELETE OPERATIONS */

    if ($delete_id) {
        $check = wp_delete_post($delete_id);
        if ($check instanceof WP_Post) {
            return new WP_REST_Response(['message' => 'Success, route moved to the trash.'], 200);
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

    $handler = new WebMapp_FeaturePropertiesHandler( $featureCollectionProperties );
    if ( $update_id )
        $handler->set_postId( $update_id );

    $check = $handler->createPost();


    if ( $check instanceof WP_Error )
    {
        return new WP_REST_Response(['message' => $check->get_error_message() ], 500);
    }
    else if ( $check == 0 )
    {
        return new WP_REST_Response(['message' => "Impossible create routes." ], 500);
    }

    
    return new WP_REST_Response(
        [
            'message' => "Route created", 
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


$createRoute = '/wizard/(?P<wizard_id>.+)/route';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $createRoute, $args);

$editRoute = '/wizard/(?P<wizard_id>.+)/route/(?P<update_id>\d+)';
$args = array(
    'methods' => 'PATCH',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $editRoute, $args);


$editRoute = '/wizard/(?P<wizard_id>.+)/route/(?P<delete_id>\d+)';
$args = array(
    'methods' => 'DELETE',
    'callback' => 'WebMapp_V3FirstWizardCallback'
);
new WebMapp_RegisterRestRoute($namespace, $editRoute, $args);
