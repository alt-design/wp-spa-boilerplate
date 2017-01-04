<?php
/* ---------------------------------
 * Some things we may need for our App
 * --------------------------------- */
?>

<div style="display: none">
    <span id="theme"><?php echo get_template_directory_uri(); ?></span>
    <span id="url"><?php echo blogInfo('url') ?>/</span>
    <span id="pageId"><?php the_id() ?></span>
    <span id="tagLine"><?php echo blogInfo('description'); ?></span>
    <span id="name"><?php echo blogInfo('name'); ?></span>
</div>