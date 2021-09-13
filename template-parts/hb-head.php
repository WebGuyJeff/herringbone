<?php
/**
 * Template part for custom head meta
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

function enforceFSlash( $url ) {
    if (substr($url, -1) !== '/') {
        $url = $url . '/';
    }
    return $url;
}

/***** SITE-WIDE META *****/ ?>

<!-- hb_head start -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Site verification -->
	<meta name="google-site-verification" content="g9mEcBrJ4uTyVj7KYmGbbuAzqRkeMA2jIJth4hM5Dns" />
	<meta name="msvalidate.01" content="0245B24FF2B31489A65C5541B284D4D8" />
<!-- Favicon and Web App Definitions -->
	<meta name="application-name" content="Jefferson Real - Web Development">
	<meta name="msapplication-TileColor" content="#fff">
	<meta name="msapplication-TileImage" content="/imagery/favicon/mstile-144x144.png">
	<meta name="msapplication-square70x70logo" content="/imagery/favicon/mstile-70x70.png">
	<meta name="msapplication-square150x150logo" content="/imagery/favicon/mstile-150x150.png">
	<meta name="msapplication-wide310x150logo" content="/imagery/favicon/mstile-310x150.png">
	<meta name="msapplication-square310x310logo" content="/imagery/favicon/mstile-310x310.png">
<!-- Mobile Browser Colours -->
<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#262422">
<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#262422">
<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="#262422">
<!-- Favicons and vendor-specific icons -->
	<link rel="shortcut icon" href="/imagery/favicon/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="57x57" href="/imagery/favicon/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/imagery/favicon/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/imagery/favicon/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/imagery/favicon/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/imagery/favicon/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/imagery/favicon/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/imagery/favicon/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/imagery/favicon/apple-touch-icon-152x152.png">
	<link rel="icon" type="image/png" href="/imagery/favicon/favicon-196x196.png" sizes="196x196">
	<link rel="icon" type="image/png" href="/imagery/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/imagery/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/imagery/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/imagery/favicon/favicon-128.png" sizes="128x128">

<?php /***** PER-PAGE META *****/

/* Source from global settings */
$hb_seo_globalauthor    = 'Jefferson Real';
$hb_seo_oglocalealt     = 'en_US';
$hb_seo_ogtype          = 'website';
$hb_seo_robots          = 'index, follow, nocache, noarchive';

/* Sitewide */
$hb_seo_sitetitle       = esc_html( get_bloginfo( 'name', 'display' ) );
$hb_seo_sitedesc        = esc_html( get_bloginfo( 'description', 'display' ) );
$hb_seo_siteurl         = esc_url( home_url( $path = '/', $scheme = 'https' ) );

/* Page-Specific */
$hb_seo_pagetitle       = esc_html( get_the_title() );
$hb_seo_pagedesc        = preg_split('/[.?!]/', esc_html( get_post_field( 'post_content', '' ) ) )[0];
$hb_seo_archivetitle    = esc_html( post_type_archive_title( '', false ) );
$hb_seo_desc            = esc_html( get_bloginfo( 'description', 'display' ) );
$hb_seo_author          = esc_html( get_the_author() );
$hb_seo_sitelogo        = enforceFSlash( esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) ) );
$hb_seo_permalink       = enforceFSlash( esc_url( get_permalink() ) );
$hb_seo_ogtitle         = esc_html( get_the_title() );
//$hb_seo_ogimage         = enforceFSlash( esc_url( wp_get_attachment_url(get_post_thumbnail_id(get_the_ID() ) ) ) );
$hb_seo_oglocale        = esc_html( bloginfo( 'language' ) );
$hb_seo_oglocalealt     = $hb_seo_oglocalealt;
$hb_seo_ogdesc          = $hb_seo_pagedesc;
$hb_seo_ogsitename      = $hb_seo_sitetitle;
$hb_seo_ogtype          = $hb_seo_ogtype;

if ( is_home() ) {
    $hb_seo_title   = ucwords( $hb_seo_sitetitle );
    $hb_seo_desc    = ucwords( $hb_seo_sitedesc );
    $hb_seo_author  = ucwords( $hb_seo_globalauthor );
    $hb_seo_canon   = $hb_seo_siteurl;
    $hb_seo_ogimage = $hb_seo_sitelogo;
} elseif ( is_archive() ) {
	$hb_seo_title   = ucwords( $hb_seo_pagetitle );
    $hb_seo_desc    = ucwords( $hb_seo_pagedesc );
	$hb_seo_author  = ucwords( $hb_seo_globalauthor );
    $hb_seo_canon   = $hb_seo_permalink;
    $hb_seo_ogimage = $hb_seo_sitelogo;
} elseif ( is_singular() ) {
	$hb_seo_title   = ucwords( $hb_seo_pagetitle );
    $hb_seo_desc    = ucwords( $hb_seo_pagedesc );
    $hb_seo_author  = ucwords( $hb_seo_author );
	$hb_seo_canon   = $hb_seo_permalink;
} else {
    echo '<!-- META FALLBACK - CHECK HB-SEO TEMPLATE FUNCTIONS -->';
    $hb_seo_title   = ucwords( $hb_seo_sitetitle );
    $hb_seo_desc    = ucwords( $hb_seo_sitedesc );
    $hb_seo_author  = ucwords( $hb_seo_globalauthor );
    $hb_seo_canon   = $hb_seo_siteurl;
    $hb_seo_ogimage = $hb_seo_sitelogo;
}

?>
<!-- SEO Meta -->
	<title><?php echo $hb_seo_title; ?></title>
	<meta name="author" content="<?php echo $hb_seo_author; ?>">
	<meta name="description" content="<?php echo $hb_seo_desc; ?>">
	<link rel="canonical" href="<?php echo $hb_seo_canon; ?>">
	<meta name="robots" content="<?php echo $hb_seo_robots; ?>">
<!-- Open Graph / Facebook Meta - for og:type the <html> namespace must match-->
	<meta property="og:title" content="<?php echo $hb_seo_title; ?>">
	<meta property="og:type" content="<?php echo $hb_seo_ogtype; ?>">
	<meta property="og:image" content="<?php echo $hb_seo_ogimage; ?>">
	<meta property="og:url" content="<?php echo $hb_seo_canon; ?>">
	<meta property="og:locale" content="<?php echo $hb_seo_oglocale; ?>">
	<meta property="og:locale:alternate" content="<?php echo $hb_seo_oglocalealt; ?>">
	<meta property="og:description" content="<?php echo $hb_seo_desc; ?>">
	<meta property="og:site_name" content="<?php echo $hb_seo_ogsitename; ?>">
<!-- hb_head end -->

<?php echo '<!--' . 'TEST: ' . get_the_ID() . '-->'; ?>