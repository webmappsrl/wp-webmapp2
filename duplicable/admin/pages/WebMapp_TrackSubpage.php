<?php
/**
 * Hook is necessary to permit wp_terms_checklist() works properly
 */
add_action( '_admin_menu' , function()
{

    ob_start();
    ?>

    <h3>Import track from GPX file</h3>
    <form enctype="multipart/form-data">
        <input type="file" name="webmapp_file_upload" id="webmapp-new-track-gpx"/>
        <p class="description">Upload a gpx file to import it's POIs. Use filename with no special character, only the .gpx extension.</p>
    </form>
    <script type="text/javascript">
        (function($){
            $('#webmapp-new-track-gpx').on('change', function(e){
                console.log( 'changed' );

                $.post( ajaxurl , {
                    action : 'webmapp_file_upload'
                } )
                    .done( function( data ){

                        console.log( data );
                        jQuery(".upload-kml .loader").addClass("hidden-loader");
                        jQuery('#create_obj_from_kml #preview-import').append("<h3>Preview of import</h3>");
                        if(data["poi"].length > 0){
                            jQuery('#create_obj_from_kml #preview-import').append("<table class='acf-table'></table>");
                            jQuery('#create_obj_from_kml #preview-import table').append("<thead><tr><th>OSM</th><th>Name</th><th>Desc</th><th>Categories <a href='#' title='add POI categories' class='dashicons dashicons-plus-alt add-poi-cat'><input type='hidden' id='massive_selected_cat'></th><th>Import POI <input type='checkbox' name='check_all_rows' checked value=''></th></tr></thead>");

                            data["poi"].forEach(function(entry, index){
                                jQuery('#create_obj_from_kml #preview-import table').append("<tr><td><a href='#' class='osm-dialog' data-lat='"+entry["lat"]+"' data-lon='"+entry["lon"]+"'><i class='fa fa-globe' aria-hidden='true'></i></a></td>"+
                                    "<td> <input type='text' name='object_name' disabled value='"+entry["name"]+"'><button type='button' class='button button-small hide-if-no-js enable-poi-edit' aria-label='Edit name'>Edit</button> </td><td>"+entry["desc"]+"</td><td class='poi_cat_cell'><a href='#' title='edit POI categories' class='dashicons dashicons-edit edit-poi-cat' data-poi='"+index+"'></a></td><td><input type='checkbox' name='poi_to_import' checked value='"+index+"'></td></tr>")
                            })
                        }
                        jQuery('#create_obj_from_kml #preview-import').prepend("<br><input type='submit' class='acf-button button button-primary' value='Import "+type+"'>" );
                        jQuery('#create_obj_from_kml #preview-import').append("<br><input type='submit' class='acf-button button button-primary' value='Import "+type+"'>" );

                        jQuery('body').on("submit", "#create_obj_from_kml", data, handleImportKlm);

                    } )
                    .fail( function( response ){
                        alert('Ajax call failure. Please refresh the page.');
                    } );

            });



        })(jQuery);
    </script>


    <?php
    $html = ob_get_clean();





    $tabs = array(
        'create-new-track' => _x( "Add new track", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN )
    );

    $html_pieces = array(
        'tab_1' => array(
            'html' => $html,
            'info' => "short description",
            'tab' => 'create-new-track'
        )

    );
/**
    new WebMapp_AdminOptionsPage_Sub(
        'edit.php?post_type=track',
        __('Add new track' , WebMapp_TEXTDOMAIN ),
        __('Add new track' , WebMapp_TEXTDOMAIN ),
        'edit_posts',
        'webmapp-add-new-track',
        $html_pieces,
        $tabs
    );
 * **/
} );
