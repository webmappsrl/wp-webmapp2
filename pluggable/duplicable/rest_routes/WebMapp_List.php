<?php

/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_V1List( WP_REST_Request $request ) {
  $type = $request->get_param("type");

  $resp = array('123' => '2019-03-29T14:32:35','456'=>'2019-03-29T14:32:35','type'=>$type);
  return new WP_REST_Response($resp,200);

}
$namespace = 'webmapp/v1';
$route = '/list';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1List'
);
$WebMapp_V1List = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


