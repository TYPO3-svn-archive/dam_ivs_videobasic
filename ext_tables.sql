#
# Table structure for table 'tx_dam'
#
CREATE TABLE tx_dam (
	tx_damivsvideobasic_encode tinyint(3) DEFAULT '0' NOT NULL,
	tx_damivsvideobasic_location int(11) DEFAULT '0' NOT NULL,
	tx_damivsvideobasic_screenshot int(11) DEFAULT '0' NOT NULL,
	tx_damivsvideobasic_streamdir varchar(255) DEFAULT '' NOT NULL,
	tx_damivsvideobasic_filenamestream varchar(255) DEFAULT '' NOT NULL,
	tx_damivsvideobasic_width int(11) DEFAULT '0' NOT NULL,
	tx_damivsvideobasic_height int(11) DEFAULT '0' NOT NULL,
	tx_damivsvideobasic_status int(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tt_content (
	tx_damivsvideobasic_video int(11) DEFAULT '0' NOT NULL
);