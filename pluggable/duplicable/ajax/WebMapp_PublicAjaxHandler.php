<?php


/**
 * PUBLIC AJAX
 */

/**
 * todo
 * ????
 */
function add_user_to_route() {

    $username = get_userdata($_REQUEST['user_id']);

    echo json_encode($username->data);

    die();

}
new WebMapp_AjaxHandler( true ,'add_user_to_route' );

