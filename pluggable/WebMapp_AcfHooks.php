<?php

add_action( 'wpml_loaded', 'webmapp2_wpml_loaded' );
function webmapp2_wpml_loaded() {
    add_filter( "acf/pre_format_value", "webmapp2_filter_translatable_fields", 10 , 4 );
}
   
function webmapp2_filter_translatable_fields( $check , $value, $post_id, $field ){
    //fare questo solo per i campi traducibili
    if ( isset( $field['wpml_cf_preferences'] ) && $field['wpml_cf_preferences'] != WEBMAPP_TRANSLATE_CUSTOM_FIELD )
        return $check;

    //check if value is empty
    if ( $value )
        return;

    if ( ! $post_id )
        return $check;

    if ( is_admin() )
        return $check;

    if ( ! isset( $field['name'] ) )
        return $check;

    $allowed_post_types = [
        'route',
        'track',
        'poi'
    ];
    $post_type = get_post_type( $post_id );

    if ( ! in_array( $post_type , $allowed_post_types ) )
        return $check;

    //get post language
    $post_lang = apply_filters( 'wpml_post_language_details', NULL, $post_id );
    //get wpml default language
    $default_lang = apply_filters('wpml_default_language', NULL );
    if ( $post_lang['language_code'] == $default_lang )
        return $check;

    //get the post in default language
    $post_default_language = apply_filters( 'wpml_object_id', $post_id, $post_type, FALSE, $default_lang );
    remove_filter( "acf/pre_format_value", "webmapp2_filter_translatable_fields" , 10 );
    $value = get_field( $field['name'], $post_default_language );
    add_filter( "acf/pre_format_value", "webmapp2_filter_translatable_fields", 10 , 4 );
    
    

    return $value;
}







add_action('acf/init', 'webmap_acf_init');
function webmap_acf_init() {
    if (get_option('google_api_key') && get_option('google_api_key') != "") {
        acf_update_setting('google_api_key', get_option('google_api_key'));
    }
}



add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
    if ( is_admin() ){
        global $current_screen;
        ?>
        <div id="webmap_category_dialog"
             title="<?php echo __("Choose Webmapp categories", "webmap_net7"); ?>">
            <input type="hidden" value="" id="poi_el">
            <ul class="webmap_cat_checklist categorychecklist">
                <?php wp_terms_checklist(0, array("taxonomy" => "webmapp_category")); ?>
            </ul>
        </div>

        <div id="webmap_osm_dialog"
             title="<?php echo __("Open map on Openstreetmap", "webmap_net7"); ?>">
            <iframe width="425" height="350" frameborder="0" scrolling="no"
                    marginheight="0" marginwidth="0" src=""
                    style="border: 1px solid black"></iframe>
            <br/>
            <small><a href="" target="_blank">Visualizza mappa ingrandita</a>
            </small>
        </div>


        <script type="text/javascript">
            (function($) {

                $(document).ready(function() {

                    $('.acf-field-parse-gpx .acf-input').append("<form id='webmapp-gpx-import' data-type='<?php echo $current_screen->post_type ?>'></form>");
                    $('.acf-field-parse-gpx .acf-input #webmapp-gpx-import').append('<?php wp_nonce_field('image-submission'); ?>');
                    $('.acf-field-parse-gpx .acf-input #webmapp-gpx-import').append("<div class='acf-label'><?php echo __("Upload a gpx file to import it's POIs. Use filename with no special character, only the .gpx extension.", "webmap_net7")?></div>");
                    $('.acf-field-parse-gpx .acf-input #webmapp-gpx-import').append('<div><input id=\'gpx-upload-file\' type=\'file\' name=\'async-upload\'></div>');

                    $('.acf-field-parse-gpx .acf-input').append("<span class='hidden-loader loader'><img src='<?php echo WebMapp_ASSETS ?>images/spinner.gif'><?php echo __("Loading", "webmap_net7") ?></span>");
                    $('.acf-field-parse-gpx .acf-input').append('<div class=\'acf-repeater\' id=\'track-import-preview\'></div>');
                    $('#webmap_category_dialog').dialog(
                        {
                            dialogClass: 'webmapp_category_dialog',
                            draggable: true,
                            autoOpen: false,
                            closeText: 'close',
                            show: true
                        }
                    );
                });
            })(jQuery);
        </script>
        <style type="text/css">
            .acf-field #wp-content-editor-tools {
                background: transparent;
                padding-top: 0;
            }
        </style>
        <?php
    }
}


add_filter( 'wpml_custom_field_original_data', 'disable_original_lang_data' );

function disable_original_lang_data(){
return;
}