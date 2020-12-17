<?php

/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_V1WPMLList( WP_REST_Request $request ) {
  $ls = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
  $active = '';
  $others = array();
  foreach ($ls as $code => $info) {
    if($info['active']==1) {
      $active=$code;
    }
    else {
      $others[]=$code;
    }
  }
  $resp['active']=$active;
  $resp['others']=$others;
  return new WP_REST_Response($resp,200);

}
$namespace = 'webmapp/v1';
$route = '/wpml/list';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1WPMLList',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
          return true;
  }
);
$WebMapp_V1WPMLList = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


