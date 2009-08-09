<div id="h1">
    <h1><?php echo PerchLang::get('Pages'); ?></h1>
    <?php echo $help_html; ?>
</div>

<div id="side-panel">
    <h3><span><?php echo PerchLang::get('Help'); ?></span></h3>
    <p>
        <?php echo PerchLang::get("Refresh the database with pages added outside of this app."); ?>
    </p>
</div>

<div id="main-panel">
      
    <form method="post" action="<?php echo PerchUtil::html($Form->action()); ?>" class="sectioned">
        <p><?php echo PerchLang::get('Are you sure you wish to refresh the database?'); ?></p>
        <p class="submit">
            <?php echo $Form->submit('btnsubmit', 'Refresh', 'button'), ' ', PerchLang::get('or'), ' <a href="',PERCH_LOGINPATH . '/apps/perchpages', '">', PerchLang::get('Cancel'), '</a>'; ?>
        </p>
        
    </form>
    
    <div class="clear"></div>
</div>