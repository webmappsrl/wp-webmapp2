<?php

/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_V1List( WP_REST_Request $request ) {
 
  $resp=array();
  $type = $request->get_param("type");
  $args = array('post_type'=>$type,'posts_per_page' => -1,'post_status'=>'publish');
  $the_query = new WP_Query( $args );
  if(count($the_query->posts)>0) {
    foreach($the_query->posts as $post) {
      $resp[$post->ID]=$post->post_modified; 
    }
  }
  return new WP_REST_Response($resp,200);

}

$namespace = 'webmapp/v1';
$route = '/list';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1List'
);
$WebMapp_V1List = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


