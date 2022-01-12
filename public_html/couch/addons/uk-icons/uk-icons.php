<?php
    if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly

    class KIcon extends KUserDefinedField{
        const js_folder = 'assets/js/';
        const js_path = K_SITE_DIR . self::js_folder;

        // Show in admin panel
        function _render( $input_name, $input_id, $extra='', $dynamic_insertion=0 ){
            global $FUNCS;

            $html = $FUNCS->render( 'field_icon', $this, $input_name, $input_id, $extra, $dynamic_insertion );
            return $html;
        }

        // routes
        static function register_routes(){
            global $FUNCS;

            $route = array(
                'name'=>'list_view',
                'path'=>'list',
                'include_file'=>K_ADDONS_DIR.'uk-icons/edit-uk-icons.php',
                'filters'=>'KIconAdmin::resolve_entities',
                'class'=> 'KIconAdmin',
                'action'=>'list_action_ex',
                'module'=>'uk-icons', /* owner module of this route */
            );
            $FUNCS->register_route( 'uk-icons', $route );

            $route = array(
                'name'=>'list_view',
                'path'=>'list/{:tpl_id}/{:field_name}/{:page_id}',
                'constraints'=>array(
                    'tpl_id'=>'([1-9]\d*)',
                    'field_name'=>'([0-9a-z-_]+)',
                    /*'page_id'=>'([1-9]\d*)?',*/
                    'page_id'=>'((?:[1-9]\d*)?)',
                ),
                'include_file'=>K_ADDONS_DIR.'uk-icons/edit-relation.php',
                'filters'=>'KRelationIconAdmin::resolve_entities',
                'class'=> 'KRelationIconAdmin',
                'action'=>'list_action_ex',
                'module'=>'relation_icon', /* owner module of this route */
            );
            $FUNCS->register_route( 'relation_icon', $route );
        }

        // renderable theme functions
        static function register_renderables(){
            global $FUNCS;

            $FUNCS->register_render( 'field_icon',              array('renderable'=>array('KIcon', '_render_icon')) );
            $FUNCS->register_render( 'content_list_icon',       array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
            $FUNCS->register_render( 'content_list_icon_inner', array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
            $FUNCS->register_render( 'content_list_icon_exit',  array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
            $FUNCS->register_render( 'show_icon',               array('renderable'=>array('KIcon', '_render_show_icon')) );
        }

        static function override_renderables(){
            global $FUNCS, $DB;

            $target_masterpage = 'blocks/icons.php';
            $route=$FUNCS->current_route;
            if( $route->module=='pages' && $route->masterpage==$target_masterpage && $route->name=='edit_view' ){
                $FUNCS->override_render( 'field_relation_advanced', array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/', 'template_ctx_setter'=>array('KIcon', '_render_relation_advanced')) );
                $FUNCS->override_render( 'content_form',            array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
            }
            if( $route->module=='relation_icon'&& $route->name=='list_view' ){
                $FUNCS->override_render( 'content_list_relation',      array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
                $FUNCS->override_render( 'content_list_relation_exit', array('template_path'=>K_ADDONS_DIR.'uk-icons/theme/') );
            }
        }

        static function _render_icon( $f, $input_name, $input_id, $extra, $dynamic_insertion ){
            global $FUNCS, $CTX;
            static $done=0;

            $admin_link = K_ADMIN_URL;
            $system_theme_link = K_SYSTEM_THEME_URL;
            $target_link = K_ADMIN_URL . K_ADMIN_PAGE.'?o=uk-icons&q=list';
            $value = trim( $f->get_data() );
            $width = ( $f->width ) ? $f->width : 50 ;
            if( $value=='' ){ $value='question'; }
            $deleted = ( $f->deleted ) ? 'disabled="1"' : '';
            $edit_icon = $FUNCS->get_icon( 'pencil' );
            $edit_text = $FUNCS->t( 'edit' );

            $html2 = '';
            if( $dynamic_insertion ){
                $html2=<<<EOS
                <img src="${system_theme_link}assets/blank.gif" alt="" id="${input_id}_dummyimg" onload="
                    var el=$('#${input_id}_button');
                    if(!el.attr('idx')){
                        COUCH.uk_icons_bind_popup_iframe( el );
                    }
                " />
EOS;
            }

            $html=<<<EOS
            <a href="$target_link" id="${input_id}_button" data-kc-finder="${input_id}" class="icon-preview icon-popup-iframe">
                <img id="${input_id}_icon_preview" name="${input_name}_icon_preview" src="${admin_link}addons/uk-icons/icons/${value}.svg" width=$width height=$width class="k_icon_preview">
            </a>

            <div class="input-group upload-group icon-upload-group">
                <input type="text" name="${input_name}" id="$input_id" size="65" value="$value" readonly="1" style="display:none;" >
                $html2
            </div>
EOS;
            if( !$done ){
                $css=<<<EOS
                .icon-upload-group {display:none;}
EOS;
                $FUNCS->add_css( $css );

                $js=<<<EOS
                $( function(){
                    var choose_icon = function( \$button, icon ) {
                        var id = \$button.attr( "data-kc-finder" );

                        \$( "#" + id ).val( icon );
                        \$( "#" + id + "_icon_preview" ).attr( "src", '${admin_link}addons/uk-icons/icons/'+icon+'.svg' );

                        // close modal
                        modal_after_close();
                    };

                    var modal_before_open = function() {
                        var \$this = \$( this.st.el );

                        window.UKIcons = {
                            callBack: function( icon ) {
                                choose_icon( \$this, icon );
                            }
                        };
                    };

                    var modal_after_close = function() {
                        window.UKIcons = null;
                        \$.magnificPopup.close();
                    };

                    COUCH.uk_icons_bind_popup_iframe = function( btn ) {
                        COUCH.bindPopupIframe( btn, modal_before_open, modal_after_close, "mosaic-iframe" );
                    }
                    COUCH.uk_icons_close_modal = modal_after_close;

                    COUCH.uk_icons_bind_popup_iframe( COUCH.el.\$content.find( ".icon-popup-iframe" ) );
                });
EOS;
                $FUNCS->add_js( $js );

                $done=1;
            }
            return $html;
        }

        static function _render_show_icon( $count=0 ){
            global $CTX, $FUNCS;

            $icon = $CTX->get( 'k_page_name' );
            $html = '<img src="'.K_ADMIN_URL.'addons/uk-icons/icons/'.$icon.'.svg"/>';

            return $html;
        }

        static function _render_relation_advanced( $f, $input_name, $input_id, $extra, $dynamic_insertion ){
            global $FUNCS, $CTX, $DB;

            $rows = array();
            $k_option_ids = $CTX->get( 'k_option_ids' );
            if( $k_option_ids!='' ){
                $sql = 'select id, page_name from '.K_TBL_PAGES.' where id in ('.$k_option_ids.') order by page_title';
                $result = @mysql_query( $sql, $DB->conn );
                if( $result ){
                    while( $row=mysql_fetch_row($result) ){
                        $rows[$row[0]] = $row[1];
                    }
                    mysql_free_result( $result );
                }
            }
            $CTX->set( 'k_options', $rows );

            $k_target_link = $CTX->get( 'k_target_link' );
            $k_target_link = str_replace( '?o=relation&q=list/', '?o=relation_icon&q=list/', $k_target_link );
            $CTX->set( 'k_target_link', $k_target_link );

            if( $CTX->get('k_add_js') ){
                $FUNCS->load_css( K_ADMIN_URL.'addons/bootstrap-grid/theme/grid12.css' );
            }
        }

        static function compile_js(){
            global $PAGE, $FUNCS, $DB;
            $icons = array();

            // HOOK: add_uk_icons
            $FUNCS->dispatch_event( 'add_uk_icons', array(&$icons) );
            if( !is_array($icons) ){ $icons = array(); }
 
            $arr = $PAGE->_fields['icons']->items_selected;
            if( is_array($arr) ){
                $str_icon_ids = trim( implode(',', $arr) );

                if( $str_icon_ids!='' ){
                    $sql = 'select page_name from '.K_TBL_PAGES.' where id in ('.$str_icon_ids.')';
                    $result = @mysql_query( $sql, $DB->conn );
                    if( $result ){
                        while( $row=mysql_fetch_row($result) ){
                            $icons[] = $row[0];
                        }
                        mysql_free_result( $result );
                    }
                }
            }
            $icons = array_unique( $icons );
            asort( $icons );
            
            $data = array();
            $uk_icons_src = K_COUCH_DIR.'addons/uk-icons/icons/';
            foreach( $icons as $icon ){
                $icon_file = $uk_icons_src . $icon . '.svg';

                if( ($fp = fopen($icon_file, "rb")) !== false ){
                    $data[$icon] = fread( $fp, filesize($icon_file) );
                    fclose( $fp );
                }
            }
            $data = json_encode( $data );
            $data = <<<EOS
!function(t,i){"object"==typeof exports&&"undefined"!=typeof module?module.exports=i():"function"==typeof define&&define.amd?define("uikiticons",i):(t=t||self).UIkitIcons=i()}(this,function(){"use strict";function i(t){i.installed||t.icon.add($data)}return"undefined"!=typeof window&&window.UIkit&&window.UIkit.use(i),i});
EOS;
            // write
            $js_file = self::js_path.'uikit-icons.min.js';
            $handle = @fopen( $js_file, 'c' );
            if( $handle ){
                if( flock($handle, LOCK_EX) ){
                    ftruncate( $handle, 0 );
                    rewind( $handle );
                    fwrite( $handle, $data );
                    fflush( $handle );
                    flock( $handle, LOCK_UN );
                }
                fclose( $handle );
            }
        }

        // validator
        static function check_compile( $field, $args ){
            global $FUNCS;

            if( !@is_writable(self::js_path) ){
                $error = 'Folder "/'. self::js_folder .'" is not writable';
                return $FUNCS::raise_error( $error );
            }
        }

        static function add_uk_icons( &$icons ){
            $icons = array( 'behance','bolt','check','cog','credit-card','dribbble','facebook','github','heart','instagram','lifesaver','linkedin','location','mail','pinterest','play-circle','quote-left','receiver','star','tumblr','twitter','youtube','chevron-up','chevron-down' );
        }

    } // end class

    // Register
    $FUNCS->register_udf( 'icon', 'KIcon', 1 /*repeatable*/, 0/*searchable*/ );
    $FUNCS->add_event_listener( 'register_renderables', array('KIcon', 'register_renderables') );
    $FUNCS->add_event_listener( 'override_renderables', array('KIcon', 'override_renderables') );
    $FUNCS->add_event_listener( 'add_uk_icons',         array('KIcon', 'add_uk_icons') );

    // routes
    if( defined('K_ADMIN') ){
        $FUNCS->add_event_listener( 'register_admin_routes',  array('KIcon', 'register_routes') );
    }
