<?php

class WebMapp_PostToFeature {

    public $body = [ 
        'type' => 'Feature' , 
        'geometry' => [], 
        'properties' => [
            'taxonomy' => []
        ], 
    ];
    
    protected $geoJsonDatamodelVersion = 3; 
    protected $fieldsVersioning = [];
    protected $dataModelMapping;
    //mapping: geojson field => wp field
    protected $wpFieldsMapping = array(
        // 'post_content'
        // (mixed) The post content. Default empty.
        'description' => 'post_content',
        // 'post_title'
        // (string) The post title. Default empty.
        'name' => 'post_title',
        // 'post_excerpt'
        // (string) The post excerpt. Default empty.
        'excerpt' => 'post_excerpt'

    );

    protected $post_id;
    public $post_type;
    protected $post;
    
    function __construct( $post_id ){
        $this->post = get_post($post_id);
        $this->post_type = $this->post->post_type;
        $this->post_id = $this->post->ID;
        $this->set_bodyData('id', $this->post_id );
        $this->set_bodyData('image', get_post_thumbnail_id($this->post_id) );
        $fieldsVersioning = file_get_contents(WebMapp_DIR . "/core/fieldsMapping/webmappFieldsVersioning_$this->post_type.json");
        $this->fieldsVersioning = json_decode( $fieldsVersioning, true );
        $this->set_wpPostFields();
        $this->set_acfMeta();
        $this->set_wpTaxs();
    }


    protected function set_wpPostFields( ) 
    {
        foreach( $this->wpFieldsMapping as $geoJsonField => $wpField) {
            $this->set_bodyData( $geoJsonField ,$this->post->$wpField );
        }
    }

    private function set_bodyData( $name , $value )
    {
        $this->body['properties'][$name] = $value;
    }
    private function set_bodyTaxTerms( $tax , $terms )
    {
        $this->body['properties']['taxonomy'][$tax] = $terms;
    }

    public function get_body(){
        return $this->body;
    }

    protected function bodyPropExists( $name )
    {
        return isset( $this->body[$name] ) ? $this->body[$name] : false;
    }

    protected function getFieldsMapping() {
       
        $t = [];
        foreach ( $this->fieldsVersioning  as $i )
        {
            $geojson_key = end($i['name']);
            $current_datamodel_key = $i['name'][WM_DATAMODEL_VERSION];
            $t[$geojson_key] = $current_datamodel_key;
        }

        return $t;
    }

    public function get_dataModelMapping(){
        return $this->dataModelMapping;
    }

    protected function set_acfMeta() {

        //correct data model key => current data model key
        $dataModelMapping = $this->getFieldsMapping();
        $this->dataModelMapping = $dataModelMapping;
        $fields = get_fields($this->post_id);
        if ( $fields )
        {
            foreach ( $fields as $prop_name => $value )
            {
                if ( ! ($k = array_search( $prop_name , $dataModelMapping ) ) )
                    continue;
                
                $this->set_bodyData( $k , $value);   
            }
        }

        
        
    }

    protected function set_wpTaxs( $append = false ) {

        $taxonomies = get_object_taxonomies( $this->post );
        
        foreach ( $taxonomies as $taxonomy_name )
        {
            $terms = get_the_terms( $this->post_id , $taxonomy_name );
            if ( $terms )
            {
                $terms = array_map( function($i){
                    return $i->term_id;
                }, $terms );

            if ( is_array( $terms ) && ! empty( $terms ) )
                $this->set_bodyTaxTerms( $taxonomy_name , $terms );
            }
            
        }
    }

}