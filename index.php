<?php
// Used for generating the webpack-dev-middleware server HTML
ob_start();
?>

    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo get_the_title() . " | " . get_bloginfo('name'); ?></title>
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

    <?php require('afterBody.php') ?>

    <main id="app"></main>

    <?php wp_footer(); ?>

    </body>

    </html>

<?php


// Open the file
$html = fopen(__DIR__ . '/webpack-temp.html', 'w+');

fwrite($html, str_replace(get_template_directory_uri(), '', ob_get_contents()));

// Close the file
fclose($html);