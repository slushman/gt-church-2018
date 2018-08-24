<?php

/**
 * Formats a number to be used in a tel link.
 * 
 * @since 		1.0.0
 * @param 		string 		$number 		A phone number.
 * @return 		string 						A tel link formated phone number.
 */
function gt_format_phone_number( $number ) {

	$exts 		= array( ' x', ' ext.', ' ext', 'x', 'ext.', 'ext' );
	$extensions = str_replace( $exts, ',', $number );
	$formatted 	= preg_replace( '/[^0-9\,]/', '', $extensions );

	return $formatted;

} // gt_format_phone_number()