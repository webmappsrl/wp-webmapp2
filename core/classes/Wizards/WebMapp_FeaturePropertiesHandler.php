<?php

class WebMapp_FeaturePropertiesHandler
{

    public $body;

    public $post_type;
    protected $postArr = [
        //'tax_input' => [],
        'meta_input' => [],
    ];
    protected $translations = [];
    protected $fieldsVersioning = [];

    protected $geoJsonDatamodelVersion = 3;

    protected $alreadyProcessedFields = [];

    protected $dataModelMapping;

    protected $post_id;

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
        'excerpt' => 'post_excerpt',
    );

    public function __construct($body, $post_type = 'route')
    {
        $this->body = $body;
        $this->post_type = $post_type;
        $this->postArr['post_type'] = $post_type;
        $fieldsVersioning = file_get_contents(WebMapp_DIR . "/core/fieldsMapping/webmappFieldsVersioning_$post_type.json");
        $this->fieldsVersioning = json_decode($fieldsVersioning, true);
        $this->set_wpPostFields();
    }

    public function set_postId($id)
    {
        // 'ID'
        // (int) The post ID. If equal to something other than 0, the post with that ID will be updated. Default 0.
        if ($id) {
            $this->post_id = $id;
            $this->set_postArrData('ID', $id);

            $post_status = get_post_status($this->post_id);
            $this->set_postArrData('post_status', $post_status);
        }
    }

    protected function set_wpPostFields()
    {
        foreach ($this->wpFieldsMapping as $geoJsonField => $wpField) {
            if ($data = $this->bodyPropExists($geoJsonField)) {
                $this->alreadyProcessedFields[] = $geoJsonField;
                $this->set_postArrData($wpField, $data);
            }

        }

        // 'meta_input'
        // (array) Array of post meta values keyed by their post meta key. Default empty.
        //$this->set_acfMeta();

        // 'tax_input'
        // (array) Array of taxonomy terms keyed by their taxonomy name. Default empty.
        //$this->set_wpTaxs();

    }

    private function set_postArrData($name, $value)
    {
        $this->postArr[$name] = $value;
    }

    public function get_postArr()
    {
        return $this->postArr;
    }

    protected function bodyPropExists($name)
    {
        return isset($this->body[$name]) ? $this->body[$name] : false;
    }

    protected function getFieldsMapping()
    {
        $t = [];
        foreach ($this->fieldsVersioning as $i) {
            $geojson_key = end($i['name']);
            $current_datamodel_key = $i['name'][WM_DATAMODEL_VERSION];
            $t[$geojson_key] = $current_datamodel_key;
        }

        return $t;
    }

    public function get_dataModelMapping()
    {
        return $this->dataModelMapping;
    }

    protected function set_acfMeta()
    {
        //correct data model key => current data model key
        $dataModelMapping = $this->getFieldsMapping();

        $this->dataModelMapping = $dataModelMapping;

        foreach ($this->body as $prop_name => $value) {
            if (in_array($prop_name, $this->alreadyProcessedFields)) {
                continue;
            }

            if (!key_exists($prop_name, $dataModelMapping)) {
                continue;
            }

            update_field($dataModelMapping[$prop_name], $value, $this->post_id);
            $this->alreadyProcessedFields[] = $prop_name;

        }
    }

    protected function set_wpTaxs($append = false)
    {
        if (!isset($this->body['taxonomy'])) {
            return;
        }

        foreach ($this->body['taxonomy'] as $taxonomy_name => $ids) {
            wp_set_object_terms($this->post_id, $ids, $taxonomy_name, $append);
            //todo check if taxonomy exists for this content type
            //$this->postArr['tax_input'][$taxonomy_name] = $ids;
        }
    }

    public function createPost()
    {
        $post_id = wp_insert_post($this->get_postArr());
        if (is_numeric($post_id)) {
            $this->post_id = $post_id;
            $this->set_wpTaxs();
            $this->set_acfMeta();
            if (isset($this->body['image']) && is_int($this->body['image'])) {
                set_post_thumbnail($post_id, $this->body['image']);
            }
        } else {
            return $post_id;
        }

        return $post_id;
    }
}
