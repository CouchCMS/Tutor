<?php
    if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly

    if( defined('K_ADMIN') ){

        class KCopyToNew{
            var $config = array();

            function __construct(){
                global $FUNCS;

                // populate config
                $cfg = array();
                if( file_exists(K_ADDONS_DIR.'copy-to-new/config.php') ){
                    require_once( K_ADDONS_DIR.'copy-to-new/config.php' );
                }
                $tpls = array_unique( array_filter(array_map("trim", explode('|', $cfg['tpls']))) );
                $this->config['tpls'] = $tpls;

                $btn_text = trim( $cfg['btn_text'] );
                $this->config['btn_text'] = ( $btn_text !='' ) ? $btn_text : 'Copy to New';
                $btn_desc = trim( $cfg['btn_desc'] );
                $this->config['btn_desc'] = ( $btn_desc !='' ) ? $btn_desc : 'Copies the current page into a new page';

                unset( $cfg );

                // if any template specified in config, hook the right events ..
                if( count($this->config['tpls']) ){
                    $FUNCS->add_event_listener( 'alter_register_pages_routes',  array($this, 'alter_register_routes') );
                    $FUNCS->add_event_listener( 'alter_pages_form_toolbar_actions', array($this, 'add_toolbar_btn') );
                }
            }

            function alter_register_routes( $tpl, &$default_routes ){
                if( !in_array($tpl['name'], $this->config['tpls']) ) return;

                $route = array(
                    'path'=>'copy/{:nonce}/{:id}',
                    'constraints'=>array(
                        'nonce'=>'([a-fA-F0-9]{32})',
                        'id'=>'(([1-9]\d*)?)',
                    ),
                    'include_file'=>K_ADDONS_DIR.'copy-to-new/edit-copy-to-new.php',
                    'filters'=>'KCopyToNewAdmin::resolve_page=copy',
                    'class'=> ( $tpl['nested_pages'] ) ? 'KCopyToNewNestedAdmin' : 'KCopyToNewAdmin',
                    'action'=>'form_action',
                    'module'=>'copy-to-new',
                );
                $default_routes['copy_view'] =  $route;
            }

            function add_toolbar_btn( &$arr_buttons ){
                global $AUTH, $FUNCS, $PAGE;

                $route = $FUNCS->current_route;
                if( $route->module=='pages' && in_array($route->masterpage, $this->config['tpls']) ){
                    if( $PAGE->id != -1 && $PAGE->tpl_is_clonable && file_exists(K_SITE_DIR . $PAGE->tpl_name) && $AUTH->user->access_level >= $PAGE->tpl_access_level){
                        $arr_buttons['copy_to_new'] =
                            array(
                                'title'=>$this->config['btn_text'],
                                'desc'=>$this->config['btn_desc'],
                                'href'=>$FUNCS->get_qs_link( $FUNCS->generate_route($PAGE->tpl_name, 'copy_view', array('nonce'=>$FUNCS->create_nonce('edit_page_'.$PAGE->id), 'id'=>$PAGE->id)) ),
                                'icon'=>'fork',
                                'weight'=>9,
                            );
                    }
                }
            }
        }// end class

        new KCopyToNew();

    }/* K_ADMIN */
