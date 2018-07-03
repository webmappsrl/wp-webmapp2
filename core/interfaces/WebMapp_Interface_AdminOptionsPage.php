<?php
/**
 * Questa interfaccia rappresenta la classe ( e subclassi )  WebMapp_OptionsPage
 */

interface WebMapp_Interface_AdminOptionsPage
{

    /**
     * Class properties
     *
     * @private menu_slug - slug pagina
     * @private menu_title - slug pagina
     *
     * @public page_title - titolo pagina
     *
     * @private settings_group - gruppo opzioni
     *
     * @private tabs - array ( { tab slug } => { tab label } )
     *
     * @private settings - array (
     *                              { setting name } =>  array(
     *                                                          'tab' => array(
     *                                                                      'tab_slug' => { tab slug },
     *                                                                      'tab_name' => { tab label }
     *                                                          ),
     *                                                          'info' => short option description
     *                                                          'attrs' => array( { attr name } => { attr value } )//please no value
     *                                                          'type' => { setting input type },
     *                                                          'options' => { array of setting-value => setting-label, useful if type is select } ,
     *                                                          'label' => input label,
     *                                                          'value' => input value
     *                                                   )
     *
     *                      )
     *
     */



}