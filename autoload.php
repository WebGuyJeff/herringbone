<?php


// Define the main autoloader
spl_autoload_register( 'herringbone_autoloader' );
function herringbone_autoloader( $class_name ) {

	// These should be changed for your particular plugin requirements
	$parent_namespace = 'herringbone';
	$classes_subfolder = 'includes';

	if ( false !== strpos( $class_name, $parent_namespace ) ) {
		$classes_dir = realpath( get_template_directory( __FILE__ ) ) . DIRECTORY_SEPARATOR . $classes_subfolder . DIRECTORY_SEPARATOR;

		// Project namespace
		$project_namespace = $parent_namespace . '\\';
		$length = strlen( $project_namespace );

		// Remove top level namespace (that is the current dir)
		$class_file = substr( $class_name, $length );
		// Swap underscores for dashes and lowercase
		$class_file = str_replace( '_', '-', strtolower( $class_file ) );

		// Prepend `class-` to the filename (last class part)
		$class_parts = explode( '\\', $class_file );
		$last_index = count( $class_parts ) - 1;
		$class_parts[ $last_index ] = 'class-' . $class_parts[ $last_index ];

		// Join everything back together and add the file extension
		$class_file = implode( DIRECTORY_SEPARATOR, $class_parts ) . '.php';
		$location = $classes_dir . $class_file;

		if ( ! is_file( $location ) ) {
			return;
		}

		require_once $location;
	}
}