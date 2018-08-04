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

    if ( isset( $_GET['add_user'] ) && $_GET['add_user'] ) {
        wp_enqueue_script('webmapp-add_user_to_route', trailingslashit(plugin_dir_url(__FILE__)) . 'includes/js/add_user_to_route.js', array(
            'jquery'
        ), '', TRUE);


    }
}

