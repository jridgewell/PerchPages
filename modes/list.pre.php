<?php

    $filter = false;
    if (isset($_GET['by']) && $_GET['by']!='') {
        $filter = $_GET['by'];
    }
    
    switch ($filter) {
        case 'all':
            $contentItems = $PerchPage->get_list();
            $heading = PerchLang::get('All Pages');
            break;
        default:
            $contentItems = $PerchPage->get_list();
            $heading = PerchLang::get('All Pages');
            break;
    }
    
    if (!$filter) $filter = 'all';


    

?>