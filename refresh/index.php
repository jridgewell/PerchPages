<?php
    include(dirname(__FILE__) . '/../../../config/config.php');
    include(PERCH_PATH . '/inc/loader.php');
    $Perch  = PerchAdmin::fetch();
    include(PERCH_PATH . '/inc/auth.php');

    $Perch->find_installed_apps();
    
    $Perch->page_title = PerchLang::get('Refresh Pages');
    
    include(dirname(__FILE__) . '/../PerchPages.class.php');
    include(dirname(__FILE__) . '/../PerchPagesItem.class.php');
    
    $PerchPage = new PerchPage;
    
    include(dirname(__FILE__) . '/../modes/refresh.pre.php');
    
    include(PERCH_PATH . '/inc/top.php');

    include(dirname(__FILE__) . '/../modes/refresh.post.php');

    include(PERCH_PATH . '/inc/btm.php');

?>