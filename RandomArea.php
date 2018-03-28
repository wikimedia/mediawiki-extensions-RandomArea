<?php

/**
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Thomas Stock
 * @copyright 2006 Thomas Stock
 * @licence http://creativecommons.org/licenses/by-nc-sa/2.5/
 */

/*
* History:
* 1.1: Fix loop if entry length < 1; Thanks to Steffen
*
*/

if( !defined( 'MEDIAWIKI' ) ) {
        echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
        die( 1 );
}

define( 'RANDOM_AREA_VERSION', '1.1.1' );
$wgExtensionFunctions[] = "ylRandomAreaExtension";

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Random Area',
	'description'    => 'Allows for inserting random elements in a page',
	'author'         => array( 'Thomas Stock' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:RandomArea',
	'version'        => RANDOM_AREA_VERSION,
);

function ylRandomAreaExtension() {
    global $wgParser;
    $wgParser->setHook( "randomArea", "renderRandomArea" );
}

function renderRandomArea( $input, $argv, $parser ) {
	$count = $argv['count'];
	if ($count < 0 || !$count) {
		$count = 1;
	}
	$nsPrefix = $argv['nsprefix'];
	$include = (bool) $argv['include'];
	$values = explode("\n", $input);
	$valCount = count($values) - 1;
	if ($valCount < $count) {
		return $parser->internalParse("Exception:
		<br />Array out of Bounce - >
		Only ".$valCount." items available, count = ".$count );
	}
	$valueIndex = array();
	$randOut = "";
	$i = 0;
	while ($i < $count ) {
		$randVal = rand(0, $valCount);
		$randTemp = trim($values[$randVal]);
		if (strlen($randTemp) > 0 && !array_key_exists($randVal, $valueIndex)) {

			if (strlen($nsPrefix) > 1) {
				$randOutTemp = $nsPrefix.$randTemp;
			} else {
				$randOutTemp = $randTemp;
			}

			if ($include) {
				$randOut .= "{{:".$randOutTemp."}}";
			} else {
				$randOut .= $randOutTemp;
			}
			$valueIndex[$randVal] = true;
			$i++;
		}

	}
	return $parser->internalParse($randOut);
}
