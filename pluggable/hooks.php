<?php

/**
 *
 * This page is not loaded
 *
 */


/**
 *
 * TAXONOMY REGISTRATION
 *
 */

/**
 * Hook post type registration arguments
 */
$args = apply_filters( 'WebMapp_pre_register_post_type', $this->args, $this->post_type, $this->project_has_route );

/**
 * Hook taxonomy registration arguments
 */
$args = apply_filters( 'WebMapp_pre_register_taxonomy' , $this->args ,  $this->tax_name, $this->args );


/**
 *
 * POST TYPE REGISTRATION
 *
 */

/**
 * Filter object types for taxonomy before registration
 */
$object_types = apply_filters( 'WebMapp_taxonomy_object_types' , $object_types , $this->tax_name, $this->args );


/**
 *
 *
 * REST-API
 *
 *
 */


/**
 * Filter register_rest_field callback
 */
$callback = apply_filters( 'WebMapp_pre_reg_field_rest-api', $callback , $object_type, $attribute );