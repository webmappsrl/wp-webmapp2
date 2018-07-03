<?php

/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_user_data()
 */
function WebMapp_V1UserDataRoute( WP_REST_Request $request ) {
    $user = $request->get_param("user");
    $pass = $request->get_param("pass");
    $user = wp_authenticate_username_password(NULL, $user, $pass);
    if ($user->data) {
        $user_data = $user->data;
        $user_data->first_name = get_user_meta($user->ID, "first_name", TRUE);
        $user_data->last_name = get_user_meta($user->ID, "last_name", TRUE);
        $user_data->user_pass = "";
        return new WP_REST_Response($user_data, 200);
    }
    else {
        return new WP_REST_Response($user, 401);
    }
}
$namespace = 'webmapp/v1';
$route = '/user';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V1UserDataRoute'
);
$WebMapp_V1UserDataRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );


/**
 * Check user credentials and return user data
 *
 * @return object|null bounding box webmapp setting or null if none.
 *
 * webmapp_user_registration()
 */
function WebMapp_V1UserRegistrationRoute( WP_REST_Request $request ) {
    $to = get_option('admin_email');
    $email = $request->get_param("mail");
    $pass = $request->get_param("pass");
    $first_name = $request->get_param("first_name");
    $last_name = $request->get_param("last_name");
    $app_name = $request->get_param('appname');

    $newsletter = $request->get_param('newsletter');
    $country = $request->get_param('country');

    $subject = $app_name . ' - Nuova registrazione';

    $message = "Buongiorno, un nuovo utente ha effettuato la registrazione dalla APP Myeasyroute.<br /><br />";
    $message .= " Indirizzo email: ' . $email<br /><br />";
    $message .= " Newsletter: $newsletter<br /><br />";
    $message .= " Country: $country<br /><br />";

    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (NULL == username_exists($email)) {

        $user_id = wp_create_user($email, $pass, $email);

        wp_update_user(
            array(
                'ID' => $user_id,
                'nickname' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name
            )
        );

        if ($newsletter == true) {
            update_user_meta( $user_id, 'newsletter', true);
        }
        update_user_meta( $user_id, 'country', $country);

        // Set the role
        $user = new WP_User($user_id);
        $user->set_role('subscriber');

        wp_mail($to, $subject, $message, $headers);

        return new WP_REST_Response($user, 200);
    }
    else {

        return new WP_REST_Response('L\'emal inserita risulta già registrata', 401);
    }


}
$namespace = 'webmapp/v1';
$route = '/users';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V1UserRegistrationRoute'
);
$WebMapp_V1UserRegistrationRoute = new WebMapp_RegisterRestRoute( $namespace , $route, $args );
