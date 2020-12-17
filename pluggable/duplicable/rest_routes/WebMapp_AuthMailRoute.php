<?php

/**
 * Send mail
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_send_mail_request()
 */
function WebMapp_V1SendMailRoute( WP_REST_Request $request ) {

    $to = get_option('admin_email');
    $email = $request->get_param("email");
    $route_id = $request->get_param('pack');
    $app_name = $request->get_param('appname');
    $title = get_the_title($route_id);

    // Email the user
    if ($route_id && $email && $title) {

        // ADMIN EMAIL
        $subject = $app_name . ' - Nuova richiesta download itinerario';
        $user = get_user_by('email', $email);
        $token = $token = bin2hex(random_bytes(10));
        $auth_link = '<a href="' . get_site_url(NULL, 'wp-json/webmapp/v1/authorize?u=' . base64_encode($user->ID) . '&r=' . base64_encode($route_id)) . '&app=' . base64_encode($app_name) . '&token=' . $token .'">AUTORIZZA</a>';
        $deny_link = '<a href="' . get_site_url(NULL, 'wp-json/webmapp/v1/deny?u=' . base64_encode($user->ID) . '&r=' . base64_encode($route_id)) . '&app=' . base64_encode($app_name) . '&token=' . $token . '">NEGA</a>';
        $message = 'Buongiorno, l’utente ' . $user->first_name . ' ' . $user->last_name . ' ' .  $email . ' ha richiesto il download dell’itinerario "' . $title . '"';
        $message .= '<br />' . $auth_link . ' - ' . $deny_link;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $transient = 'request_route_' . $route_id . '_user_' . $user->ID;
        set_transient($transient, $token, WEEK_IN_SECONDS);
        wp_mail($to, $subject, $message, $headers);

        // USER EMAIL
        $subject = 'Myeasyroute request';
        $message = <<<EOF
Gentile utente Myeasyroute,<br />
ti ringraziamo per aver scaricato e utilizzato la nostra App.<br />
<br />
Myeasyroute è una nuova app e stiamo costantemente lavorando per implementare e migliorare tutte le sezioni.<br />
La funzione "Acquista" è ancora in versione beta, e sarà operativa in modo automatico a breve.<br />
Nel frattempo, se vuoi procedere all'acquisto dell'itinerario da te scelto, ti invitiamo a rispondere a questa email indicandoci i tuoi dati personali:<br />
<br />
Nome e cognome<br />
Nome del tour che si desidera scaricare<br />
Indirizzo di fatturazione<br />
Ti risponderemo a breve inviandoti un link per effettuare il pagamento sicuro con carta di credito su piattaforma E-commerce, 
e a seguire ti invieremo il codice per scaricare l'itinerario.<br />
<br />
A disposizione per qualunque chiarimento, ti ringraziamo.<br />
<br />
Il team di Myeasyroute<br />
<br />
=======================================================<br />
<br />
Dear Myeasyroute user,<br />
thank you for downloading and using our App.<br />
<br />
Myeasyroute is a new app and we are constantly working to implement and improve all the sections.<br />
The "Buy" feature is still in beta, and will be operational soon.<br />
In the meantime, if you want to proceed with the purchase of the itinerary you choose, we invite you to reply to 
this email indicating your personal data:<br />
<br />
Name and surname<br />
Name of the required tour<br />
Billing address<br />
We will reply shortly by sending you a link to make secure payment by credit card on the E-commerce platform, 
and then we will send you the code to download the itinerary.<br />
<br />
We remain at your disposal for any further information.<br />
<br />
The Myeasyroute team<br />
EOF;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            "From: Myeasyroute Team <$to>",
            "Reply-To: Myeasyroute Team <$to>",
        );
        wp_mail($email, $subject, $message, $headers);

        return new WP_REST_Response($request, 200);
    }
    else {
        if (empty($id)) {
            return new WP_REST_Response('Manca il riferimento alla mappa', 401);
        }
        else {
            if (empty($email)) {
                return new WP_REST_Response('Manca l\'email utente', 401);
            }
            else {
                if (empty($title)) {
                    return new WP_REST_Response('La mappa non è disponibile', 401);
                }
            }
        }
    }


}
$namespace = 'webmapp/v1';
$route = '/mail';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V1SendMailRoute',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
          return true;
  }
);
new WebMapp_RegisterRestRoute( $namespace , $route, $args );


/**
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 *
 * webmapp_authorize_request()
 */
function WebMapp_V1AuthorizeRequestRoute(WP_REST_Request $request) {

    $user_id = $request->get_param("u");
    $route_id = $request->get_param("r");
    $app = $request->get_param("app");
    $token = $request->get_param("token");
    $user_id = base64_decode($user_id);
    $route_id = base64_decode($route_id);
    $transient = 'request_route_' . $route_id . '_user_' . $user_id;
    $check_token = get_transient( $transient );

    if ( $token !== $check_token){
        return new WP_REST_Response('La richiesta non &egrave; più valida', 401);
    }

    if ($user_id && $route_id) {
        $title = get_the_title($route_id);
        $users_id = array();
        $users = get_field('n7webmap_route_users', $route_id);
        foreach ($users as $user) {
            $users_id[] = strval($user['ID']);
        }

        array_push($users_id, $user_id);
        update_field('n7webmap_route_users', $users_id, $route_id);

        $user_info = get_userdata($user_id);
        $user_mail = $user_info->user_email;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $app_name = '';
        if ($app) {
            $app_name = base64_decode($app);
        }
        if (!empty($user_info->first_name) && !empty($user_info->last_name)) {
            $message = 'Caro ' . $user_info->first_name . ' ' . $user_info->last_name . ',<br />';
        }
        else {
            $message = 'Caro ' . $user_mail . ',<br />';
        }
        $message .= 'complimenti, puoi aggiornare l\'app scorrendo verso l\'alto e scaricare l\'itinerario richiesto. Ci aiuterai cosi nella sperimentazione dell\'app ' . $app_name;
        $subject = $app_name . ' - Sei stato autorizzato a scaricare l\'itinerario: ' . $title;
        wp_mail($user_mail, $subject, $message, $headers);
        delete_transient( $transient );
        $url = admin_url();
        wp_redirect($url);
        exit;
        return new WP_REST_Response('Utente autorizzato.', 200);
    }
    else {
        if (empty($users_id)) {
            return new WP_REST_Response('Manca il riferimento all\'utente', 401);
        }
        else {
            if ($route_id) {
                return new WP_REST_Response('L\'itinerario non è disponibile', 401);
            }
        }
    }

}
$namespace = 'webmapp/v1';
$route = '/authorize/';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1AuthorizeRequestRoute',
    'permission_callback' => function () {
      $user_id = get_current_user_id();
      if (isset($user_id) && !empty($user_id) && $user_id > 0)
          return true;
  }
);
new WebMapp_RegisterRestRoute( $namespace , $route, $args );

/**
 * @param WP_REST_Request $request
 * @return WP_REST_Response
 * webmapp_deny_request()
 */
function WebMapp_V1DenyRequestRoute(WP_REST_Request $request) {

    $user_id = $request->get_param("u");
    $route_id = $request->get_param("r");
    $app = $request->get_param("app");
    $token = $request->get_param("token");
    $user_id = base64_decode($user_id);
    $route_id = base64_decode($route_id);
    $transient = 'request_route_' . $route_id . '_user_' . $user_id;
    $check_token = get_transient( $transient );

    if ( $token !== $check_token){
        return new WP_REST_Response('La richiesta non &egrave; più valida', 401);
    }

    if ($user_id && $route_id) {

        $title = get_the_title($route_id);
        $app_name = '';
        if ($app) {
            $app_name = base64_decode($app);
        }
        $user_info = get_userdata($user_id);
        $user_mail = $user_info->user_email;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        if (!empty($user_info->first_name) && !empty($user_info->last_name)) {
            $message = 'Caro ' . $user_info->first_name . ' ' . $user_info->last_name . ',<br />';
        }
        else {
            $message = 'Caro ' . $user_mail .',<br />';
        }
        $message .= 'questo itinerario è riservato ai clienti ' . $app_name . ' che hanno acquistato questo viaggio. Terminata la fase di sperimentazione, gli itinerari saranno disponibili a tutti.';
        $subject = $app_name . ' - Non sei autorizzato a scaricare l\'itinerario: ' . $title;
        wp_mail($user_mail, $subject, $message, $headers);
        delete_transient( $transient );
        $url = admin_url();
        wp_redirect($url);
        exit;
        return new WP_REST_Response('Utente non autorizzato.', 200);
    }
    else {
        if (empty($users_id)) {
            return new WP_REST_Response('Manca il riferimento all\'utente', 401);
        }
        else {
            if ($route_id) {
                return new WP_REST_Response('L\'itinerario non è disponibile', 401);
            }
        }
    }


}
$namespace = 'webmapp/v1';
$route = '/deny';
$args = array(
    'methods' => 'GET',
    'callback' => 'WebMapp_V1DenyRequestRoute',
    'permission_callback' => function () {
          return true;
  }
);
new WebMapp_RegisterRestRoute( $namespace , $route, $args );
