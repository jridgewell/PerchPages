<?php
    // Check permission to refresh
    if ($CurrentUser->userRole() == 'Editor' && !$Settings->get('editorMayDeleteRegions')->settingValue()) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages');
    }



    /* --------- Refresh Form ----------- */
    
    $Form = new PerchForm('refresh');
    
    if ($Form->posted() && $Form->validate()) {

		$contentPages = $PerchPage->get_pages('contentPage', 'contentItems');
		$pages = $PerchPage->get_pages('Location', 'pages');
		if (!is_array($contentPages)) {
			$diff = array(); //no pages...
		} elseif (!is_array($pages)) {
			$diff = $contentPages; //all pages...
		} else {
			$diff = array_diff($contentPages, $pages);
		}
		
		if (!empty($diff)) {
			sort($diff);
			foreach ($diff as $value) {
				if (file_exists($PerchPage->root . $value)) {
					$a = array();
					$a['Alias'] = $PerchPage->refresh_display_name($value);
					$a['Location'] = $value;
					$a['Template'] = 'Unknown';
					$PerchPage->add($a);
				}
			}
			PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?success=refresh');
		}
		else {
			PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?failure=refresh');
		}
    }

    

?>