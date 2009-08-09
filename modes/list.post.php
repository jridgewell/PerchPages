<div id="h1">
    <h1><?php echo PerchLang::get('Pages'); ?></h1>
    <?php echo $help_html; ?>
</div>

<div id="side-panel">
    <h3 class="em"><span><?php echo PerchLang::get('About this App'); ?></span></h3>
    <p>
        <?php echo PerchLang::get("This is a beta app to allow the creation and simple management of pages on your server."); ?>
    </p>
    <h4><?php echo PerchLang::get('Missing Pages?'); ?></h4>
    <p>
        <?php echo PerchLang::get("If you've added pages without using this app, then this list could be out of date! Click ") . '<a href="'.PERCH_LOGINPATH.'/apps/perchpages/refresh">' . PerchLang::get("here") . '</a>' . PerchLang::get(" to refresh the list."); ?>
    </p>
</div>

<div id="main-panel">
    
    <?php echo $Alert->output(); ?>
    
    <?php
    if (PerchUtil::count($contentItems) > 0) {
    ?>
    <table class="d">
        <thead>
            <tr>
                <th class="first"><?php echo PerchLang::get('Alias'); ?></th>
                <th><?php echo PerchLang::get('Location'); ?></th>
                <th><?php echo PerchLang::get('Template'); ?></th>
                <th class="action last"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (PerchUtil::count($contentItems) > 0) {
                $prev = false;
                $prev_url = false;
                $level = 0;
                foreach($contentItems as $item) {
                    echo '<tr class="'.PerchUtil::flip('odd').'">';
                        echo '<td class="level'.$level.' page"><span>' . PerchUtil::html(PerchUtil::filename($item->Alias(), false)) . '</span></td>';
                        echo '<td>' . PerchUtil::html($item->Location()) . '</td>';       
                        echo '<td>' . PerchUtil::html($PerchPage->template_display_name($item->Template())) . '</td>';
                        echo '<td>';
                        if ($CurrentUser->userRole() == 'Admin' || ($CurrentUser->userRole() == 'Editor' && $Settings->get('editorMayDeleteRegions')->settingValue())) {
                            echo '<a href="delete?id=' . PerchUtil::html($item->id()) . '" class="delete">'.PerchLang::get('Delete').'</a>';
                        }else{
                            echo '&nbsp;';
                        }
                        echo '</td>';
                    echo '</tr>';
                }
            }
        
        ?>
        </tbody>
		<tfoot>
			<tr>
				<td>
					<a href="add?id=<?php
						echo PerchUtil::count($contentItems) + 1;
					?>"><span class="new">Add new page</span></a>
				</td>
			</tr>
		</tfoot>
    </table>
    <?php
    }else{
    ?>
        <div class="info-panel">
        <?php if ($filter == 'all') { ?>
            <h2><?php echo PerchLang::get('No pages yet?'); ?></h2>
            <p><?php echo PerchLang::get('If this is the first time you\'ve used this app, try hitting the refresh link on the side.'); ?></p>
        <?php 
            } else {
        ?>
            <p class="alert-notice"><?php echo PerchLang::get('Sorry, there\'s currently no pages available based on that filter'); ?> - <a href="?by=all"><?php echo PerchLang::get('View all'); ?></a></p>
        <?php
            }
        ?>
		<table class="d"><tbody><tr><td>
		<a href="add?id=<?php
			echo PerchUtil::count($contentItems) + 1;
		?>"><span class="new">Add new page</span></a>
		</td></tr></tbody></table>
        </div>
    <?php    
    }
    ?>
    <div class="clear"></div>
</div>