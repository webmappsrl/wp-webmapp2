<?php
/**
 * This class is parent of rest-api class and acf class
 * This object is useful to register rest-api and acf at the same time
 */

class WebMapp_RegisterFieldsGroup extends WebMapp_AbstractFields
{
    public $rest_apis = array();
    public $acfs = array();

    //todo -> filter route fields by option has_route

    /**
     * WebMapp_RegisterFieldsGroup constructor.
     * @param $object_names
     * @param $args
     * @param bool $in_rest_api
     */
    function __construct( $object_names, $args, $in_rest_api = true )
    {
        parent::__construct($object_names, $args);
        $this->acfs[] = new WebMapp_Acf( $object_names, $args );
    }


}