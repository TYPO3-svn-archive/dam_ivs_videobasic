<?php

########################################################################
# Extension Manager/Repository config file for ext: "dam_ivs_videobasic"
#
# Auto generated 24-06-2009 11:30
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Media (DAM) Video Basic',
	'description' => '- Video Services like youTube, MyVideo, SevenLoad
- Handling movie files (encoding, upload, parsing)',
	'category' => 'plugin',
	'author' => 'Sebastian Siebert',
	'author_email' => 'ss@imagine-vs.de',
	'shy' => '',
	'dependencies' => 'cms,dam',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tx_dam',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => 'Imagine Virtual Services',
	'version' => '0.0.5',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'dam' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:34:{s:9:"ChangeLog";s:4:"6ef9";s:10:"README.txt";s:4:"ee2d";s:21:"ext_conf_template.txt";s:4:"9885";s:12:"ext_icon.gif";s:4:"41df";s:17:"ext_localconf.php";s:4:"1d48";s:14:"ext_tables.php";s:4:"055b";s:14:"ext_tables.sql";s:4:"da70";s:28:"icon_tx_damivsvideobasic.gif";s:4:"475a";s:13:"locallang.xml";s:4:"7f11";s:16:"locallang_db.xml";s:4:"8514";s:37:"eid/class.tx_damivsvideobasic_eid.php";s:4:"86b3";s:14:"doc/manual.pdf";s:4:"9dea";s:14:"doc/manual.sxw";s:4:"6f2d";s:19:"res/js/swfobject.js";s:4:"892a";s:17:"res/css/style.css";s:4:"cddc";s:27:"res/flash/NonverBlaster.swf";s:4:"8f11";s:31:"res/flash/NonverBlaster.swf.old";s:4:"5ade";s:27:"res/flash/previewplayer.swf";s:4:"2a93";s:41:"hooks/class.dam_ivs_videobasic_proccm.php";s:4:"bc7c";s:41:"hooks/class.dam_ivs_videobasic_procdm.php";s:4:"c0a3";s:27:"3rdparty/typo3video.tar.bz2";s:4:"4476";s:27:"3rdparty/jsonrpcphp/COPYING";s:4:"7514";s:26:"3rdparty/jsonrpcphp/README";s:4:"5150";s:37:"3rdparty/jsonrpcphp/jsonRPCClient.php";s:4:"fd5a";s:37:"3rdparty/jsonrpcphp/jsonRPCServer.php";s:4:"dd77";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:37:"pi1/class.tx_damivsvideobasic_pi1.php";s:4:"9023";s:45:"pi1/class.tx_damivsvideobasic_pi1_wizicon.php";s:4:"4cf7";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"97a8";s:20:"static/constants.txt";s:4:"2f0f";s:16:"static/setup.txt";s:4:"3482";s:66:"modfunc_file_status/class.tx_dam_ivs_videobasic_modfunc_status.php";s:4:"4c3d";s:33:"modfunc_file_status/locallang.xml";s:4:"d8c9";}',
	'suggests' => array(
	),
);

?>