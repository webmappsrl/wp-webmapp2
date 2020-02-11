<?php



function WebMapp_getWizardConfiguration( $name = '' )
{
    $current_lang = substr( get_locale() , 0 , 2 );
    if( has_filter('wpml_current_language') ) 
        $current_lang = apply_filters( 'wpml_current_language', NULL );

    # Admin credentials here
    $user = wp_get_current_user();

    $userlogin = $user->data->user_login;
    
    $arr = [
        //'token' => WebMapp_getToken(),
        'user' => $userlogin,
        'api' => [
            'save' => home_url('/wp-json/webmapp/v3/wizard/routeWizard/route')
        ],
        'options' => [
            'tour_operator' => TRUE
        ],
        'wizard' => 'routeWizard',
        'lang' => $current_lang
    ];

    return json_encode( $arr );
}



/**
*   Generate a JWT token for future API calls to WordPress
*/
function WebMapp_getToken() {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, home_url('/wp-json/jwt-auth/v1/token') );
    curl_setopt($ch, CURLOPT_POST, 1);

    # Admin credentials here
    $user = wp_get_current_user();

    $userlogin = $user->data->user_login;
    $userpwd = $user->data->user_pass;//NONE
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=$userlogin&password=$userpwd"); 

    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);
    if ($server_output === false) {
        return 'Error getting JWT token on WordPress for API integration.';
    }
    $server_output = json_decode($server_output);

    if ($server_output === null && json_last_error() !== JSON_ERROR_NONE) {
        return 'Invalid response getting JWT token on WordPress for API integration.';
    }

    if (!empty($server_output->token)) {
        $token = $server_output->token; # Token is here
        curl_close ($ch);
        return $token;
    } else {
        return 'Invalid response getting JWT token on WordPress for API integration.';
    }
    return false;
}
