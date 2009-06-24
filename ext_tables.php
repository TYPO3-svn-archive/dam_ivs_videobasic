<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 IMAGINE virtual services GmbH, Sebastian Siebert <ss@imagine-vs.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

/*** Start: Register FE-Plugin ***/
t3lib_extMgm::allowTableOnStandardPages('tx_damivsvideobasic');
t3lib_extMgm::addToInsertRecords('tx_damivsvideobasic');

$tempColumns = array (
	'tx_damivsvideobasic_video' => array (
		'exclude' => 0,
		'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tt_content.CType_pi1.field_video',
		'config' => array (
			'form_type' => 'user',
			'userFunc' => 'EXT:dam/lib/class.tx_dam_tcefunc.php:&tx_dam_tceFunc->getSingleField_typeMedia',
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_dam',
			'prepend_tname' => 1,
			'MM' => 'tx_dam_mm_ref',
			'MM_foreign_select' => 1,
			'MM_opposite_field' => 'file_usage',
			'MM_match_fields' => array('ident' => 'tx_damttcontent_files'),
			'allowed_types' => 'mpg,mpeg,mp4,avi,wmv',
			'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
			'show_thumbs' => '1',
			'size' => '1',
			'maxitems' => '1',
			'minitems' => '0',
			'autoSizeMax' => '30',
			'disable_controls' => 'upload',
		)
	),
);

t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content',$tempColumns,1);

$TCA['tt_content']['types'][$_EXTKEY.'_pi1']['showitem']='CType;;4;button;1-1-1, hidden;;;;2-2-2, header;;3;;3-3-3, linkToTop;;;;4-4-4,
		--div--;LLL:EXT:dam_ivs_videobasic/locallang.xml:tx_damivsvideobasic.tabtitle, tx_damivsvideobasic_video;;;;5-5-5,imageorient;;2,
		--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,starttime, endtime;;;;6-6-6';

t3lib_extMgm::addPlugin(array(
	'LLL:EXT:dam_ivs_videobasic/locallang.xml:tt_content.CType_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'CType');
/*** End: Register FE-Plugin ***/

/*** Start: Register BE-Plugin for DAM-Plugin ***/
if (TYPO3_MODE=='BE')
{
	$tempColumns = array (
		'tx_damivsvideobasic_encode' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_encode',
			'config' => array (
				'type' => 'check',
			)
		),
		'tx_damivsvideobasic_location' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_location',
			'config' => array (
				'type'     => 'select',
				'size'     => '1',
				'maxitems' => '1',
				'items'    => array (
					array('LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_location.I.0', '0')
				)
			)
		),
		'tx_damivsvideobasic_screenshot' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_screenshot',
			'config' => array (
				'form_type' => 'user',
				'userFunc' => 'EXT:dam/lib/class.tx_dam_tcefunc.php:&tx_dam_tceFunc->getSingleField_typeMedia',
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_dam',
				'prepend_tname' => 1,
				'MM' => 'tx_dam_mm_ref',
				'MM_foreign_select' => 1,
				'MM_opposite_field' => 'file_usage',
				'MM_match_fields' => array('ident' => 'tx_damttcontent_files'),
				'allowed_types' => 'jpg,jpeg,gif,png',
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'show_thumbs' => '1',
				'size' => '1',
				'maxitems' => '1',
				'minitems' => '0',
				'autoSizeMax' => '30',
				'disable_controls' => 'upload',
			)
		),
		'tx_damivsvideobasic_streamdir' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_streamdir',
			'config' => array (
				'readOnly' => 1,
				'type' => 'input',
				'size' => '80',
				'eval' => 'trim',
			)
		),
		'tx_damivsvideobasic_filenamestream' => array (
			'exclude' => 0,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_filenamestream',
			'config' => array (
				'readOnly' => 1,
				'type' => 'input',
				'size' => '80',
				'eval' => 'trim',
			)
		),
		'tx_damivsvideobasic_width' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_width',
			'config' => array (
				'readOnly' => 1,
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '10'
				),
				'default' => 0
			)
		),
		'tx_damivsvideobasic_height' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_height',
			'config' => array (
				'readOnly' => 1,
				'type'     => 'input',
				'size'     => '4',
				'max'      => '4',
				'eval'     => 'int',
				'checkbox' => '0',
				'range'    => array (
					'upper' => '1000',
					'lower' => '10'
				),
				'default' => 0
			)
		),
		'tx_damivsvideobasic_status' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_status',
			'config' => array (
				'readOnly' => 1,
				'type'     => 'select',
				'size'     => '1',
				'maxitems' => '1',
				'items'    => array (
					array('LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_status.I.0', '0'),
					array('LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_status.I.1', '1'),
					array('LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_status.I.2', '2'),
					array('LLL:EXT:dam_ivs_videobasic/locallang_db.xml:tx_dam.tx_damivsvideobasic_status.I.3', '3'),
				)
			)
		),
	);

	$tempPath = t3lib_extMgm::extPath('dam_ivs_videobasic');

	t3lib_div::loadTCA('tx_dam');
	t3lib_extMgm::addTCAcolumns('tx_dam',$tempColumns,1);
	#t3lib_extMgm::addToAllTCAtypes('tx_dam','tx_damivsvideobasic_encode;;;;1-1-1, tx_damivsvideobasic_filenamestream, tx_damivsvideobasic_width, tx_damivsvideobasic_height, tx_damivsvideobasic_status');
	t3lib_extMgm::addToAllTCAtypes('tx_dam', '--div--;LLL:EXT:dam_ivs_videobasic/locallang.xml:tx_damivsvideobasic.tabtitle, tx_damivsvideobasic_encode;;;;1-1-1, tx_damivsvideobasic_location, tx_damivsvideobasic_screenshot, tx_damivsvideobasic_streamdir, tx_damivsvideobasic_filenamestream, tx_damivsvideobasic_width, tx_damivsvideobasic_height, tx_damivsvideobasic_status');

	// add fields to index preset fields
	$TCA['tx_dam']['txdamInterface']['index_fieldList'] .= ',tx_damivsvideobasic_encode';

	t3lib_extMgm::insertModuleFunction(
		'txdamM1_file',
		'tx_dam_ivs_videobasic_modfunc_status',
		t3lib_extMgm::extPath($_EXTKEY).'modfunc_file_status/class.tx_dam_ivs_videobasic_modfunc_status.php',
		'LLL:EXT:dam_ivs_videobasic/locallang.xml:tx_dam.tx_damivsvideobasic_modfunc_status'
	);

}
/*** End: Register BE-Plugin for DAM-Plugin ***/

// load static constants file and setup file
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Video Basic');


?>