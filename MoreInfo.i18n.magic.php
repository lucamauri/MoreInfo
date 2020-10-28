<?php
/**
 * Step 1: choose a magic word ID
 * Step 2: define some words to use in wiki markup
 */

$magicWords = array();

/** English (English) */
$magicWords['en'] = array(
	// tell MediaWiki that all {{NiftyVar}}, {{NIFTYVAR}}, {{CoolVar}},
	// {{COOLVAR}} and all case variants found in wiki text should be mapped to
	// magic ID 'mycustomvar1' (0 means case-insensitive)
    /*'mycustomvar1' => array( 0, 'NiftyVar', 'CoolVar' ),*/
    'MIServerIP' => array( 0, 'SERVERIP', 'SERVERIPS' ),
);
$magicWords['it'] = array(
    'MIServerIP' => array( 0, 'SERVERIP', 'SERVERIPS' ),
);