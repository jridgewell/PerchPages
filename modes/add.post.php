<div id="h1">
    <h1><?php echo PerchLang::get('Pages'); ?></h1>
    <?php echo $help_html; ?>
</div>

<div id="side-panel">
    <h3><span><?php echo PerchLang::get('Help'); ?></span></h3>
    <p>
        <?php echo PerchLang::get("Add a new page to the selected directory based on the template"); ?>
    </p>
</div>

<div id="main-panel">
      
    <form method="post" action="<?php echo PerchUtil::html($Form->action()); ?>" class="sectioned">
        <p><?php echo PerchLang::get('Please choose a template for the page you wish to add.'); ?></p>
        <fieldset>
            <legend><?php echo PerchUtil::html(PerchLang::get('Choose a Template')); ?></legend>
            
            <div class="field">
                <?php echo $Form->label('fileTemplate', 'Template'); ?>
                <?php
                    $opts = array();
                    $templates = $PerchPage->get_templates();
                   
                    if (is_array($templates)) {
                        foreach($templates as $template) {
                            $opts[] = array('label'=>$template['label'], 'value'=>$template['filename']);
                        }
                    }
                    
                    echo $Form->select('fileTemplate', $opts, $Form->get('fileTemplate', @false));
                ?>
            </div>
        
            <div class="field">
                <?php echo $Form->label('fileAlias', 'Alias'); ?>
                <?php echo $Form->text('fileAlias', 'Home Page'); ?>
            </div>

            <div class="field">
                <?php echo $Form->label('fileDir', 'Directory'); ?>
                <?php
                    $opts = array();
                    $opts = $PerchPage->list_writableDirs();
                   
                    echo $Form->select('fileDir', $opts, $Form->get('fileDir', @false));
                ?>
            </div>

            <div class="field">
                <?php echo $Form->label('fileName', 'File Name'); ?>
                <?php echo $Form->text('fileName', 'blah'); ?>
                <?php echo $Form->select('fileNameExt', $fileNameExts, $Form->get('fileNameExt', @false)); ?>
            </div>
        
        </fieldset>
        <p class="submit">
            <?php echo $Form->submit('btnsubmit', 'Add', 'button'), ' ', PerchLang::get('or'), ' <a href="',PERCH_LOGINPATH . '/apps/perchpages', '">', PerchLang::get('Cancel'), '</a>'; ?>
        </p>
        
    </form>
    
    <div class="clear"></div>
</div>