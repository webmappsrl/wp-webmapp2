<?php
/**
 * Created by PhpStorm.
 * User: marco
 * Date: 02/07/18
 * Time: 19:18
 */

/**
 * Class WebMapp_AssetEnqueuer
 * todo add to arguments screen support for frontend
 * todo add media support
 * todo get file extension to inference registration type !!
 */
class WebMapp_AssetEnqueuer implements WebMapp_Interface_AssetsEnqueuer
{
    /**
     * @var array
     */
    protected $all_sides = array( 'admin' , 'login' , 'wp' );

    protected $all_register_types = array( 'script' , 'style' );

    protected $handlers;
    protected $srcs;
    protected $in_footers;
    protected $depss;
    protected $screen_ids;
    protected $screen_bases;
    protected $localizes;


    public $current_screen;

    public $sides;
    public $args;
    public $register_type;


    /**
     * WebMapp_AssetEnqueuer constructor.
     * @param $args
     * @param $sides
     * @param string $register_type
     */
    function __construct( $args , $sides , $register_type = 'script' )
    {

        if ( ! is_array( $sides ) )
            $sides = array( $sides );

        //todo trigger error
        if ( empty( array_intersect( $sides , $this->all_sides ) ) )
            return;

        //todo trigger error
        if ( ! is_string( $register_type ) || ! in_array( $register_type , $this->all_register_types) )
            return;

        $this->sides = $sides;
        $this->args = $args;
        $this->register_type = $register_type;

        $this->init_properties();


        foreach ( $this->sides as $side )
        {
            if ( $side == 'admin')
                add_action( 'admin_enqueue_scripts' , array( $this , 'admin_enqueue_scripts' ) );
            else
                add_action( $side . '_enqueue_scripts' , array( $this , 'enqueue_scripts' ) );
        }


    }

    /**
     *
     */
    public function init_properties()
    {
        foreach ( $this->args as $handler_name => $handle_args )
        {

            $this->handlers[] = $handler_name;
            $this->srcs[$handler_name] = isset( $handle_args['src'] ) ? $handle_args['src'] : '';
            $this->in_footers[$handler_name] = isset( $handle_args['in_footer'] ) ? $handle_args['in_footer'] : true ;
            $this->depss[$handler_name] = isset( $handle_args['deps'] ) ? $handle_args['deps'] : array() ;
            $this->screen_bases[$handler_name] = isset( $handle_args['screen_base'] ) ? $handle_args['screen_base'] : '' ;
            $this->screen_ids[$handler_name] = isset( $handle_args['screen_id'] ) ? $handle_args['screen_id'] : '' ;
            $this->localizes[$handler_name] = isset( $handle_args['localize'] ) ? $handle_args['localize'] : '' ;

        }
    }

    public function enqueue_scripts()
    {

        foreach ( $this->handlers as $handler )
        {
            $resource_type = $this->register_type;

            $enqueue_method = 'enqueue_'.$resource_type;
            $this->$enqueue_method( $handler , $this->srcs[$handler] , $this->depss[$handler], $this->in_footers[$handler] );
        }

    }

    public function admin_enqueue_scripts()
    {

        /**
         * get here current screen because in constructor get_current_screen() function is not available
         */
        $this->current_screen = get_current_screen();

        foreach ( $this->handlers as $handler )
        {
            if ( $this-> can_enqueue_in_current_page( $handler ) )
            {
                $resource_type = $this->register_type;
                $enqueue_method = 'enqueue_' . $resource_type;
                $this->$enqueue_method($handler, $this->srcs[$handler], $this->depss[$handler], $this->in_footers[$handler]);
            }
        }

    }

    /**
     * Function to show a popup in current page to see screen base and id
     */
    public static function see_where_i_am()
    {
        $hooks = array( 'wp_footer' , 'admin_footer' , 'login_footer' );
        foreach ( $hooks as $hook )
        {
            add_action( $hook , function()
            {
                $current_screen = get_current_screen();
                $screen_id = $current_screen->id;//edit-artists
                $screen_base = $current_screen->base;
                ob_start();
                ?>
                <div style='display:none'>
                    <div id='see-me-page-infos'>
                        <h1>Current page screen info</h1>
                        <h2>screen_base:</h2>
                        <p><?php echo $screen_base ?></p>
                        <h2>screen_id:</h2>
                        <p><?php echo $screen_id ?></p>
                    </div>
                </div>
                <script type="text/javascript">
                    let i = document.getElementById('see-me-page-infos');
                    if ( i )
                    {
                        let wnd = window.open('about:blank', '', '_blank');
                        wnd.document.write(i.outerHTML);

                    }

                </script>
                <?php
                echo ob_get_clean();

            }, 99999 );
        }


    }



    /**
     *
     *
     * todo add media support
     *
     * @param $handle
     * @param $src
     * @param $deps
     * @param $in_footer
     *
     * @reference https://developer.wordpress.org/reference/functions/wp_enqueue_style/
     */
    public function enqueue_style( $handle , $src , $deps , $in_footer )
    {
        if ( $src )
            wp_register_style( $handle, $src, $deps );
        wp_enqueue_style($handle );
    }


    /**
     *
     *
     * todo add media support
     *
     * @param $handle
     * @param $src
     * @param $deps
     * @param $in_footer
     *
     * @reference https://developer.wordpress.org/reference/functions/wp_enqueue_script/
     */
    public function enqueue_script( $handle , $src , $deps , $in_footer )
    {
        if ( $src )
            wp_register_script($handle, $src, $deps, null, $in_footer);
        wp_enqueue_script($handle);

        //localize script with this handle
        if ( isset( $this->localizes[$handle] ) && ! empty( $this->localizes[$handle] ) )
        {
            $object_name = isset( $this->localizes[$handle]['object_name'] ) ? $this->localizes[$handle]['object_name'] : '';
            $data = isset( $this->localizes[$handle]['data'] ) && is_array($this->localizes[$handle]['data'] ) ? $this->localizes[$handle]['data'] : array();

            if ( ! empty( $object_name ) && ! empty( $data ) )
                wp_localize_script( $handle, $object_name, $data );
        }


    }

    /**
     * @param $handle
     * @return bool
     */
    protected function can_enqueue_in_current_page( $handle )
    {
        $r = true;

        if ( isset( $this->screen_ids[ $handle ] )
            && ! empty( $this->screen_ids[ $handle ] )
            && $this->current_screen->screen_id != $this->screen_ids[ $handle ]
        )
            $r = false;

        if ( isset( $this->screen_bases[ $handle ] )
            && ! empty( $this->screen_bases[ $handle ] )
            && $this->current_screen->screen_base != $this->screen_bases[ $handle ]
        )
            $r = false;

        return $r;
    }



}