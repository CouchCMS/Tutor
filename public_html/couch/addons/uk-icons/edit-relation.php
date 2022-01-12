<?php
    if ( !defined('K_ADMIN') ) die(); // cannot be loaded directly

    require_once( K_ADDONS_DIR.'relation/edit-relation.php' );

    class KRelationIconAdmin extends KRelationAdmin{

        function _default_list_fields(){
            global $FUNCS;

            $fields = parent::_default_list_fields();

            $fields['icon'] =
                array(
                    'weight'=>'-10',
                    'header'=>'Icon',
                    'class'=>'icon',
                    'content'=>"<cms:render 'show_icon' />",
                    'sortable'=>'0',
                );
            $css .= ".col-icon {width: 12%; min-width: 100px;}";
            $css .= ".col-icon img {width: 40px; height:40px;}";
            $FUNCS->add_css( $css );    

            $fields['k_page_title']['content']="<cms:show k_page_title />";    
            $fields['k_page_title']['sortable']=0;
            unset( $fields['k_page_date'] );

            return $fields;
        }

        function _default_list_filter_actions(){
            global $FUNCS;
            $arr_filters = array();

            $arr_filters['filter_folders'] =
                array(
                    'render'=>'filter_folders',
                    'weight'=>10,
                );

            return $arr_filters;
        }

        function _set_list_sort( $orderby='', $order='' ){
            global $FUNCS;

            $FUNCS->set_admin_list_default_sort( 'page_title', 'asc' );
        }

        // route filters
        static function resolve_entities( $route ){
            global $FUNCS, $PAGE, $DB, $AUTH, $KSESSION;

            if( isset($_POST['__k_relation_ids__']) ){
                // save ids in session..
                $sid = md5( $AUTH->hasher->get_random_bytes(16) );
                $obj = new stdClass();
                $obj->skip_ids = $_POST['__k_relation_ids__'];
                $obj->selected_ids = array();
                $KSESSION->set_var( $sid, $obj );

                $redirect_dest = K_ADMIN_URL . K_ADMIN_PAGE . '?o=relation_icon&q=' . $route->matched_path . '&sid=' . $sid;
                header( "Location: " . $redirect_dest );
                exit;
            }

            KRelationAdmin::resolve_entities( $route );
        }
    } // end class KRelationIconAdmin
