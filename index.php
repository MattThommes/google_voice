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
					$query = "SELECT * FROM sms WHERE filename = '" . $file . "'";
					$exists = $db_conn->query($query);
					$exists = $exists->fetch();
					if (!$exists) {
$debug->dbg($file,1);
						$parts = explode(" - Text - ", $file);
						$from = $parts[0];
						//$time = trim($parts[1], ".html");
						$file_contents = file_get_contents($path_to_calls . "/Calls/" . $file);
						$match = preg_match("/\stitle=\".*\">/", $file_contents, $time);
						$time = substr($time[0], 8, strlen($time[0]) - 10);
						$time = date("Y-m-d H:i:s", strtotime($time));
						$match = preg_match("/<q>.*<\/q>/", $file_contents, $message);
						if (isset($message[0]) && $message[0]) {
							$message = preg_replace("/<\/?q>/", "", $message[0]);
							$fields = array(
								"time",
								"cdate",
								"filename",
								"`from`",
								"file_content",
								"message",
							);
							$values = array(
								"'" . $time . "'",
								"NOW()",
								"'" . $file . "'",
								"'" . $from . "'",
								"'" . str_replace("'", "\'", $file_contents) . "'",
								"'" . str_replace("'", "\'", $message) . "'",
							);
							$query = "INSERT INTO sms (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $values) . ")";
//$debug->dbg($query,1);
							$ins = $db_conn->query($query);
$debug->dbg("Inserted into DB",1);
						} else {
$debug->dbg("NO CONTENT FOUND!",1);						
						}
					}
//$debug->dbg("testing just one");
				}
			}
		}
		closedir($handle);
	}

?>