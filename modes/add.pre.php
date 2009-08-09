<?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = (int) $_GET['id'];
		$count = PerchUtil::count($PerchPage->get_list()) + 1;
    }

    
    if ($id !== $count) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages');
    }

    // Check permission to add
    if ($CurrentUser->userRole() == 'Editor' && !$Settings->get('editorMayDeleteRegions')->settingValue()) {
        PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages');
    }

    /* --------- Add Form ----------- */
    
    $Form = new PerchForm('add');
	$req = array();
	$req['fileTemplate'] = 'Required';
	$req['fileAlias'] = 'Required';
	$req['fileDir'] = 'Required';
	$req['fileName'] = 'Required';
	$req['fileNameExt'] = 'Required';
	$Form->set_required($req);

	$Form->posted = $Form->find_items('file');


    $fileNameExts = array(
		array('label'=>'.php', 'value'=>'php'),
		array('label'=>'.html', 'value'=>'html'),
		array('label'=>'.htm', 'value'=>'htm')
	);

    if ($Form->posted() && $Form->validate()) {
		$Form->posted['Location'] = $Form->posted['Dir'] . '/' . $Form->posted['Name'] . '.' . $Form->posted['NameExt'];
		unset($Form->posted['Dir'], $Form->posted['Name'], $Form->posted['NameExt']);
		
		if (!$PerchPage->copy_template($Form->posted['Template'], $Form->posted['Location'])) {
	    	PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?failure=add');
			return false;
		}
		$Form->posted['Location'] = str_replace($PerchPage->root, '', $Form->posted['Location']);
		$PerchPage->add($Form->posted);
    	PerchUtil::redirect(PERCH_LOGINPATH . '/apps/perchpages/?success=add');
    }

    

?>