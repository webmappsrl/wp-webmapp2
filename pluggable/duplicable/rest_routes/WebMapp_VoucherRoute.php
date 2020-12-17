<?php

/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * wm_api_voucher()
 */
function WebMapp_V1VoucherRoute( WP_REST_Request $request ) {
  $route_id = $request->get_param("route_id");
  $user_id = $request->get_param("user_id");
  $code = $request->get_param("code");
  $data = array('route_id'=>$route_id,'user_id'=>$user_id,'code'=>$code);

  // Preparo $resp
  $resp['data']=$data;
  $resp['error'] = '';
  $resp['message'] = '';

  $user = get_userdata($user_id);

  // Verifica esistenza user_id -> 401 No user
  if($user===false) {
    $resp['error'] = 'No user';
    return new WP_REST_Response($resp,401);
  }

  // Verifica esistenza route -> 401 No user
  $route = get_post($route_id,ARRAY_A);
  if($route===null || $route['post_type']!='route') {
    $resp['error'] = 'No route';
    return new WP_REST_Response($resp,401);
  }
  //Verifica esistenza voucher -> 401 No voucher (ricontrolla l'esattezza del codice)
  // code 18-0004-01 -> title 18-0040
  $base_code = preg_replace('/\-\d*$/', '', $code);
  $qv = new WP_Query(array('post_type'=>'voucher','title'=>$base_code));
  $count = $qv->found_posts;

  if ($count==0) {
    $resp['error'] = 'No voucher';
    return new WP_REST_Response($resp,401);  	
  }
  if ($count>1) {
  	$resp['error'] = 'Multiple Voucher';
    return new WP_REST_Response($resp,401);
  }
  if ( $qv->have_posts() ) {
	while ( $qv->have_posts() ) {
		$qv->the_post();
		$voucher_id = get_the_ID();
	}
	wp_reset_postdata();
  }
  $v_route_id = get_field('route',$voucher_id);
  $v_expire_date = date('Y-m-d',strtotime(str_replace('/','-',get_field('expire_date',$voucher_id))));
  $v_total_number = get_field('total_number',$voucher_id);
  $v_used_codes = get_field('used_codes',$voucher_id);

  $today = date('Y-m-d');
  //$resp['voucher']['id']=$voucher_id;
  //$resp['voucher']['route_id']=$v_route_id;
  //$resp['voucher']['expire_date']=$v_expire_date;
  //$resp['voucher']['total_number']=$v_total_number;
  //$resp['voucher']['used_codes']=$v_used_codes;
  //$resp['today']=$today;


  //Controlla scadenza voucher -> 401 Voucher expired
  if($today>$v_expire_date) {
  	$resp['error'] = 'Voucher Expired';
    return new WP_REST_Response($resp,401);  	
  }

  //Controlla che l'itinerario associato sia quello corretto -> 401 Wrong Route
  if($route_id  != $v_route_id) {
  	$resp['error'] = 'Wrong Route';
    return new WP_REST_Response($resp,401);  	  	
  }

  //Controlla validità voucher (il secondo numero deve essere minore del numero totale) -> 
  // 401 No voucher (ricontrolla l'esttezza del codice inserito)
  $code_number = (int) preg_replace("/$base_code\-/", '', $code);
  if($code_number > $v_total_number) {
  	$resp['error'] = 'Invalid voucher';
    return new WP_REST_Response($resp,401);  	  	  	
  }

  //Controlla che il voucher non sia stato già usato -> 401 Voucher already used
  $used_codes = array();
  if(!empty($v_used_codes)) {
  	$used_codes = explode(',',$v_used_codes);
  }

  if(in_array($code, $used_codes)) {
 	$resp['error'] = 'Voucher already used';
    return new WP_REST_Response($resp,401);  	  	  	  	
  }

  //Esegui le operazioni di aggiornamento: VOUCHER: used_codes_number, ROUTES: aggiungi lo user alla route corrispondente. Manda un codice 200
  // UPDATE Voucher
  // 1. aggiorna used_codes
  array_push($used_codes, $code);
  update_field('used_codes',implode(',', $used_codes),$voucher_id);
  // 2. aggiorna used_code_number
  update_field('used_codes_number',count($used_codes),$voucher_id);

  // UPDATE ROUTE
  // 1. Aggiungi user alla lista delle route_ID
    $users = get_field('n7webmap_route_users', $route_id);
    $users_id=array();
    if (count($users)>0) {
    foreach ($users as $user) {
      $users_id[] = strval($user['ID']);
    }
    }
    if(!in_array($user_id, $users_id))  array_push($users_id, $user_id);
    update_field('n7webmap_route_users', $users_id, $route_id);


  $resp['message'] = 'OK';
  return new WP_REST_Response($resp,200);

}
$namespace = 'webmapp/v1';
$route = '/voucher';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V1VoucherRoute',
    'permission_callback' => function () {
          return true;
  }
);
$WebMapp_V1VoucherRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


