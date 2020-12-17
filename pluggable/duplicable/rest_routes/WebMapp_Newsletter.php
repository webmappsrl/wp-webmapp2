<?php

/**
 * Subscribe the user to the newsletter
 *
 * @param WP_REST_Request $request
 */
function WebMapp_V2Newsletter(WP_REST_Request $request)
{
    $param = $request->get_params();

    $user_id = get_current_user_id();
    if (!isset($param["newsletter"])) {
        return new WP_REST_Response(['message' => "Missing parameter 'newsletter'"], 400);
    }
    $newsletter = !!$param["newsletter"];
    update_user_meta($user_id, 'newsletter', $newsletter);

    echo json_encode(array("newsletter" => $newsletter));
}

$namespace = 'webmapp/v2';
$createRoute = '/newsletter';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V2Newsletter',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
            return true;
    }
);
new WebMapp_RegisterRestRoute($namespace, $createRoute, $args);
