<?php
// WEBMAPP CUSTOM ROLES

function wm_custom_roles() {
    // $capabilites del voucher
    $capabilites = WebMapp_Utils::build_custom_capabilities('voucher');
    $cap_def = array ();
    foreach($capabilites as $capability) {
        $cap_def[$capability] =true;
    }
    $cap_def['read']=true;
    // Devinizione del ruolo voucher
    remove_role('voucher_editor');
    add_role('voucher_editor',__('Voucher Editor'),$cap_def);

    // Aggiunta delle capabilities al ruolo di editor
    // $r = get_role( 'editor' );
    //  foreach ($capabilities as $capability) {
    //   	$r->add_cap($capability);
    // }

}

add_action('admin_init', 'wm_custom_roles');
//questo significa che ad ogni caricamento di wp viene eliminato e ricreato il ruolo !!!
//todo activation, deactivation hooks