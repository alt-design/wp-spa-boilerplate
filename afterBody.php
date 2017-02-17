<?php
/**
 * Some things we may need for our App to be included after the opening body tag
 */
?>

<div style="display:none;">
    <span id="url"><?php echo blogInfo('url') ?></span>
    <span id="a-url"><?php echo get_admin_url() ?></span>
    <span id="pageId"><?php the_id() ?></span>
    <span id="name"><?php echo blogInfo('name'); ?></span>
    <span id="theme"><?php echo get_stylesheet_directory_uri(); ?></span>
</div>
