<?php

use NextendSocialLogin;

const WEBMAPP_SOCIAL_PROVIDERS = array("google", "facebook");

function WebMapp_V2SocialLogin(WP_REST_Request $request)
{
    $param = $request->get_params();

    if ($request->get_method() != 'POST') {
        return new WP_REST_Response(['message' => "Method {$request->get_method()} not valid. Please use POST"], 405);
    }

    if (!class_exists("NextendSocialLogin")) {
        return new WP_REST_Response(['message' => "Missing NextendSocialLogin Wordpress plugin. Unable to execute the operation"], 500);
    }

    $provider_param = isset($param["provider"]) ? $param["provider"] : false;
    $access_token_param = isset($param["access_token"]) ? $param["access_token"] : false;

    if (!$provider_param || !$access_token_param) {
        $message = "";
        if (!$provider_param) $message .= "provider";
        if (!$access_token_param) {
            if ($message) $message .= ', ';
            $message .= "access_token";
        }
        return new WP_REST_Response(['message' => "Missing parameter(s) {$message}"], 400);
    }

    if (!in_array($provider_param, WEBMAPP_SOCIAL_PROVIDERS))
        return new WP_REST_Response(['message' => "Provider '{$provider_param}' unknown"], 400);

    $provider = NextendSocialLogin::$enabledProviders[$provider_param];

    try {
        $social_id = $provider->findSocialIDByAccessToken($access_token_param);
    } catch (Exception $e) {
        return new WP_REST_Response(['code' => 'invalid_token', 'message' => $e->getMessage(), 'status' => 403], 403);
    }

    $user_email = $provider->getAuthUserData("email");
    $user = get_user_by_email($user_email);
    if (!$user) {
        /**
         * Sign up the user
         */
        $first_name = $provider->getAuthUserData("first_name");
        $last_name = $provider->getAuthUserData("last_name");

        $newUser = array(
            "user_pass" => wp_generate_password(),
            "user_login" => $user_email,
            "user_nicename" => "{$first_name} {$last_name}",
            "user_email" => $user_email,
            "nickname" => $user_email,
            "first_name" => $first_name,
            "last_name" => $last_name
        );

        wp_insert_user($newUser);
        $user = get_user_by_email($user_email);
    }

    if (!$user) {
        return new WP_REST_Response(['code' => 'unable_sign_up', 'message' => "The sign up process failed and we could not create the user", 'status' => 500], 500);
    }
    $user_id = $user->ID;
    wp_set_current_user($user_id);
    $token = WebMapp_getToken();

    return new WP_REST_Response(["message" => "Login successful", "id" => $user_id, "token" => $token], 200);
}

$namespace = 'webmapp/v2';
$createRoute = '/social_login';
$args = array(
    'methods' => 'POST',
    'callback' => 'WebMapp_V2SocialLogin'
);
new WebMapp_RegisterRestRoute($namespace, $createRoute, $args);
