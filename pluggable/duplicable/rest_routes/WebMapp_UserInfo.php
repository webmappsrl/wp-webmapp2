<?php

/**
 * Gets user ID and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_UserInfo( WP_REST_Request $request ) {
 
  $resp=array();
  $author_id = $request->get_param("id");
  $fname = ucfirst(get_the_author_meta('first_name',$author_id));
  $lname = ucfirst(get_the_author_meta('last_name',$author_id));
  $user_full_name = trim( "$fname $lname");
  if($user_full_name) {
      $resp[$author_id] = $user_full_name; 
  } else {
      $resp['ERROR'] = 'User ID ' . $author_id . ' does not exist.';
  }
  return new WP_REST_Response($resp,200);

}

$namespace = 'webmapp/v1';
$route = '/userinfo';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_UserInfo',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
          return true;
  }
);
$WebMapp_UserInfo = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


