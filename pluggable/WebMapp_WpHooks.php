<?php
/**
 * General Hooks
 * ToDo embed in core the best functions
 *
 */


/**
 *
 * @param $mime_types
 * @return mixed
 */
add_filter('upload_mimes', 'my_myme_types');
function my_myme_types($mime_types) {

    $mime_types['gpx'] = 'application/gpx+xml'; //Adding svg extension

    return $mime_types;
}



// Replaces the excerpt "Read More" text by a link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
    global $post;
    return '...';
}



add_filter( 'login_message', 'webmapp_login_message' );
function webmapp_login_message( $message ) {
    $action = $_REQUEST['action'];
    if( $action == 'lostpassword' ) {
        $message = '<p class="message">Inserisci il tuo indirizzo email, poi controlla nella tua casella postale per il link che ti permette di resettare la password</p>';
        return $message;
    }
    return;
}


add_action( 'login_head', 'login_function' );
function login_function() {
    add_filter( 'gettext', 'username_change', 20, 3 );
    function username_change( $translated_text, $text, $domain )
    {
        if ($translated_text === 'Nome utente o indirizzo email' || $text === 'Username')
        {
            $translated_text = 'E-Mail';
        }
        return $translated_text;
    }
}


add_filter( 'lostpassword_redirect', 'my_redirect_home' );
function my_redirect_home( $lostpassword_redirect ) {
    return wp_login_url().'?action=lostpassword&webmapp_close=true';
}

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return '#';
}

add_action('save_post', 'webmapp_manage_qe_save_post', 10, 2);
function webmapp_manage_qe_save_post($post_id, $post) {

    // pointless if $_POST is empty (this happens on bulk edit)
    if (empty($_POST)) {
        return $post_id;
    }

    // verify quick edit nonce
    if (isset($_POST['_inline_edit']) && !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
        return $post_id;
    }

    // don't save for autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // dont save for revisions
    if (isset($post->post_type) && $post->post_type == 'revision') {
        return $post_id;
    }

    switch ($post->post_type) {

        case 'poi':

            /**
             * Because this action is run in several places, checking for the array key
             * keeps WordPress from editing data that wasn't in the form, i.e. if you had
             * this post meta on your "Quick Edit" but didn't have it on the "Edit Post" screen.
             */
            $custom_fields = array('noDetails', 'noInteraction');

            foreach ($custom_fields as $field) {

                if (array_key_exists($field, $_POST) && $_POST[$field] != '-1') {
                    update_post_meta($post_id, $field, $_POST[$field]);
                }
            }

            break;

    }

}