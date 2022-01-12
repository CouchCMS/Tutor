<?php
    if ( !defined('K_ADMIN') ) die(); // cannot be loaded directly

    require_once( K_COUCH_DIR.'edit-pages.php' );

    class KCopyToNewAdmin extends KPagesAdmin{

        function __construct(){
            parent::__construct();
        }

        /////// 1. 'form' action  ////////////////////////////////////////////////////
        function _get_form_redirect_link( &$pg, $_mode ){
            global $FUNCS;

            // this function gets called when page is successfuly saved.
            // raise an event for fields that might demand special treament.
            if( $_mode=='create' ){
                $orig_page_id = $FUNCS->current_route->resolved_values['id'];

                // HOOK: copy_to_new_complete
                $FUNCS->dispatch_event( 'copy_to_new_complete', array(&$pg, $orig_page_id) );
            }

            // default action of this function
            return parent::_get_form_redirect_link( $pg, $_mode );
        }

        // route filters
        static function resolve_page( $route, $act ){
            global $FUNCS, $DB, $PAGE, $CTX;

            $rs = $DB->select( K_TBL_TEMPLATES, array('*'), "name='" . $DB->sanitize( $route->masterpage ). "'" );
            if( !count($rs) ){
                return $FUNCS->raise_error( ROUTE_NOT_FOUND );
            }
            $tpl = $rs[0];

            $tpl_id = $tpl['id'];
            $tpl_name = $tpl['name'];
            $page_id = $route->resolved_values['id'];
            $nonce = $route->resolved_values['nonce'];

            // validate
            $FUNCS->validate_nonce( 'edit_page_' . $page_id, $nonce );

            // get page ..
            if( !$_POST ){
                $pg = new KWebpage( $tpl_id, $page_id );
                if( $pg->error ){
                    return $FUNCS->raise_error( ROUTE_NOT_FOUND );
                }

                // and clone it (in a hackish way) ..
                $pg->id = -1;
                $pg->page_name = $name;
                for( $x=0; $x<count($pg->fields); $x++ ){
                    $f = &$pg->fields[$x];
                    $f->page_id = $pg->id;
                    $f->modified = 1;
                    if( $f->name=='k_page_name' ){
                        $f->data='';
                    }
                    unset( $f );
                }
            }
            else{
                $pg = new KWebpage( $tpl_id, -1 );
                if( $pg->error ){
                    return $FUNCS->raise_error( ROUTE_NOT_FOUND );
                }
            }

            // set cloned page as the page object to edit
            $PAGE = $pg;
            $PAGE->folders->set_sort( 'weight', 'asc' );
            $PAGE->folders->sort( 1 );
            $PAGE->set_context();
        }
    } // end class KCopyToNewAdmin

    class KCopyToNewNestedAdmin extends KCopyToNewAdmin{
        function _set_advanced_setting_fields( &$arr_fields ){
            global $FUNCS, $PAGE;

            parent::_set_advanced_setting_fields( $arr_fields );

            $arr_fields['k_publish_date']['label'] = $FUNCS->t( 'status' );

            $arr_fields['k_show_in_menu']['group'] = '_advanced_settings_';
            $arr_fields['k_show_in_menu']['label'] = $FUNCS->t( 'menu' );
            $arr_fields['k_show_in_menu']['order'] = 40;

            $arr_fields['k_menu_text']['group'] = '_advanced_settings_';
            $arr_fields['k_menu_text']['hide'] = 0;
            $arr_fields['k_menu_text']['order'] = 50;

            // coalasce 'k_open_external' and 'k_is_pointer' fields into one
            $arr_fields['k_open_external']['skip'] = 1;
            $arr_fields['k_is_pointer']['skip'] = 1;
            $arr_fields['k_menu_link'] = array(
                'group'=>'_advanced_settings_',
                'label'=>$FUNCS->t( 'menu_link' ),
                'no_wrapper'=>1,
                'content'=>"<cms:render 'group_menu_link_fields' />",
                'order'=>60,
            );

            // create a group for 'k_pointer_link', 'k_masquerades' and 'k_strict_matching'
            $arr_fields[ '_pointer_fields_' ] = array(
                'no_wrapper'=>'1',
                'content'=>"<cms:render 'group_pointer_fields' />",
                'hide'=>( $PAGE->_fields['k_is_pointer']->get_data() ) ? 0 : 1,
                'order'=>30,
            );
            $arr_fields['k_pointer_link']['group'] = '_pointer_fields_';
            $arr_fields['k_pointer_link']['order'] = 10;
            $arr_fields['k_masquerades']['group'] = '_pointer_fields_';
            $arr_fields['k_masquerades']['no_wrapper'] = 1;
            $arr_fields['k_masquerades']['hide'] = ( strtolower($PAGE->tpl_name)=='index.php' ) ? 0 : 1; //No masquerading option for templates other than index.php (will always only redirect).
            $arr_fields['k_masquerades']['order'] = 20;
            $arr_fields['k_strict_matching']['group'] = '_pointer_fields_';
            $arr_fields['k_strict_matching']['no_wrapper'] = 1;
            $arr_fields['k_strict_matching']['order'] = 30;

            // set the visibility of custom-fields group depending on pointer status
            $arr_fields['_custom_fields_']['hide'] = ( $PAGE->_fields['k_is_pointer']->get_data() ) ? 1 : 0;

        }
    }
