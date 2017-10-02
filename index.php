<?php
/**
 * This theme has to write a HTML file (webpackTemp.html) for the WebPack dev server to run from,
 * hence the ob_start and file writing. Should any of your .php files change, the dev server will reload
 * and the below code will write to a HTML file again.
 */

ob_start();
?>

    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
    <?php require('afterBody.php') ?>

    <main id="app"></main>

    <?php wp_footer(); ?>
    </body>
    </html>

<?php
//This builds the temporary HTML file for WebPack to use. Don't remove this.
$html = fopen(__DIR__ . '/webpackTemp.html', 'w+');
fwrite($html, str_replace('=\'' . get_stylesheet_directory_uri(), '=\'', str_replace('="' . get_stylesheet_directory_uri(), '"', ob_get_contents())));
fclose($html);