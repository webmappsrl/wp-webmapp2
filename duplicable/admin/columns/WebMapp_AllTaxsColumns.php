<?php

/**
 * Build with WebMapp_AdminColumns_Taxonomy, columns builder with admin-columns-pro plugin
 *
 * Columns of :
 * 'webmapp_category',
 * 'activity',
 * 'theme',
 * 'where',
 * 'when',
 * 'who
 */
$fields = array(
    array(
        'columns' => array(
            '5a688ed832ac4' => array(
                'type' => 'column-term_parent',
                'label' => 'Genitore',
                'width' => '',
                'width_unit' => '%',
                'term_property' => '',
                'edit' => 'on',
                'name' => '5a688ed832ac4'
            ),
            'name' => array(
                'type' => 'name',
                'label' => 'Nome',
                'width' => '',
                'width_unit' => '%',
                'edit' => 'on',
                'sort' => 'on',
                'name' => 'name'
            ),
            'slug' => array(
                'type' => 'slug',
                'label' => 'Slug',
                'width' => '',
                'width_unit' => '%',
                'edit' => 'on',
                'sort' => 'on',
                'name' => 'slug'
            ),
            '5a577d666decc' => array(
                'type' => 'column-acf_field',
                'label' => 'Color',
                'width' => '',
                'width_unit' => '%',
                'field' => 'wm_taxonomy_color',
                'edit' => 'on',
                'name' => '5a577d666decc'
            ),
            '5a577d666ed36' => array(
                'type' => 'column-acf_field',
                'label' => 'Icon',
                'width' => '',
                'width_unit' => '%',
                'field' => 'wm_taxonomy_icon',
                'character_limit' => '20',
                'edit' => 'on',
                'name' => '5a577d666ed36'
            ),
            '5a6893173a9af' => array(
                'type' => 'column-acf_field',
                'label' => 'Show by default',
                'width' => '',
                'width_unit' => '%',
                'field' => 'wp_taxonomy_show_by_default',
                'edit' => 'on',
                'name' => '5a6893173a9af'
            )
        ),

    )
);

$taxonomies = array(
    'webmapp_category',
    'activity',
	'theme',
	'where',
	'when',
	'who'
);


$global_vars = array();
foreach( $taxonomies as $tax ) :
    $global_vars['WebMapp_AllTaxsColumns_'.$tax] = new WebMapp_AdminColumns_Taxonomy( $tax , $fields );
endforeach;
extract( $global_vars );

//check existence of global objects created with extract()
//var_dump($WebMapp_AllTaxsColumns_activity );

add_filter( 'ac/column/value', 'my_column_meta_value_mask_key', 10, 3 );
/**
 * Filters icon value, inserted in a span class
 * @param $value
 * @param $object_id
 * @param $column
 * @return string
 */
function my_column_meta_value_mask_key( $value, $object_id, $column )
{
    $custom_field_name = '5a577d666ed36';

    if ( $custom_field_name == $column->get_name() && ! empty( $value ) ) {
        $value = '<span class="' . $value . '"></span>';
    }

    return $value;

}