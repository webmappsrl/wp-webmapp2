<?php


class WebMapp_WpBackendColumns
{

    public $post_type;
    public $col_title;
    public $col_slug;
    public $col_slug_prefix = 'webmapp_';

    public $callback;

    function __construct( $post_type , $col_title, $callback )
    {

        if ( ! function_exists( $callback ) )
            return;

        if ( ! is_string( $col_title ) )
            return;

        $this->post_type = $post_type;
        $this->col_title = $col_title;
        $this->col_slug = $this->col_slug_prefix . sanitize_title($col_title);
        $this->callback = $callback;

        add_action('init' , array( $this , 'init' ) );

    }

    public function init()
    {
        if ( ! post_type_exists( $this->post_type ) )
            return;

        add_filter( "manage_{$this->post_type}_posts_columns", array( $this , 'set_column' ) , 1 );
        add_action( "manage_{$this->post_type}_posts_custom_column" , array( $this , 'column_container' ) , 1, 2 );
    }

    public function set_column( $columns )
    {
        $columns[$this->col_slug] = $this->col_title;
        return $columns;
    }

    public function column_container( $column, $post_id )
    {
        $stop = '';
        switch ( $column )
        {
            case $this->col_slug :
                call_user_func( $this->callback , $post_id );
                break;
            default:
                break;
        }
    }
}