<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="viewport"
            content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script type="text/javascript">
        window.location = "http://whatbrowser.org/intl/de/";
    </script>
    <![endif]-->

    <!--[if IE 9]>
    <style>
        .elementor-popup-modal { display: block !important; }
        .elementor-popup-modal > div { left: 50%; transform: translateX(-50%); }
    </style>
    <![endif]-->
</head>
<body <?php body_class( 'no-js' ); ?>>
<script>
  jQuery('body').removeClass('no-js');
</script>