<?php

/**
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Thomas Stock
 * @copyright 2006 Thomas Stock
 * @licence http://creativecommons.org/licenses/by-nc-sa/2.5/
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'RandomArea' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['RandomArea'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for the RandomArea extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the RandomArea extension requires MediaWiki 1.29+' );
}