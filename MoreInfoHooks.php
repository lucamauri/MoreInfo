<?php
/**
 * Step 3: Register the file with the magic words.
 */
//$wgExtensionMessagesFiles['MoreInfoMagic'] = __DIR__ . '/MoreInfo.i18n.magic.php';

class MIHooks {
/**
 * Step 4: assign a value to our variable
 */
//$wgHooks['ParserGetVariableValueSwitch'][] = 'wfMIServerIPSwitch';
public static function wfMIServerIPSwitch( &$parser, &$cache, &$magicWordId, &$ret ) {
	switch ( $magicWordId ) {		
		case 'MIServerIP':
			//$ret = gethostbyname(gethostname());

			$ServerIP = new MIServerIP;
			$ret = $ServerIP->getIPs();
			break;
		default:
			return false;
	}

	// We must return true for two separate reasons:
	// 1. To permit further callbacks to run for this hook.
	//    They might override our value but that's life.
	//    Returning false would prevent these future callbacks from running.
	// 2. At the same time, "true" indicates we found a value.
	//    Returning false would set variable value to null.
	//
	// In other words, true means "we found a value AND other
	// callbacks will run," and false means "we didn't find a value
	// AND abort future callbacks." It's a shame these two meanings
	// are mixed in the same return value.  So as a rule, return
	// true whether we found a value or not.
	return true;
}

/**
 * Step 5: register the custom variable(s) so that it shows up in
 * Special:Version under the listing of custom variables.
 */
/*$wgExtensionCredits['variable'][] = array(
	'name' => 'MoreInfoServerIP',
	'author' => 'Luca Mauri',
	'version' => '1.0',
	'description' => 'Provides a variable as an example and performs no discernible function',
	'url' => "https://github.com/lucamauri/MoreInfo",
);*/

/**
 * Step 6: register wiki markup words associated with
 *         MAG_NIFTYVAR as a variable and not some
 *         other type of magic word
 */
//$wgHooks['MagicWordwgVariableIDs'][] = 'wfMIServerIPVarIds';
public static function wfMIServerIPVarIds( &$customVariableIds ) {
	// $customVariableIds is where MediaWiki wants to store its list of custom
	// variable IDs. We oblige by adding ours:
	$customVariableIds[] = 'MIServerIP';

	// must do this or you will silence every MagicWordwgVariableIds hook
	// registered after this!
	return true;
}
}