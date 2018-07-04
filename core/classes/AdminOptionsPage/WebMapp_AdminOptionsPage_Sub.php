<?php
/**
 * Questa interfaccia rappresenta la classe ( e subclassi )  WebMapp_OptionsPage
 */

class WebMapp_AdminOptionsPage_Sub extends WebMapp_AdminOptionsPage implements WebMapp_Interface_AdminOptionsPage
{
    public $parent_slug;
    public $html_pieces;

    function __construct( $parent_slug , $page_title, $menu_title, $capability = 'manage_options', $menu_slug = 'webmapp', $html_pieces = array(), array $tabs = array())
    {

        parent::__construct($page_title, $menu_title, $capability, $menu_slug, array(), $tabs);

        $this->parent_slug = $parent_slug;
        $this->html_pieces = $html_pieces;

        foreach ( $this->html_pieces as $name => $args )
        {
            $this->settings[ $name ] = $args;
            $this->settings[ $name ]['type'] = 'html';
            if ( isset( $args['content'] ) )
                $this->settings[ $name ]['html'] = $args['content'];
        }


    }

    /**
     * Override parent::init()
     */
    public function start()
    {

        add_action( 'admin_menu', array( $this , 'add_submenu_page' ) );
    }

    /**
     * Class properties
     *
     * @private parent_slug - parent slug @reference :
     *
     */

    public function add_submenu_page()
    {

        add_submenu_page($this->parent_slug,
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            array( $this , 'render_tab_content' )
        );


    }

    public function render_tab_content()
    {
        /**
         * Todo - possibilità di modificare il wrapper?
         */
        $this->current_tab = $this->get_current_tab();
        echo "<div class='wrap'>";
        $this->render_tab_nav();
        $this->print_settings();
        echo "</div>";
    }




}