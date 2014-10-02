<?php

	require "vendor/autoload.php";
	use MattThommes\Debug;
	$debug = new Debug;
	include "db_connect.php";

	$path_to_calls = "Calls";

	function file_basename($path) {
		$path = basename($path);
		return (strlen($path) > 0 && substr($path, 0, 1) != '.' ? $path : '') ;
	}

	$files = array();
	if ($handle = opendir($path_to_calls)) {
		while (false !== ($file = readdir($handle))) {
			$file = file_basename($file);
			if ($file) {
$debug->dbg($file);
			}
		}
		closedir($handle);
	}

?>