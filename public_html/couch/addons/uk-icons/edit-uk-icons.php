<?php
    if ( !defined('K_ADMIN') ) die(); // cannot be loaded directly

    require_once( K_COUCH_DIR.'edit-pages.php' );

    class KIconAdmin extends KPagesAdmin{
        function __construct(){
            parent::__construct();
        }

        /////// 1. 'list' action ////////////////////////////////////////////////////
        function list_action_ex(){
            global $FUNCS;

            $FUNCS->add_event_listener( 'pages_list_post_action',  array($this, '_exit_action_handler') );

            return KBaseAdmin::list_action();
        }

        function _exit_action_handler( &$redirect_dest ){
            global $FUNCS, $CTX;

            $CTX->set( 'k_selected_icon', trim( $FUNCS->cleanXSS(strip_tags($_POST['selected_icon'])) ), 'global' );
            $CTX->set( 'k_icon_exit_action', '1', 'global' );
            $redirect_dest = '';
        }

        function render_list(){
            global $FUNCS, $CTX;

            $CTX->set( 'k_cur_form', $this->list_form_name, 'global' );
            $CTX->set( 'k_list_is_searchable', 0, 'global' );

            $FUNCS->load_css( K_ADMIN_URL.'addons/bootstrap-grid/theme/grid12.css' );
            $html = $FUNCS->render( 'content_list_icon' );
            $html = $FUNCS->render( 'main', $html, 1 );
            $FUNCS->route_fully_rendered = 1;

            return $html;
        }

        function define_list_fields(){
            return KBaseAdmin::define_list_fields();
        }

        function _default_list_toolbar_actions(){
            return KBaseAdmin::_default_list_toolbar_actions();
        }

        function _default_list_batch_actions(){
            return KBaseAdmin::_default_list_batch_actions();
        }

        function _default_list_page_actions(){
            global $FUNCS;
            
            $arr_actions = array();

            $arr_actions['btn_cancel'] =
                array(
                    'title'=>$FUNCS->t('cancel'),
                    'onclick'=>array(
                        "window.parent.COUCH.uk_icons_close_modal();",
                        "return false;",
                    ),
                    'icon'=>'circle-x',
                    'weight'=>0,
                );

            return $arr_actions;
        }

        function _default_list_row_actions(){
            return KBaseAdmin::_default_list_row_actions();
        }

        function _default_list_fields(){
            $fields = array();
            return $fields;
        }

        function _set_list_sort( $orderby='', $order='' ){
            global $FUNCS;

            $FUNCS->set_admin_list_default_sort( 'page_title', 'asc' );
        }

        function _set_list_limit( $limit='' ){
            global $FUNCS;

            $limit = trim( $limit );
            if( $limit=='' ){  $limit = '36'; }

            $FUNCS->set_admin_list_default_limit( $limit );
        }

        // route filters
        static function resolve_entities( $route ){
            global $FUNCS, $PAGE, $DB;

            // set $PAGE object
            $pg = null;
            $rs = $DB->select( K_TBL_TEMPLATES, array('id'), "name='blocks/icons.php'" );
            if( count($rs) ){
                $pg = new KWebpage( $rs[0]['id'], null );
                if( $pg->error ){ $pg=null; }
            }

            if( is_null($pg) ){
                return $FUNCS->raise_error( ROUTE_NOT_FOUND );
            }

            $PAGE = $pg;
            $PAGE->set_context();
        }

    } // end class KIconAdmin
