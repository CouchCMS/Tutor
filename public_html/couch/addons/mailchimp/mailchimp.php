<?php
    if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly

    class KMailChimp{

        var $config = array();
        var $mailchimp;

        function __construct( $api_key='', $list_id='', $debug=0 ){
            global $FUNCS;

            $this->_populate_config( $api_key, $list_id, $debug );

            require_once( K_COUCH_DIR.'addons/mailchimp/lib/MailChimp.php' );
            $this->mailchimp = new \DrewM\MailChimp\MailChimp( $this->config['api_key'] ); // throws exception if invalid
        }

        function _populate_config( $api_key, $list_id, $debug ){
            $cfg = array();
            if( file_exists(K_COUCH_DIR.'addons/mailchimp/config.php') ){
                require_once( K_COUCH_DIR.'addons/mailchimp/config.php' );
            }

            $this->config = array_map( "trim", $cfg );
            unset( $cfg );

            $api_key = trim( $api_key );
            if( $api_key!='' ){ $this->config['api_key']=$api_key; }

            $list_id = trim( $list_id );
            if( $list_id!='' ){ $this->config['list_id']=$list_id; }

            if( $debug ){ $this->config['debug']=$debug; }
        }

        function subscribe( $email, $double_opt=0, $update_existing=0, $merge_fields=array(), $tags=array() ){
            global $FUNCS;

            $email = trim( $email );
            if( $email=='' ){ throw new Exception( 'Email is required' ); }
            $status = ( $double_opt ) ? 'pending' : 'subscribed';
            if( !is_array($merge_fields) ){ $merge_fields=array(); }
            if( !is_array($tags) ){ $tags=array(); }

            $fields = array();
            $fields['email_address']=$email;
            $fields['status']=$status;
            if( count($merge_fields) ){
                $fields['merge_fields']=$merge_fields;
            }
            if( count($tags) ){
                $fields['tags']=$tags;
            }

            // check if email already exists ..
            $subscriber = $this->_get_subscriber( $email );
            if( $subscriber ){
                $existing_status = $subscriber['status'];

                if( $existing_status=='subscribed' ){
                    if( !$update_existing ){
                        throw new Exception( 'Email already subscribed' );
                    }
                    if( $status=='pending' ){ $status = $fields['status'] = 'subscribed'; }
                }
                elseif( $existing_status=='pending' ){
                    if( $status=='pending' ){
                        // double-optin.. if current status is already 'pending', making it pending again will not send the comfirmation email.
                        // Therefore, first change the status to 'unsubscribed'
                        $this->_update( $email, array('status'=>'unsubscribed') );
                    }
                }

                // update
                $this->_update( $email, $fields, $subscriber );
            }
            else{
                // create
                $this->mailchimp->post( "lists/".$this->config['list_id']."/members", $fields );
            }

            if( !$this->mailchimp->success() ){
                if( $this->config['debug'] ){
                    $FUNCS->log( var_export($this->mailchimp->getLastRequest(), true) );
                    $FUNCS->log( var_export($this->mailchimp->getLastResponse(), true) );
                }

                throw new Exception( $this->mailchimp->getLastError() );
            }
        }

        function _get_subscriber( $email ){
            $mc = $this->mailchimp;
            $subscriber_hash = $mc::subscriberHash( $email );

            $rs = $this->mailchimp->get( "lists/".$this->config['list_id']."/members/$subscriber_hash" );
            return ( $this->mailchimp->success() ) ? $rs : false;
        }

        function _update( $email, $fields, $existing_subscriber=null ){
            $mc = $this->mailchimp;
            $subscriber_hash = $mc::subscriberHash( $email );

            $this->mailchimp->patch( "lists/".$this->config['list_id']."/members/$subscriber_hash", $fields );

            // update above does not update the tags. This needs to be done as a separate step
            if( $this->mailchimp->success() && array_key_exists('tags', $fields) ){
                $new_tags = $fields['tags'];
                $existing_tags = array();
                if( $existing_subscriber && array_key_exists('tags', $existing_subscriber) && is_array($existing_subscriber['tags']) ){
                    foreach( $existing_subscriber['tags'] as $tag ){
                        $existing_tags[] = $tag['name'];
                    }
                }
                $tags = array_unique( array_merge($existing_tags, $new_tags), SORT_REGULAR );

                // the tag field requires each item of the array to be an array itself with 'status' specified
                $tmp = array();
                foreach( $tags as $tag ){
                    $tmp[] = array( 'name'=>$tag,'status'=>'active' );
                }
                $fields = array( 'tags'=>$tmp );

                $this->mailchimp->post( "lists/".$this->config['list_id']."/members/$subscriber_hash/tags", $fields );
            }
        }

        // Handles '<cms:mailchimp_subscribe>' tag
        static function mailchimp_subscribe_handler( $params, $node ){
            global $FUNCS, $CTX;
            if( count($node->children) ){die( "ERROR: Tag \"".$node->name."\" is a self closing tag" );}

            extract( $FUNCS->get_named_vars(
                        array(
                            'email'=>'',
                            'first_name'=>'',
                            'last_name'=>'',
                            'api_key'=>'', /* if empty, taken from config */
                            'list_id'=>'', /* -do- */
                            'double_opt'=>'0',
                            'update_existing'=>'0',
                            'merge_fields'=>'',  /* array */
                            'tags'=>'', /* array or a comma-separated string */
                            'debug'=>'0',
                            'echo_error'=>'0',
                            ),
                        $params)
                    );
            $email = trim( $email );
            if( !$email ){
                die( "ERROR: Tag \"".$node->name."\": 'email' is required" );
            }
            $first_name = trim( $first_name );
            $last_name = trim( $last_name );
            $api_key = trim( $api_key );
            $list_id = trim( $list_id );
            $double_opt = ( $double_opt==1 ) ? 1 : 0;
            $update_existing = ( $update_existing==1 ) ? 1 : 0;
            $merge_fields = ( is_array($merge_fields) ) ? $merge_fields : array();
            {
                if( $first_name!='' ){ $merge_fields['FNAME'] = $first_name; }
                if( $last_name!='' ){ $merge_fields['LNAME'] = $last_name; }
            }
            if( !is_array($tags) ){
                $sep = ',';
                $tags = array_unique( array_filter(array_map( function($item)use($sep){
                            return trim( str_replace( '\\'.$sep, $sep, $item ) ); //unescape separator
                        }, preg_split( "/(?<!\\\)".preg_quote($sep, '/')."/", $tags ))) );
            }

            $debug = ( $debug==1 ) ? 1 : 0;
            $echo_error = ( $echo_error==1 ) ? 1 : 0;

            $html='';
            try{
                $mc = new KMailChimp( $api_key, $list_id, $debug );
                $mc->subscribe( $email, $double_opt, $update_existing, $merge_fields, $tags );
            }
            catch( Exception $e ){
                $str_err = $e->getMessage();

                if( $echo_error ){
                    $html = $str_err;
                }
                else{
                    $CTX->set( 'k_success', '' );
                    $CTX->set( 'k_error', $str_err );
                }
            }

            return $html;
        }

    }// end class

    $FUNCS->register_tag( 'mailchimp_subscribe', array('KMailChimp', 'mailchimp_subscribe_handler'), 0, 0 );
