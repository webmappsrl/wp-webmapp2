<?php

class WebMapp_AdminColumns_Taxonomy extends WebMapp_AdminColumns
{
    function __construct($object_slug, $fields)
    {
        parent::__construct($object_slug, $fields);

    }

    public function get_object_slug()
    {
        $new_slug = 'wp-taxonomy_' . $this->object_slug;
        $this->object_slug = $new_slug;
        return $new_slug;
    }



}