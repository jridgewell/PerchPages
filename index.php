<?php
    include(dirname(__FILE__) . '/../../config/config.php');
    include(PERCH_PATH . '/inc/loader.php');
    $Perch  = PerchAdmin::fetch();
    include(PERCH_PATH . '/inc/auth.php');

    $Alert = new PerchAlert;
	if ( isset($_GET['success']) && !empty($_GET['success']) ) {
		$message = '';
		switch ($_GET['success']) {
			case 'add':
				$message = 'Successfully added a new page!';
				break;
			case 'delete':
				$message = 'Successfully deleted that page!';
				break;
			case 'refresh':
				$message = 'All pages refreshed!';
				break;

			default:
				$message = false;
		}
		if ($message) {
			$Alert->set('success', PerchLang::get($message));
		}
	}
	if ( isset($_GET['failure']) && !empty($_GET['failure']) ) {
		$message = '';
		switch ($_GET['failure']) {
			case 'add':
				$message = 'There was a problem creating the new page, try checking file permissions... ';
				break;
			case 'delete':
				$message = 'There was a problem deleting that page, try checking file permissions...';
				break;
			case 'refresh':
				$message = 'We didn\'t find any new pages...';
				break;
			
			default:
				$message = false;
		}
		if ($message) {
			$Alert->set('failure', PerchLang::get($message));
		}
	}

    $Perch->find_installed_apps();
    
    $Perch->page_title = PerchLang::get('Manage Pages');
    
    include('PerchPages.class.php');
    include('PerchPagesItem.class.php');
    
    $PerchPage = new PerchPage;
	$PerchPage->test_mysql();
    
    include('modes/list.pre.php');
    
    include(PERCH_PATH . '/inc/top.php');

    include('modes/list.post.php');

    include(PERCH_PATH . '/inc/btm.php');
?>