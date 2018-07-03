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
    function __construct( $object_names, $args )
    {
        parent::__construct($object_names, $args);
        $this->acfs[] = new WebMapp_Acf( $object_names, $args );
        $this->rest_apis[] = new WebMapp_RestApi( $object_names, $args );
    }


}