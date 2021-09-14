<?php
/**
 * Template part for custom head meta.
 * 
 * Note to self: This would be better suited to a function in functions.php or a standalone plugin.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

/**
 * Function enforceFSlash
 * 
 * Append forward slash to strings where not already present, return same value if arg is empty.
 * Serving multiple versions of the same url i.e url.com/ and url.com can lead to cannibalisation.
 * This function serves to ensure trailing slashes are present. This should be controlled by a top-
 * level SEO setting where the site owner can set slashes on or off.
 */
function enforceFSlash( $url ) {
	if ($url !== '' && substr($url, -1) !== '/') {
        $url = $url . '/';
    }
    return $url;
};

/**
 * Function firstNotEmpty
 * 
 * Accepts an array of values and returns the first non-empty value as a string.
 * Returns empty string on failure.
 */
function firstNotEmpty( $array ) {
	$string = '';
	if (is_array( $array )) {
		foreach ( $array as &$value ) {
			$trimmed = trim( $value, " " );
			if ( !empty($trimmed) ) {
				$string = 'pass! ' . $trimmed;
				goto end;
			}
		}
		end:
        unset($value); //Cleanup
		if ( empty($string) ) {
			$string = '';
		}
    }
    return $string;
};

/* Constants (need a source) */
$hb_siteauthor    	= 'Jefferson Real';
$hb_localealt     	= 'en_US';
$hb_objecttype		= 'website';
$hb_robots          = 'index, follow, nocache, noarchive';

/* Sitewide */
$hb_sitetitle       = wp_strip_all_tags( get_bloginfo( 'name', 'display' ) );
$hb_blogtitle		= wp_strip_all_tags( get_the_title( get_option('page_for_posts', true) ) );
$hb_sitedesc        = wp_strip_all_tags( get_bloginfo( 'description', 'display' ) );
$hb_siteurl         = esc_url( home_url( $path = '/', $scheme = 'https' ) );
$hb_sitelogo        = esc_url( wp_get_attachment_url( get_theme_mod( 'custom_logo' ) ) );
$hb_locale			= wp_strip_all_tags( bloginfo( 'language' ) );

/* Page-Specific */
$post = get_post();//Set up the post manually
setup_postdata($post);
$hb_postid = get_the_ID();

//Try on all pages as more vars filled = more fallbacks.
$hb_posttitle       = wp_strip_all_tags( get_the_title() );
$hb_permalink       = esc_url( get_permalink() );

/* Set scope of conditionals */
$hb_catexcerpt		= '';
$hb_archivetitle	= '';
$hb_postexcerpt		= '';
$hb_postauthor		= '';

/* Set conditionals */
if ( is_category() ) { //User may have set desc
	$hb_catexcerpt 		= preg_split('/[.?!]/',  wp_strip_all_tags( category_description(), true ) )[0] . '.';
}
if ( is_archive() ) { //Also matches categories (don't set vars twice)
	$hb_archivetitle	= wp_strip_all_tags( post_type_archive_title( '', false ) );
	$hb_thumbnail       = esc_url( get_the_post_thumbnail_url( $hb_postid ) );
}
if ( is_singular() ) {
	$hb_postexcerpt		= preg_split('/[.?!]/',  wp_strip_all_tags( get_post_field( 'post_content', '' ), true ) )[0] . '.';
	$hb_postauthor      = wp_strip_all_tags( get_the_author() );
	$hb_thumbnail       = esc_url( get_the_post_thumbnail_url( $hb_postid ) );
}

/* Set the conditional hb_seo vars */
if ( is_front_page() ) { //Homepage
    $hb_seo_title   	= ucwords( $hb_sitetitle );
    $hb_seo_desc    	= ucfirst( firstNotEmpty( array( $hb_sitedesc, $hb_postexcerpt ) ) );
    $hb_seo_author  	= ucwords( firstNotEmpty( array( $hb_siteauthor, $hb_postauthor ) ) );
    $hb_seo_canon   	= enforceFSlash( $hb_siteurl );
    $hb_seo_ogimage 	= firstNotEmpty( array( $hb_sitelogo, $hb_thumbnail) );
} elseif ( is_home() ) { //Posts Page
    $hb_seo_title   	= ucwords( firstNotEmpty( array( $hb_blogtitle, $hb_sitetitle ) ) );
    $hb_seo_desc    	= ucfirst( firstNotEmpty( array( $hb_postexcerpt, $hb_sitedesc ) ) );
    $hb_seo_author  	= ucwords( $hb_siteauthor );
    $hb_seo_canon   	= enforceFSlash( $hb_permalink );
    $hb_seo_ogimage 	= firstNotEmpty( array( $hb_thumbnail, $hb_sitelogo ) );
} elseif ( is_category() ) {
	$hb_seo_title   	= ucwords( firstNotEmpty( array( $hb_archivetitle, $hb_posttitle ) ) );
    $hb_seo_desc    	= ucfirst( firstNotEmpty( array( $hb_catexcerpt, $hb_postexcerpt, $hb_sitedesc ) ) );
	$hb_seo_author  	= ucwords( firstNotEmpty( array( $hb_postauthor, $hb_siteauthor ) ) );
    $hb_seo_canon   	= enforceFSlash( $hb_permalink );
    $hb_seo_ogimage 	= firstNotEmpty( array( $hb_thumbnail, $hb_sitelogo) );
} elseif ( is_archive() ) { //Auto-gen 'cats'
	$hb_seo_title   	= ucwords( firstNotEmpty( array( $hb_archivetitle, $hb_posttitle ) ) );
    $hb_seo_desc    	= ucfirst( firstNotEmpty( array( $hb_catexcerpt, $hb_postexcerpt, $hb_sitedesc ) ) );
	$hb_seo_author  	= ucwords( firstNotEmpty( array( $hb_postauthor, $hb_siteauthor ) ) );
    $hb_seo_canon   	= enforceFSlash( $hb_permalink );
    $hb_seo_ogimage 	= firstNotEmpty( array( $hb_thumbnail, $hb_sitelogo ) );
} elseif ( is_singular() ) { //These vars should be reliable
	$hb_seo_title   	= ucwords( $hb_posttitle );
    $hb_seo_desc    	= ucfirst( $hb_postexcerpt );
    $hb_seo_author 		= ucwords( $hb_postauthor );
	$hb_seo_canon   	= enforceFSlash( $hb_permalink );
	$hb_seo_ogimage 	= firstNotEmpty( array( $hb_thumbnail, $hb_sitelogo ) );
} else {
    echo '<!-- META FALLBACK - CHECK HB-SEO TEMPLATE FUNCTIONS -->';
    $hb_seo_title   	= ucwords( firstNotEmpty( array( $hb_posttitle, $hb_archivetitle, $hb_sitetitle ) ) );
    $hb_seo_desc    	= ucfirst( firstNotEmpty( array( $hb_postexcerpt, $hb_catexcerpt, $hb_sitedesc ) ) );
    $hb_seo_author  	= ucwords( firstNotEmpty( array( $hb_postauthor, $hb_siteauthor ) ) );
    $hb_seo_canon   	= enforceFSlash( $hb_permalink );
    $hb_seo_ogimage 	= firstNotEmpty( array( $hb_thumbnail, $hb_sitelogo ) );
}

/* Set the non-conditional hb_seo vars */
/* Some Open Graph meta are dup's of seo meta */
$hb_seo_ogtitle		= $hb_seo_title;
$hb_seo_robots		= $hb_robots;
$hb_seo_ogtype		= $hb_objecttype;
$hb_seo_ogurl		= $hb_seo_canon;
$hb_seo_oglocale	= $hb_locale;
$hb_seo_oglocalealt	= $hb_localealt;
$hb_seo_ogdesc		= $hb_seo_desc;
$hb_seo_ogsitename	= $hb_sitetitle;

/* Excrete this pig */
echo <<<EOF
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Site verification (should be moved from template) -->
<meta name="google-site-verification" content="g9mEcBrJ4uTyVj7KYmGbbuAzqRkeMA2jIJth4hM5Dns" />
<meta name="msvalidate.01" content="0245B24FF2B31489A65C5541B284D4D8" />
<!-- SEO Meta -->
<title>$hb_seo_title</title>
<meta name="description" content="$hb_seo_desc">
<meta name="author" content="$hb_seo_author">
<meta name="robots" content="$hb_seo_robots">
<link rel="canonical" href="$hb_seo_canon">
<!-- Open Graph Meta - <html> namespace must match og:type -->
<meta property="og:title" content="$hb_seo_ogtitle">
<meta property="og:type" content="$hb_seo_ogtype">
<meta property="og:image" content="$hb_seo_ogimage">
<meta property="og:url" content="$hb_seo_ogurl">
<meta property="og:locale" content="$hb_seo_oglocale">
<meta property="og:locale:alternate" content="$hb_seo_oglocalealt">
<meta property="og:description" content="$hb_seo_ogdesc">
<meta property="og:site_name" content="$hb_seo_ogsitename">
<!-- Branding Meta -->
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
<!-- hb_head end -->
EOF;
?>