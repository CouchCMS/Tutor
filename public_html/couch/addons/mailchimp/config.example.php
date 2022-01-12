<?php

	if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly

	// 1. Mailchimp API Key
	$cfg['api_key'] = '';

	// 2. Mailchimp List ID (AKA Audience ID)
	$cfg['list_id'] = '';

	// 3. Debug. If set to '1', will log all debug output in 'log.txt' at site's root (WARNING! Be sure to clear the log file and set debug to 0 once you are done).
    $cfg['debug'] = '0';
