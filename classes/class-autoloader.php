<?php

/**
 * Autoloader for PHP 5.3+
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018/classes
 */

namespace GTChurch2018\Classes;

class Autoloader {

	/**
	 * Autoloader function.
	 *
	 * @param 		string 		$class_name 		The class name.
	 */
	public static function autoloader( $class_name ) {

		if ( false === strpos( $class_name, 'GTChurch2018' ) ) { return; }

		$file_parts = explode( '\\', $class_name );

		$namespace = '';

		for ( $i = count( $file_parts ) - 1; $i > 0; $i-- ) {

			$current = strtolower( $file_parts[$i] );
			$current = str_ireplace( '_', '-', $current );

			if ( count( $file_parts ) -1 === $i ) {

				if ( strpos( strtolower( $file_parts[ count( $file_parts ) - 1 ] ), 'interface' ) ) {

					$interface_name = explode( '_', $file_parts[ count( $file_parts ) - 1 ] );
					$interface_name = $interface_name[0];

					$file_name = "interface-$interface_name.php";

				} else {

					$file_name = "class-$current.php";

				}

			} else {

				$namespace = '/' . $current . $namespace;

			}

		} // for

		$filepath = trailingslashit( dirname( dirname( __FILE__ ) ) . $namespace );
		$filepath .= $file_name;

		if ( file_exists( $filepath ) ) {

			include_once( $filepath );

		} else {

			wp_die(
				esc_html( "The file attempting to be loaded at $filepath does not exist in $class_name." )
			);

		}

	} // autoloader()

} // class

spl_autoload_register( 'GTChurch2018\Classes\Autoloader::autoloader' );
