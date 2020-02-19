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
        'token' => WebMapp_getToken(),
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
    $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
    $user = wp_get_current_user();

        /** If the authentication fails return a error*/
        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            return new WP_Error(
                '[jwt_auth] ' . $error_code,
                $user->get_error_message($error_code),
                array(
                    'status' => 403,
                )
            );
        }

        /** Valid credentials, the user exists create the according Token */
        $issuedAt = time();
        $notBefore = apply_filters('jwt_auth_not_before', $issuedAt, $issuedAt);
        $expire = apply_filters('jwt_auth_expire', $issuedAt + (DAY_IN_SECONDS * 7), $issuedAt);

        $token = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                ),
            ),
        );
        /** Let the user modify the token data before the sign. */
        $token = \Firebase\JWT\JWT::encode(apply_filters('jwt_auth_token_before_sign', $token, $user), $secret_key);
        return $token;
}