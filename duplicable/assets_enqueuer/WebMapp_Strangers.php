<?php
add_action('admin_print_scripts-edit.php', 'webmapp_manage_qe_admin_scripts');
function webmapp_manage_qe_admin_scripts() {

    // if using code as plugin
    wp_enqueue_script('webmapp-manage-bulk-quick-edit', WebMapp_ASSETS . 'js/bulk_quick_edit.js', array(
        'jquery',
        'inline-edit-post'
    ), '', TRUE);

}

/* actions fired when listing/adding/editing posts or pages */
/* admin_head-(hookname) */
add_action('admin_head-post.php', 'admin_head_route_editing');;
function admin_head_route_editing() {

    if ($_GET['add_user']) {
        wp_enqueue_script('webmapp-add_user_to_route', trailingslashit(plugin_dir_url(__FILE__)) . 'includes/js/add_user_to_route.js', array(
            'jquery'
        ), '', TRUE);


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