<?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
        $ContentItem = $PerchPage->find($id);
    }

    
    if (!$ContentItem || !is_object($ContentItem)) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages');
    }

    // Check permission to delete
    if ($CurrentUser->userRole() == 'Editor' && !$Settings->get('editorMayDeleteRegions')->settingValue()) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages');
    }



    /* --------- Delete Form ----------- */
    
    $Form = new PerchForm('delete');
    
    if ($Form->posted() && $Form->validate()) {
		$path = $PerchPage->root;
		$file = $path . $ContentItem->Location();
		if (file_exists($file)) {
			if (!unlink($file)) {
				PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?failure=delete');
				return false;
			}
		}
   		$ContentItem->delete();
		PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?success=delete');
    }

    

?>