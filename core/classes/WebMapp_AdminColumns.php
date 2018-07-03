<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 03/07/18
 * Time: 16:24
 */

class WebMapp_AdminColumns
{
    /**
     * Check existence of plugin admin-columns-pro todo???
     */

    public $fields;
    public $object_slug;


    function __construct( $object_slug , $fields )
    {
        $this->object_slug = $object_slug;
        $this->fields = $fields;
        //Works only with admin-columns plugin ( free/PRO version  )
        $test = has_action('ac/ready' );
        /* Todo?? */
        add_action( 'ac/ready', array( $this , 'ac_register_columns' ) );

    }

    public function get_object_slug()
    {
        return $this->object_slug;
    }

    public function ac_register_columns()
    {
        ac_register_columns($this->get_object_slug() , $this->fields ) ;
    }





}
