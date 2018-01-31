<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php echo get_bloginfo( 'charset' ); ?>">
    <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
    <script class="elebee-vars">
      var elebee = {
        websiteName: '<?php bloginfo( 'name' ); ?>',
        websiteUrl: '<?php echo esc_url( get_site_url() ); ?>',
        //themeUrl: '<?php //echo ThemeUrl; ?>//',
        isSearch: <?php echo number_format( is_search() ); ?>,
        isMobile: <?php echo number_format( wp_is_mobile() ); ?>,
        debug: <?php echo number_format( WP_DEBUG ); ?>
      };
    </script>

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script type="text/javascript">
        window.location = "http://whatbrowser.org/intl/de/";
    </script>
    <![endif]-->
</head>
<body <?php body_class( 'no-js' ); ?>>
<script>
  jQuery('body').removeClass('no-js');
</script>