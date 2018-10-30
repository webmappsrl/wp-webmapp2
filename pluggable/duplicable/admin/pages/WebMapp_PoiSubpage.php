<?php
/**
 * Hook is necessary to permit wp_terms_checklist() works properly
 * _admin_menu hook is fired BEFORE admin_menu ( where pages are added in wp-admin menu )
 *
 */
add_action( '_admin_menu' , function()
{
    ob_start();
    ?>

    <h1><?php echo __('Import Poi from KML', WebMapp_TEXTDOMAIN); ?></h1>
    <div class='upload-kml'>
        <?php echo __("Upload a kml file", WebMapp_TEXTDOMAIN)?><br>
        <input id='kml-upload-file' type='file' data-type="poi" name='async-upload'>
        <span class='hidden-loader loader'><img src='<?php echo WebMapp_ASSETS ?>images/spinner.gif'><?php echo __("Loading", WebMapp_TEXTDOMAIN) ?></span>
    </div>
    <form method="post" id="create_obj_from_kml" action="options.php">
        <div id="preview-import">
        </div>

    </form>

    <div id="webmap_category_dialog"  title="<?php echo __("Choose Webmapp categories", WebMapp_TEXTDOMAIN); ?>">
        <input type="hidden" value="" id="poi_el">
        <ul class="webmap_cat_checklist categorychecklist">
            <?php wp_terms_checklist(0, array("taxonomy" => "webmapp_category")); ?>
        </ul>
    </div>

    <div id="webmap_osm_dialog" title="<?php echo __("Open map on Openstreetmap", WebMapp_TEXTDOMAIN); ?>">
        <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="" style="border: 1px solid black"></iframe>
        <br/><small><a href="" target="_blank">Visualizza mappa ingrandita</a></small>
    </div>
    <?php
    $html = ob_get_clean();




    $tabs = array(
        'main' => _x( "Main", "Tab label in webmapp settings page", WebMapp_TEXTDOMAIN )
    );

    $html_pieces = array(
        'tab_1' => array(
            'html' => $html,
            'info' => "",
            'tab' => 'main'
        )

    );

    new WebMapp_AdminOptionsPage_Sub(
        'edit.php?post_type=poi',
        'Import from kml',
        'Import from kml',
        'manage_options',
        'import_poi_kml',
        $html_pieces,
        $tabs
    );
} );
