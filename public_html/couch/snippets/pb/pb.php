<?php
    if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly
    define( 'K_HIDE_PB_BLOCKS', '1' );

    // add new sidebar menu items
    if( defined('K_ADMIN') ){
        $FUNCS->add_event_listener( 'register_admin_menuitems', function(){
            global $FUNCS;

            $FUNCS->register_admin_menuitem( array('name'=>'globals', 'title'=>'Globals', 'is_header'=>'1', 'weight'=>'1')  );
            $FUNCS->register_admin_menuitem( array('name'=>'blocks', 'title'=>'Source Blocks', 'is_header'=>'1', 'weight'=>'2')  );
        });

        $FUNCS->add_event_listener( 'alter_admin_menuitems', function(&$items){
            global $FUNCS, $DB, $AUTH;

            if( array_key_exists('_templates_', $items) ){
                $items['_templates_']['title'] = 'Site';
            }

            if( array_key_exists('_modules_', $items) ){
                $items['_modules_']['weight']=100; // move administration group further down
            }

            // hide all block source templates ..
            if( $AUTH->user->access_level != 10 || ($AUTH->user->access_level == 10 && K_HIDE_PB_BLOCKS) ){
                $tpls = array( 
                    'blocks',
                    'blocks/about.php', 
                    'blocks/clients.php', 
                    'blocks/contact.php', 
                    'blocks/contents.php', 
                    'blocks/counters.php', 
                    'blocks/covers.php', 
                    'blocks/cta.php', 
                    'blocks/details.php', 
                    'blocks/faq.php', 
                    'blocks/features.php', 
                    'blocks/footer.php', 
                    'blocks/gallery.php', 
                    'blocks/intro.php', 
                    'blocks/menu.php', 
                    'blocks/pricing.php', 
                    'blocks/raw_html.php', 
                    'blocks/team.php', 
                    'blocks/testimonials.php', 
                    'blocks/video.php',
                );

                foreach( $tpls as $tpl ){
                    if( array_key_exists($tpl, $items) ){
                        unset( $items[$tpl] );
                    }
                }
            }
        });
    }

    class MyPB{
        static function _render_pb_tile(){
            global $FUNCS, $CTX;

            $tpl_type = $CTX->get( 'k_template_type' );
            if( $tpl_type == 'tile' ){

                $parent_tpl = $CTX->get( 'k_template__parent_tpl' );
                $mosaic = $CTX->get( 'k_template__parent_field' );
                $tile = $CTX->get( 'k_template__tile_name' );

                $tpl = $CTX->get( 'k_template__pb_template' ); // the template to render

                self::_set_context( $parent_tpl, $mosaic, $tile, $tpl );

                $tpl = trim( $tpl );
                if( $tpl!='' ){
                    return array( $tpl );
                }
            }
        }

        static function _render_pb_wrapper( $context=null ){
            global $CTX;

        }

        // use this to set tile-specific context..
        static function _set_context( $parent_tpl, $mosaic, $tile, &$tpl ){
            global $FUNCS, $CTX;

            $CTX->set( 'pb_menu_requires_div', '', 'global' );

            if( $parent_tpl=='blocks/menu.php' ){
                self::_set_menu_context();
            }
            else{ // rest

                // section settings
                {
                    $section_id = trim( $CTX->get('section_id') );
                    if( $section_id=='' ){ $section_id = 'section-'.$CTX->get('k_page_id'); };
                    $CTX->set( 'section_id', $section_id );
                    $CTX->set( 'section_class', trim( $CTX->get('section_class') ) );

                    // padding
                    {
                        $padding = '';
                        $padding_top = $CTX->get( 'section_padding_top' );
                        if( $padding_top ){
                            $padding_bottom = $CTX->get( 'section_padding_bottom' );
                            if( $padding_top !== $padding_bottom ){
                                $padding_top = ( $padding_top=='no_padding' ) ? 'uk-padding-remove-top' : 'uk-section-top-'.$padding_top;
                                $padding_bottom = ( $padding_bottom=='no_padding' ) ? 'uk-padding-remove-bottom' : 'uk-section-bottom-'.$padding_bottom;
                                $padding = $padding_top.' '.$padding_bottom;
                            }
                            else{
                                if( $padding_top == 'no_padding' ){
                                    $padding = 'uk-padding-remove-vertical';
                                }
                                elseif( $padding_top != 'medium' ){
                                    $padding = 'uk-section-'.$padding_top;
                                }
                            }
                        }
                        $CTX->set( 'pb_section_padding', $padding );
                    }

                    // background color
                    {
                        $bg_color = '';
                        $section_bg_color = $CTX->get( 'section_bg_color' );
                        if( $section_bg_color ){
                            $bg_color = 'uk-background-'.$section_bg_color;
                            if( self::_is_dark($section_bg_color) ){
                                $bg_color .= ' uk-light';
                            }
                        }
                        $CTX->set( 'pb_section_bg_color', $bg_color );
                    }

                    // second column width
                    {
                        $column_width = '';
                        $second_column_width = $CTX->get( 'second_column_width' );
                        if( $second_column_width ){
                            $column_width = 'uk-width-'.$second_column_width.'@m';
                        }
                        $CTX->set( 'pb_second_column_width', $column_width );
                    }
                }

                // title

                // body
                $body = $CTX->get( 'body' );
                if( $body ){
                    $body = self::_nl2p( $body );
                    $CTX->set( 'body', $body );
                }

                // form dropdown
                $dropdown_options = $CTX->get( 'field_dropdown_options' );
                if( $dropdown_options ){
                    $dropdown_placeholder = $CTX->get( 'field_dropdown_placeholder' );
                    $dropdown_placeholder = str_replace( array("|","="), array("\\|","\\="), $dropdown_placeholder );

                    $dropdown_options = str_replace( "|", "\\|", $dropdown_options );
                    $dropdown_options = str_replace( ",", "|", $dropdown_options );
                    $CTX->set( 'field_dropdown_options', $dropdown_placeholder.'=-|'.$dropdown_options );
                }

                // map
                $map_address = $CTX->get( 'map_address' );
                if( $map_address ){
                    $map_link='';
                    $map_api_key = trim( $CTX->get('map_api_key') );
                    if( $map_api_key ){
                        $map_address = urlencode( trim($map_address) );
                        $map_latitude = trim( $CTX->get('map_latitude') );
                        $map_longitude = trim( $CTX->get('map_longitude') );
                        $map_link = "https://www.google.com/maps/embed/v1/place?key=".$map_api_key."&amp;q=".$map_address;
                        if( strlen($map_longitude) && strlen($map_latitude) ){
                            $map_link .= "&amp;center=".$map_latitude.",".$map_longitude;
                        }
                    }
                    $CTX->set( 'map_link', $map_link );
                }
            }
        }

        static function _set_menu_context(){
            global $FUNCS, $CTX;

            // background color
            {
                $str_bg_color = $str_bg_color_mobile = '';
                $menu_background = $CTX->get( 'menu_background' );
                $menu_background_is_dark = self::_is_dark( $menu_background );

                if( $menu_background && $menu_background!='default' ){
                    $str_bg_color = $str_bg_color_mobile = 'el-background-'.$menu_background; // muted, primary, secondary
                }
                if( $menu_background_is_dark ){
                    $str_bg_color_mobile .= ' uk-light';
                }
                $CTX->set( 'pb_menu_bg_color_mobile', $str_bg_color_mobile );

                // menu dropdowns
                $menu_dropdown_background = $CTX->get( 'menu_dropdown_background' );
                $menu_dropdown_is_dark = self::_is_dark( $menu_dropdown_background );

                if( $menu_dropdown_background && $menu_dropdown_background!='default' ){
                    $menu_dropdown_background = 'el-background-'.$menu_dropdown_background; // muted, primary, secondary
                }
                $CTX->set( 'pb_menu_dropdown_background', $menu_dropdown_background );
                $CTX->set( 'pb_menu_dropdown_is_dark', $menu_dropdown_is_dark ? 'uk-light' : '' );
            }

            // sticky
            {
                $header = array();
                $str_sticky = $str_transparent = '';
                $menu_overlaps_first_section = $CTX->get( 'menu_overlaps_first_section' );
                $menu_is_sticky = $CTX->get( 'menu_is_sticky' );

                if( $menu_is_sticky != 'never' ){
                    $menu_shrink_on_sticky = $CTX->get( 'menu_shrink_on_sticky' );
                    $menu_start_as_transparent = $CTX->get( 'menu_start_as_transparent' );

                    $str_sticky = 'sel-target: .uk-navbar-container;';
                    $str_sticky .= 'cls-active: uk-navbar-sticky';
                    $str_sticky .= ( $menu_start_as_transparent && $menu_background_is_dark ) ? ' uk-light;' : ';';

                    if( $menu_start_as_transparent ){
                        $menu_sticky_background_is_dark = $CTX->get( 'menu_sticky_background_is_dark' );

                        $str_sticky .= 'cls-inactive: uk-navbar-transparent';
                        $str_sticky .= ( $menu_sticky_background_is_dark ) ? ' uk-light;' : ';';

                        $str_transparent = 'uk-navbar-transparent';
                        if( $menu_sticky_background_is_dark ){
                            $str_bg_color .= ' uk-light';
                        }
                        $menu_overlaps_first_section = 1;

                        $CTX->set( 'pb_menu_requires_div', ($menu_sticky_background_is_dark) ? 'dark' : 'light', 'global' );
                    }

                    if( $menu_is_sticky != 'always' ){
                        $str_sticky .= 'animation: uk-animation-slide-top;';

                        if( $menu_is_sticky=='on_scroll_up' ){
                            $str_sticky .= 'show-on-up: true;';
                        }
                        elseif( $menu_is_sticky=='on_scroll_down' ){
                            $str_sticky .= 'top: 200;';
                        }
                    }
                }
                if( $menu_overlaps_first_section ){ $header[] = 'el-header-overlay'; }
                if( $menu_shrink_on_sticky ){ $header[] = 'el-header-shrinks'; }
                if( !$menu_start_as_transparent ){
                    if( $menu_background_is_dark ){
                        $str_bg_color .= ' uk-light';
                    }
                }

                $CTX->set( 'pb_menu_bg_color', $str_bg_color );
                $CTX->set( 'pb_menu_header', implode(' ', $header) );
                $CTX->set( 'pb_menu_transparent', $str_transparent );
                $CTX->set( 'pb_menu_sticky', $str_sticky );
            }

            // width
            {
                $str_menu_width = '';
                $menu_width = $CTX->get( 'menu_width' );
                if( $menu_width != 'default' ){
                    if( $menu_width == 'no_padding' ){
                        $str_menu_width = 'uk-container-expand uk-padding-remove-horizontal';
                    }
                    else{
                        $str_menu_width = 'uk-container-'.$menu_width;
                    }
                }
                $CTX->set( 'pb_menu_width', $str_menu_width );
            }

            // logo
            {
                $menu_logo_link = trim( $CTX->get('menu_logo_link') );
                if( $menu_logo_link=='' ){ $menu_logo_link = $CTX->get( 'k_site_link' ); }
                $CTX->set( 'menu_logo_link', $menu_logo_link );
            }

        }

        // ..adjust accoring to theme!
        static function _is_dark( $color ){
            return ( $color=='primary' || $color=='secondary' ) ? 1 : 0;
        }

        static function _rr_alter_ctx_pb_icon_blocks( $params ){
            global $CTX;

            // body
            {
                $body = $CTX->get( 'item_body' );
                if( $body ){
                    $body = self::_nl2p( $body );
                    $CTX->set( 'item_body', $body );
                }
            }

            // list
            {
                $list = trim( $CTX->get('item_list') );

                $arr_items = array();
                if( strlen($list) ){
                    $list = nl2br( $list, false );
                    $arr_items = array_filter( array_map("trim", preg_split( '/(?:<br>\s*){2,}/', $list)) );
                }

                if( $CTX->get('item_list_show_unavailable') ){
                    $arr_tmp = array();

                    foreach( $arr_items as $_item ){
                        $unavailable = 0;
                        if( $_item[0]=='-' ){ // unavailable items will be prefixed with a '-'
                            $_item = ltrim( substr($_item, 1) );
                            $unavailable = 1;
                        }
                        $arr_tmp[] = array( 'text'=>$_item, 'unavailable'=>$unavailable );
                    }
                    $arr_items = $arr_tmp;
                }

                $CTX->set( 'item_list', $arr_items );
            }

            // social icons
            {
                $list = trim( $CTX->get('item_social') );

                $arr_items = array();
                if( strlen($list) ){
                    $arr_tmp = array_filter( array_map("trim", preg_split('/\r\n|\r|\n/', $list)) );
                    foreach( $arr_tmp as $str_icon ){
                        $pos = strpos( $str_icon, '=' );
                        if( $pos !== false ){
                            $k = trim( substr($str_icon, 0, $pos) );
                            $v = trim( substr($str_icon, $pos+1) );
                            if( $k && $v ){
                                $arr_items[$k]=$v;
                            }
                        }
                    }
                }
                $CTX->set( 'item_social', $arr_items );
            }
        }

        // utility functions
        static function _nl2p( $text ){
            $html = '';
            $text = nl2br( $text, false );

            $arr_lines = array_filter( array_map("trim", preg_split( '/(?:<br>\s*){2,}/', $text)) ); // convert double <br> to <p>
            if( count($arr_lines) ){
                if( count($arr_lines) > 1 ){
                    foreach( $arr_lines as $line ) {
                        $html .= '<p>'.$line.'</p>';
                    }
                }
                else{
                    $html .= $arr_lines[0];
                }
            }

            return $html;
        }

        // validator for progress bar
        static function check_percentage( $field, $args ){
            global $FUNCS;

            $val = trim( $field->get_data() );
            if( !is_numeric($val) || $val < 0 || $val > 100){
                return $FUNCS::raise_error( "Invalid value (should be between 0-100)" );
            }
        }

    } // end class MyPB

    $FUNCS->add_event_listener( 'override_renderables', function(){
        global $FUNCS;

        $FUNCS->override_render( 'pb_tile', array('template_path'=>K_COUCH_DIR.'snippets/pb/', 'template_ctx_setter'=>array('MyPB', '_render_pb_tile')) );
        $FUNCS->override_render( 'pb_wrapper', array('template_path'=>K_COUCH_DIR.'snippets/pb/misc/theme/', 'template_ctx_setter'=>array('MyPB', '_render_pb_wrapper')) );
    });

    $FUNCS->add_event_listener( 'rr_alter_ctx_pb_icon_blocks', array('MyPB', '_rr_alter_ctx_pb_icon_blocks') );

    // tag <cms:nl2p>
    $FUNCS->register_tag( 'nl2p', function($params, $node){
        global $FUNCS;

        // call the children
        foreach( $node->children as $child ){
            $text .= $child->get_HTML();
        }
        $html = MyPB::_nl2p( $text );

        return $html;
    });

    // tag <cms:is_empty_repeatable>
    $FUNCS->register_tag( 'is_empty_repeatable', function($params, $node){
        global $FUNCS, $CTX;
        if( count($node->children) ) {die("ERROR: Tag \"".$node->name."\" is a self closing tag");}

        $var = trim( $params[0]['rhs'] );
        if( $var ){
            // get the data array from CTX
            $obj = &$CTX->get_object( $var );

            if( $obj ){
                $data = $obj['data'];
                if( is_array($obj) && count($data) ){
                    if( count($data)==1 ){// empty repeatable-regions still contain one row.. check it
                        foreach( $data[0] as $v ){
                            if( strlen($v) ){
                                return 0; // not empty
                            }
                        }
                    }
                    else{
                        return 0; // not empty
                    }
                }
            }
        }

        return 1; // empty
    });

    // Pricing UDF
    class MyPageBuilder_Pricing extends KUserDefinedField{
        // Load from database
        function store_data_from_saved( $data ){
            global $FUNCS;

            $this->data = $FUNCS->unserialize( $data );
            if( !is_array($this->data) ) $this->data=array();
            $this->orig_data = $this->data;
        }

        function _render( $input_name, $input_id, $extra='', $dynamic_insertion=0 ){
            global $FUNCS;

            $val_prefix  = $FUNCS->escape_HTML( $this->data['prefix'], ENT_QUOTES, K_CHARSET );
            $val_price   = $FUNCS->escape_HTML( $this->data['price'], ENT_QUOTES, K_CHARSET );
            $val_postfix = $FUNCS->escape_HTML( $this->data['postfix'], ENT_QUOTES, K_CHARSET );
            $val_subtext = $FUNCS->escape_HTML( $this->data['subtext'], ENT_QUOTES, K_CHARSET );

            $html =<<<EOS
            <div id="$input_id" class="row k_row">
                <div class="k_element prefix k_text col-xs-2 col-md-1">
                    <label class="field-label"><span>Prefix</span></label><br>
                    <input type="text" id="${input_id}_name" name="${input_name}[prefix]" value="$val_prefix" size="105" class="text">
                </div>

                <div class="k_element price k_text col-xs-3 col-md-2">
                    <label class="field-label"><span>Price</span></label><br>
                    <input type="text" id="${input_id}_price" name="${input_name}[price]" value="$val_price" size="105" class="text">
                </div>

                <div class="k_element postfix k_text col-xs-3 col-md-2">
                    <label class="field-label"><span>Postfix</span></label><br>
                    <input type="text" id="${input_id}_postfix" name="${input_name}[postfix]" value="$val_postfix" size="105" class="text">
                </div>

                <div class="k_element subtext k_text col-xs-4 col-md-4">
                    <label class="field-label"><span>Subtext</span></label><br>
                    <input type="text" id="${input_id}_subtext" name="${input_name}[subtext]" value="$val_subtext" size="105" class="text">
                </div>
            </div>
EOS;
            return $html;
        }

        // Handle posted data
        function store_posted_changes( $post_val ){
            global $FUNCS;
            if( $this->deleted || $this->k_inactive ) return; // no need to store

            if( !is_array($post_val) ){
                $post_val = $FUNCS->unserialize( $post_val );
            }

            $data = array();
            if( is_array($post_val) ){
                foreach( $post_val as $k=>$v ){
                    $data[$FUNCS->cleanXSS($k)] = $FUNCS->cleanXSS( $v );
                }
            }
            $this->data = $data;
            $this->modified = ( $this->orig_data === $this->data ) ? false : true; // values unchanged
        }

        function validate(){
            return true;
        }

        // Save to database.
        function get_data_to_save(){
            global $FUNCS;

            return $FUNCS->serialize( $this->data );
        }

        // Search value
        function get_search_data(){
            return;
        }

        function get_data( $for_ctx=0 ){
            return $this->data;
        }
    }
    $FUNCS->register_udf( 'pb_pricing', 'MyPageBuilder_Pricing', 1/*repeatable*/ );

    // Email handling
    class MyPageBuilder_Form_Helper extends KUserDefinedField{
        function store_posted_changes( $post_val ){ return; }
        function validate(){ return true; }
        function get_data( $for_ctx=0 ){ return; }
        static $fields = array( 'name', 'email', 'message' );

        // Output available field names to admin panel
        function _render( $input_name, $input_id, $extra1='', $dynamic_insertion=0 ){
            global $FUNCS, $CTX;

            $shortcodes = '[all_fields]';
            foreach( self::$fields as $f ){
                $shortcodes .= '&nbsp;&nbsp;['. $f .']';
            }
            $shortcodes = '<b>'.$shortcodes.'</b>';
            $content = 'In the following fields you may use these shortcodes: <br>' . $shortcodes;

            return $FUNCS->show_alert( ''/*$heading*/, $content, 'info'/*$type*/, $center );
        }

        static function process_form_tag_handler( $params, $node ){
            global $FUNCS, $CTX;

            // expand shortcodes on the frontend..
            $shortcodes = array();
            $handler = array( 'MyPageBuilder_Form_Helper', '_shortcode_handler' );
            $shortcodes['all_fields'] = $handler;
            foreach( self::$fields as $f ){
                $shortcodes[$f] = $handler;
            }

            $orig_handlers = $FUNCS->shortcodes;
            $FUNCS->shortcodes = $shortcodes;

            $arr = array( 'to', 'from', 'subject', 'reply_to', 'bcc', 'message' );
            foreach( $arr as $a ){
                $str = $CTX->get( 'form_email_'.$a );
                if( strpos($str, '[') !== false ){
                    $parser = new KBBParser( $str );
                    $str = $parser->get_HTML();
                    $CTX->set( 'form_email_'.$a, $str );
                }
            }

            $FUNCS->shortcodes = $orig_handlers;

            // set redirect destination ..
            $form_success_action = $CTX->get( 'form_success_action' );
            if( $form_success_action=='show_message' ){
                $dest = $CTX->get( 'k_page_link', 2 );
            }
            else{
                $dest = $CTX->get( 'form_success_redirect' );
            }
            $CTX->set( 'pb_form_link', $dest );
        }

        static function _shortcode_handler( $params, $content, $name ){
            global $CTX;

            $var = ( $name=='all_fields' ) ? 'k_success' : 'frm_'.$name;
            $val = $CTX->get( $var );
            return $val;
        }
    }
    $FUNCS->register_udf( 'pb_list_fields', 'MyPageBuilder_Form_Helper', 0/*repeatable*/ );
    $FUNCS->register_tag( 'pb_process_form', array('MyPageBuilder_Form_Helper', 'process_form_tag_handler') );
