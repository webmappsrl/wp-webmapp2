<?php


/**
 * Sub Class WebMapp_Acf of WebMapp_AbstractFields
 * Advanced custom fields element
 *
 * @property $object_names - string/array post_type/taxonomy slug to associate fields
 * @property $args array - args for acf_add_local_field_group
 * @property $fields array - options with arguments to print ( useful for REST-API )
 *
 * @reference https://www.advancedcustomfields.com/resources/register-fields-via-php/
 */
class WebMapp_Acf extends WebMapp_AbstractFields
{

    /**
     * WebMapp_Acf constructor
     * @param $object_names
     * @param $args
     */
    function __construct($object_names, $args)
    {
        parent::__construct($object_names, $args);
        add_action('acf/init', array($this, 'add_local_field_group'));
    }

    /**
     * ACF add group settings for us
     * Needs acf acf_add_local_field_group function to works
     */
    public function add_local_field_group()
    {
        if (!empty($this->args) && function_exists('acf_add_local_field_group')) 
        {
            if (isset($this->args['fields']) && is_array( $this->args['fields']) ) 
            {
                if (defined('WPML_TRANSLATE_CUSTOM_FIELD')) {
                    // WPML_IGNORE_CUSTOM_FIELD // => 0 for Don't translate
                    // WPML_COPY_CUSTOM_FIELD // => 1 for Copy
                    // WPML_TRANSLATE_CUSTOM_FIELD // => 2 for Translate
                    // WPML_COPY_ONCE_CUSTOM_FIELD // => 3 for Copy once

                    $this->args['fields'] = array_map(
                        function ($e) {
                            if ( ! isset( $e['wpml_cf_preferences'] ) && $e['type'] != 'tab' )
                            {
                                $e['wpml_cf_preferences'] = WPML_TRANSLATE_CUSTOM_FIELD;
                                if ( isset( $e['sub_fields'] ) && is_array( $e['sub_fields'] ) ) 
                                {
                                    foreach ( $e['sub_fields'] as $k => $v )
                                    {
                                        $e['sub_fields'][$k]['wpml_cf_preferences'] = WPML_TRANSLATE_CUSTOM_FIELD;
                                    }
                                }
                            }
                                
                                return $e;
                        },
                        $this->args['fields']
                    );
                }

                $this->args = apply_filters('WebMapp_pre_reg_field_acf', $this->args, $this->object_names );
                //ACF function
                acf_add_local_field_group($this->args);
            }
        }
    }
}
