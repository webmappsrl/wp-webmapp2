<?php

$default_lang = apply_filters('wpml_default_language', NULL );
$args = array(
    'login_css' => array(
        'src' => WebMapp_ASSETS . 'css/webmapp-login.css',
        'deps' => false
    )
);

$WebMapp_LoginAssets = new WebMapp_AssetEnqueuer( $args,'login','style' );
$args = array(
    'login_js' => array(
        'src' => WebMapp_ASSETS . 'js/webmapp-login.js',
        'deps' => false,
        'localize' => array(
	        'object_name' => 'webmapp_login_text',
	        'data' => array(
                'it-IT' => array(
                    'data' => array(
                        'check_email' => __('Controlla l\'email, ti abbiamo inviato il link da usare per resettare la password', 'webmapp'),
                        'success_password' => __('La password è stata reimpostata.','webmapp'),
                    ),
                ),
                'en-US' => array(
                    'data' => array(
                        'check_email' => __('Check the email, we sent you the link to use to reset the password', 'webmapp'),
                        'success_password' => __('The password has been reset.','webmapp'),
                    ),
                ),
                'fr-FR' => array(
                    'data' => array(
                        'check_email' => __('Vérifiez l\'email, nous vous avons envoyé le lien à utiliser pour réinitialiser le mot de passe', 'webmapp'),
                        'success_password' => __('Le mot de passe a été réinitialisé.','webmapp'),
                    ),
                ),
                'default' => $default_lang
	        ),
        )
    ),

);
$WebMapp_LoginAssets = new WebMapp_AssetEnqueuer( $args,'login','script' );