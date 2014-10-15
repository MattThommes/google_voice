<?php

	require "vendor/autoload.php";
	use MattThommes\Debug;
	$debug = new Debug;
	include "db_connect.php";

	// the path to where you have the Calls folder.
	$path_to_calls = "/vagrant/dev/admin/google_voice";

	function file_basename($path) {
		$path = basename($path);
		return (strlen($path) > 0 && substr($path, 0, 1) != '.' ? $path : '') ;
	}

	$files = array();
	if ($handle = opendir("Calls")) {
		while (false !== ($file = readdir($handle))) {
			$file = file_basename($file);
			if ($file) {
				if (preg_match("- Text -", $file)) {
$debug->dbg($file,1);
					$parts = explode(" - Text - ", $file);
					$from = $parts[0];
					$time = trim($parts[1], ".html");
//$debug->dbg($time,1);
					$time = date("Y-m-d H:i:s", strtotime($time));
//$debug->dbg($time);
					$file_contents = file_get_contents($path_to_calls . "/Calls/" . $file);
					$fd = FluentDOM($file_contents);
					$message = $fd->find('//q')->text();
$debug->dbg($message);
$debug->dbg("testing just one");
				}
			}
		}
		closedir($handle);
	}

?>