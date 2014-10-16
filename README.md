Google Voice scripts
==========

Working with Google Voice data.

## Installation

Drag the "Calls" folder from your [Google Voice takeout archive](https://www.google.com/settings/takeout) into the same folder that this script runs. Unfortunately the Google Takeout system only provides HTML files, which makes parsing it for the actual data more challenging.

The script currently reads the text message (SMS) files and extracts the message content from the file. It also grabs the date, and the phone number (and name, if present) that the message came from.

The script currently saves the SMS content to a local database. Here is the structure: 

	CREATE TABLE `sms` (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		`time` datetime NOT NULL,
		`cdate` datetime NOT NULL,
		`filename` varchar(250) NOT NULL DEFAULT '',
		`from` varchar(50) NOT NULL DEFAULT '',
		`file_content` text NOT NULL,
		`message` varchar(250) NOT NULL DEFAULT '',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;