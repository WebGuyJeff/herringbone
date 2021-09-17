<?php


/**
 * PHP Class: Herringbone_SEO_Meta
 * 
 * Note to self: This would be better suited to a function in functions.php or a standalone plugin.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


class SEO_Meta {


/**
 * Function Enforce_Forward_Slash
 * 
 * Append forward slash to strings where not already present, return same value if arg is empty.
 * Serving multiple versions of the same url i.e url.com/ and url.com can lead to cannibalisation.
 * This function serves to ensure trailing slashes are present. This should be controlled by a top-
 * level SEO setting where the site owner can set slashes on or off.
 */
function Enforce_Forward_Slash( $url ) {
	if ($url !== '' && substr($url, -1) !== '/') {
        $url = $url . '/';
    }
    return $url;
};

/**
 * Function First_Not_Empty
 * 
 * Accepts an array of values and returns the first non-empty value as a string.
 * Returns empty string on failure.
 */
function First_Not_Empty( $array ) {
	$string = '';
	if (is_array( $array ) ) {
		foreach ( $array as &$value ) {
			$trimmed = trim( $value, " " );
			if ( !empty( $trimmed ) ) {
				$string = $trimmed;
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

/**
 * Function Extract_Image_From_Content
 * 
 * Accepts post content to be parsed with regular expression to find an image src.
 * It doesn't care what context the image is in, it's attributes or otherwise, it
 * just returns the first image found.
 * The cleaned URL is returned without quotes.
 */
function Extract_Image_From_Content( $content ) {
    $url = "";

    if ( isset( $content ) && $content !== "" ) {

        if ( is_array( $content ) ) {
            implode( $content );
        }

        $regex = '/src="([^"]*)"/';
        preg_match_all( $regex, $content, $matches, PREG_PATTERN_ORDER );

        if ( isset( $matches[0][0] ) ) {
            $match = $matches[0][0];
            $urlParts = explode( '"', $match, 3 );
            $url = $urlParts[1];

        } else {
            $url = "";
        }

    } else {
        $url = "";
    }
        return $url;
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
$hb_locale			= wp_strip_all_tags( get_bloginfo( 'language' ) );
$hb_charset         = wp_strip_all_tags( get_bloginfo( 'charset' ) );

/* Page-Specific. Try on all pages for more fallbacks. */

$post = get_post();//Set up the post manually
setup_postdata($post);
$hb_postid          = get_the_ID();
$hb_postcontent     = get_post_field( 'post_content', $hb_postid, '' );
$hb_postimage       = esc_url( Extract_Image_From_Content( $hb_postcontent ) );
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
	$hb_postexcerpt		= preg_split('/[.?!]/',  wp_strip_all_tags( $hb_postcontent, true ) )[0] . '.';
	$hb_postauthor      = wp_strip_all_tags( get_the_author() );
	$hb_thumbnail       = esc_url( get_the_post_thumbnail_url( $hb_postid ) );
}

/* Set the conditional hb_seo vars */

if ( is_front_page() ) { //Homepage
    $hb_title   	= ucwords( $hb_sitetitle );
    $hb_desc    	= ucfirst( First_Not_Empty( [ $hb_sitedesc, $hb_postexcerpt ] ) );
    $hb_author  	= ucwords( First_Not_Empty( [ $hb_siteauthor, $hb_postauthor ] ) );
    $hb_canon   	= Enforce_Forward_Slash( $hb_siteurl );
    $hb_ogimage 	= First_Not_Empty( [ $hb_sitelogo, $hb_thumbnail, $hb_postimage ] );
} elseif ( is_home() ) { //Posts Page
    $hb_title   	= ucwords( First_Not_Empty( [ $hb_blogtitle, $hb_sitetitle ] ) );
    $hb_desc    	= ucfirst( First_Not_Empty( [ $hb_postexcerpt, $hb_sitedesc ] ) );
    $hb_author  	= ucwords( $hb_siteauthor );
    $hb_canon   	= Enforce_Forward_Slash( $hb_permalink );
    $hb_ogimage 	= First_Not_Empty( [ $hb_thumbnail, $hb_sitelogo, $hb_postimage ] );
} elseif ( is_category() ) {
	$hb_title   	= ucwords( First_Not_Empty( [ $hb_archivetitle, $hb_posttitle ] ) );
    $hb_desc    	= ucfirst( First_Not_Empty( [ $hb_catexcerpt, $hb_postexcerpt, $hb_sitedesc ] ) );
	$hb_author  	= ucwords( First_Not_Empty( [ $hb_postauthor, $hb_siteauthor ] ) );
    $hb_canon   	= Enforce_Forward_Slash( $hb_permalink );
    $hb_ogimage 	= First_Not_Empty( [ $hb_thumbnail, $hb_postimage, $hb_sitelogo ] );
} elseif ( is_archive() ) { //Auto-gen 'cats'
	$hb_title   	= ucwords( First_Not_Empty( [ $hb_archivetitle, $hb_posttitle ] ) );
    $hb_desc    	= ucfirst( First_Not_Empty( [ $hb_catexcerpt, $hb_postexcerpt, $hb_sitedesc ] ) );
	$hb_author  	= ucwords( First_Not_Empty( [ $hb_postauthor, $hb_siteauthor ] ) );
    $hb_canon   	= Enforce_Forward_Slash( $hb_permalink );
    $hb_ogimage 	= First_Not_Empty( [ $hb_thumbnail, $hb_postimage, $hb_sitelogo ] );
} elseif ( is_singular() ) { //These vars should be reliable
	$hb_title   	= ucwords( $hb_posttitle );
    $hb_desc    	= ucfirst( $hb_postexcerpt );
    $hb_author 		= ucwords( $hb_postauthor );
	$hb_canon   	= Enforce_Forward_Slash( $hb_permalink );
	$hb_ogimage 	= First_Not_Empty( [ $hb_postimage, $hb_thumbnail, $hb_sitelogo ] );
} else {
    echo '<!-- META FALLBACK - CHECK HB-SEO TEMPLATE FUNCTIONS -->';
    $hb_title   	= ucwords( First_Not_Empty( [ $hb_posttitle, $hb_archivetitle, $hb_sitetitle ] ) );
    $hb_desc    	= ucfirst( First_Not_Empty( [ $hb_postexcerpt, $hb_catexcerpt, $hb_sitedesc ] ) );
    $hb_author  	= ucwords( First_Not_Empty( [ $hb_postauthor, $hb_siteauthor ] ) );
    $hb_canon   	= Enforce_Forward_Slash( $hb_permalink );
    $hb_ogimage 	= First_Not_Empty( [ $hb_thumbnail, $hb_postimage, $hb_sitelogo ] );
}

/* Set the non-conditional hb_seo var array */
/* Some Open Graph meta are dup's of seo meta */

$hb_seo = [
    "title"         => $hb_title,
    "desc"          => $hb_desc,
    "author"        => $hb_author,
    "canon"         => $hb_canon,
    "ogimage"       => $hb_ogimage,
    "ogtitle"       => $hb_title,
    "robots"        => $hb_robots,
    "ogtype"        => $hb_objecttype,
    "ogurl"         => $hb_canon,
    "oglocale"      => $hb_locale,
    "oglocalealt"   => $hb_localealt,
    "ogdesc"        => $hb_desc,
    "ogsitename"    => $hb_sitetitle,
    "charset"       => $hb_charset,
];

/* Excrete this pig */

public static function print_all(){

echo <<<EOF
<meta charset="{$hb_seo["charset"]}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Site verification (to be removed from this template) -->
<meta name="google-site-verification" content="g9mEcBrJ4uTyVj7KYmGbbuAzqRkeMA2jIJth4hM5Dns" />
<meta name="msvalidate.01" content="0245B24FF2B31489A65C5541B284D4D8" />
<!-- SEO Meta -->
<title>{$hb_seo["title"]}</title>
<meta name="description" content="{$hb_seo["desc"]}">
<meta name="author" content="{$hb_seo["author"]}">
<meta name="robots" content="{$hb_seo["robots"]}">
<link rel="canonical" href="{$hb_seo["canon"]}">
<!-- Open Graph Meta - <html> namespace must match og:type -->
<meta property="og:title" content="{$hb_seo["ogtitle"]}">
<meta property="og:type" content="{$hb_seo["ogtype"]}">
<meta property="og:image" content="{$hb_seo["ogimage"]}">
<meta property="og:url" content="{$hb_seo["ogurl"]}">
<meta property="og:locale" content="{$hb_seo["oglocale"]}">
<meta property="og:locale:alternate" content="{$hb_seo["oglocalealt"]}">
<meta property="og:description" content="{$hb_seo["ogdesc"]}">
<meta property="og:site_name" content="{$hb_seo["ogsitename"]}">
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

}//print_all()

}//class-end

?>

