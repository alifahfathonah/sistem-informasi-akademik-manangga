<?php
// WARNING: DO NOT EDIT THIS FILE !

if ( session_id() == '' ) session_start();
ob_start();

// get main config
require ( __DIR__ . '/config.php' );

// get prepared text
require ( __DIR__ . '/includes/predefined.php' );

// get functions
require ( __DIR__ . '/includes/functions.php' );
?>