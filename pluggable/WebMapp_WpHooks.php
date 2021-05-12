<?php
/**
 * General Hooks
 *
 */


/** FIX orderby rand pagination */

add_filter('posts_orderby', 'wm_edit_posts_rand_orderby', 10, 2);
function wm_edit_posts_rand_orderby($orderby_statement, $wp_query) {
    if ( $wp_query->get('orderby') == 'rand' )
    {
        try
        {
            $seed = $_SESSION['seed'];
            if (empty($seed)) {
                $seed = rand();
                $_SESSION['seed'] = $seed;
            }

            $orderby_statement = 'RAND('.$seed.')';
        }
        catch( Exception $e )
        {
            trigger_error( $e );
        }
    }

    return $orderby_statement;
}


// Replaces the excerpt "Read More" text by a link
add_filter('excerpt_more', 'webmapp_new_excerpt_more');
function webmapp_new_excerpt_more($more) {
    global $post;
    return '...';
}



add_filter( 'login_message', 'webmapp_login_message' );
function webmapp_login_message( $message ) {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
    if( $action == 'lostpassword' ) {
        $message = sprintf('<p class="message">%s</p>', __('Enter your email address, then check in your mailbox for the link that allows you to reset the password','webmapp'));
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

// Gets the custom logo for wp-login page from webmapp options
function custom_login_logo() {
    $custom_logo_id = get_option('webmapp_wp_login_logo');
    $custom_logo = wp_get_attachment_image_src($custom_logo_id);
    if ($custom_logo){
        $css_style = '<style type="text/css">
                    h1 a { background-image: url('.$custom_logo[0].') !important;}
                </style>';
    } else {
        $css_style = '<style type="text/css">
                    h1 a { background-image: url(/wp-content/plugins/wp-webmapp2/assets/images/logowebmapp.png) !important;}
                </style>';
    }
    echo $css_style;
}
add_action('login_head', 'custom_login_logo');

add_filter( 'lostpassword_url',  'wm_lostpassword_url', 9, 2 );
function wm_lostpassword_url($lostpassword_url, $redirect) {
    $lang = ICL_LANGUAGE_CODE;
    return $lostpassword_url.'&lang='.$lang;
}

add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
    return '#';
}

add_filter( 'lostpassword_redirect', 'my_redirect_home' );
function my_redirect_home( $lostpassword_redirect ) {
    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
        $lang = ICL_LANGUAGE_CODE;
    }
    return wp_login_url().'?action=lostpassword&webmapp_close=true&lang='.$lang;
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


add_action('save_post_route', 'route_save_meta');
function route_save_meta($post_id) {
    if (isset($_POST['n7webmapp_route_bbox'])) {
        update_post_meta($post_id, 'n7webmapp_route_bbox', $_POST['n7webmapp_route_bbox']);
    }
}


// BULK EDIT - QUICK EDIT

add_filter('manage_posts_columns', 'webmapp_manage_posts_columns', 10, 2);
function webmapp_manage_posts_columns($columns, $post_type) {
    switch ($post_type) {

        case 'poi':

            // building a new array of column data
            $new_columns = array();

            foreach ($columns as $key => $value) {

                // default-ly add every original column
                $new_columns[$key] = $value;

                /**
                 * If currently adding the title column,
                 * follow immediately with our custom columns.
                 */
                if ($key == 'title') {
                    $new_columns['noDetails'] = 'No Details';
                    $new_columns['noInteractions'] = 'No Interaction';
                }

            }

            return $new_columns;
    }


    return $columns;

}

add_action('manage_posts_custom_column', 'webmapp_manage_posts_custom_column', 10, 2);
function webmapp_manage_posts_custom_column($column_name, $post_id) {

    switch ($column_name) {

        case 'noDetails': ?>

            <input type="hidden" id="noDetails-<?php echo $post_id; ?>"
                   name="noDetails"
                   value="<?php if (get_field('noDetails', $post_id) != 1) {
                       echo 0;
                   } ?>">
            <?php if (get_field('noDetails', $post_id) == 1) {
                echo 'ON';
            }
            else {
                echo 'OFF';
            } ?>
            <?php
            break;

        case 'noInteractions': ?>

            <input type="hidden" id="noInteractions-<?php echo $post_id; ?>"
                   name="noInteractions"
                   value="<?php if (get_field('noInteraction', $post_id) != 1) {
                       echo 0;
                   } ?>">
            <?php if (get_field('noInteraction', $post_id) == 1) {
                echo 'ON';
            }
            else {
                echo 'OFF';
            } ?>
            <?php
            break;

    }

}

add_action('quick_edit_custom_box', 'webmapp_manage_bulk_edit_custom_box', 10, 2);
add_action('bulk_edit_custom_box', 'webmapp_manage_bulk_edit_custom_box', 10, 2);
function webmapp_manage_bulk_edit_custom_box($column_name, $post_type) {

    switch ($post_type) {

        case 'poi':

            switch ($column_name) {

                case 'noDetails':

                    ?>
                    <fieldset class="inline-edit-col-right">
                        <div class="inline-edit-col">
                            <div class="inline-edit-group wp-clearfix">
                                <label class="inline-edit-status alignleft">
                                    <span class="title">No Details</span>
                                    <select id="noDetails" name="noDetails">
                                        <option value="-1">— No Change —</option>
                                        <option value="1">ON</option>
                                        <option value="0">OFF</option>
                                    </select>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <?php
                    break;


                case 'noInteractions':

                    ?>
                    <fieldset class="inline-edit-col-right">
                        <div class="inline-edit-col">
                            <div class="inline-edit-group wp-clearfix">
                                <label class="inline-edit-status alignleft">
                                    <span class="title">No Interactions</span>
                                    <select id="noInteraction" name="noInteraction">
                                        <option value="-1">— No Change —</option>
                                        <option value="1">ON</option>
                                        <option value="0">OFF</option>
                                    </select>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <?php
                    break;


            }
    }

}


// /** WPML CLONE FEATURED IMAGE **/
add_action( "save_post_route", "wm_copy_featured_image_on_save_route" , 10 , 3);
add_action( "save_post_track", "wm_copy_featured_image_on_save_track" , 10 , 3);
add_action( "save_post_poi", "wm_copy_featured_image_on_save_poi" , 10 , 3);

function wm_copy_featured_image_on_save_route( $post_id, $post, $update ){

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang )
        return;

    $this_post_thumb = get_post_thumbnail_id( $post );
    if ( $this_post_thumb )
        return;
    
    $post_default_language = apply_filters( 'wpml_object_id', $post_id, 'route', FALSE, $default_lang );
    if ( ! $post_default_language )
        return;
        
    $post_thumb = get_post_thumbnail_id( $post_default_language );
    if ( ! $post_thumb )
        return;

    set_post_thumbnail( $post, $post_thumb );
        
}


function wm_copy_featured_image_on_save_track( $post_id, $post, $update ){

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang )
        return;

    $this_post_thumb = get_post_thumbnail_id( $post );
    if ( $this_post_thumb )
        return;
    
    $post_default_language = apply_filters( 'wpml_object_id', $post_id, 'track', FALSE, $default_lang );
    if ( ! $post_default_language )
        return;
        
    $post_thumb = get_post_thumbnail_id( $post_default_language );
    if ( ! $post_thumb )
        return;

    set_post_thumbnail( $post, $post_thumb );
        
}

function wm_copy_featured_image_on_save_poi ( $post_id, $post, $update ){

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] && $post_lang['language_code'] == $default_lang )
        return;

    $this_post_thumb = get_post_thumbnail_id( $post );
    if ( $this_post_thumb )
        return;
    
    $post_default_language = apply_filters( 'wpml_object_id', $post_id, 'poi', FALSE, $default_lang );
    if ( ! $post_default_language )
        return;
        
    $post_thumb = get_post_thumbnail_id( $post_default_language );
    if ( ! $post_thumb )
        return;

    set_post_thumbnail( $post, $post_thumb );
        
}


add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
    add_image_size( 'pdf-large', 1080, 608, array( 'center', 'center' ) ); // Hard crop center

}



function wm_session_start() {
    // starts  asession if its not already started 
    // it is needed for hoqu API calls to store the IDs
    if( ! session_id() ) {
        session_start();
    }

}

add_action('admin_init', 'wm_session_start');


add_filter( 'rest_webmapp_category_query', 'add_wpml_to_taxonomy', 10, 2 );
function add_wpml_to_taxonomy() {

}


// add_action( 'rest_api_init', function () {
//     $term_types = get_taxonomies( array( ), 'objects' );
// 	foreach( $term_types as $term_type ) {
// 		register_rest_field( $term_type->name,
//             'wpml_current_locale',
//             array(
//                 'get_callback'    => function ($object) {
//                     global $sitepress;
//                     $args = array(
//                         'element_id' => $object['id'],
//                         'element_type' => $object['taxonomy']
//                     );
//                     $langInfo = apply_filters( 'wpml_element_language_code', null, $args );
//                     return $sitepress->get_locale( $langInfo );
//                 },
//                 'update_callback' => null,
//                 'schema'          => null,
//             )
// 	    );

//         // register_rest_field( $term_type->name,
//         //     'wpml_translations',
//         //     array(
//         //         'get_callback'    => function ($object) {
//         //             global $sitepress;
//         //             $languages = apply_filters('wpml_active_languages', null);
//         //             $translations = [];

//         //             foreach ($languages as $language) {
//         //                 $post_id = wpml_object_id_filter($object['id'], $object['taxonomy'], false, $language['language_code']);
//         //                 if ($post_id === null || $post_id == $object['id']) continue;
                        
//         //                 remove_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
//         //                 remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
                        
                        
//         //                 $thisPost = get_term($post_id);
                        
//         //                 add_filter('get_term', array($sitepress,'get_term_adjust_id'), 1, 1);
//         //                 add_filter('terms_clauses', array($sitepress, 'terms_clauses'));

//         //                 $href = home_url();
//         //                 $href .= '/wp-json/wp/v2/'.$object['taxonomy'] . '/'.$post_id;
                        
//         //                 $translations[] = array('locale' => $language['default_locale'], 'id' => $thisPost->term_id, 'name' => $thisPost->name, 'source' => $href);
//         //             }

//         //             return $translations; 
//         //         },
//         //         'update_callback' => null,
//         //         'schema'          => null,
//         //     )
// 	    // );
// 	}
// } );