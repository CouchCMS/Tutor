<?php

    if ( !defined('K_COUCH_DIR') ) die(); // cannot be loaded directly

    ///////////EDIT BELOW THIS////////////////////////////////////////

    // Names of the templates to use this addon with (use '|' to separate multiple templates) e.g.
    // $cfg['tpls'] = 'products.php | specs.php | users/profile.php';

    $cfg['tpls'] = 'index.php | globals/headers.php | globals/footers.php';

    // Button
    $cfg['btn_text'] = 'Copy to New';
    $cfg['btn_desc'] = 'Copies the current page into a new page';

