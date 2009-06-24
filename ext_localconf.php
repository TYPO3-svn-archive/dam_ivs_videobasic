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

// get path to this extension
$tempPath = t3lib_extMgm::extPath('dam_ivs_videobasic');

// register the AJAX functionality via EID
$TYPO3_CONF_VARS['FE']['eID_include']['tx_damivsvideobasic_eID'] = 'EXT:dam_ivs_videobasic/eid/class.tx_damivsvideobasic_eid.php';
t3lib_extMgm::addPItoST43($_EXTKEY,'eid/class.tx_damivsvideobasic_eid.php','_eID','',0);

// register the plugin functionality in CType
t3lib_extMgm::addPItoST43($_EXTKEY, 'pi1/class.tx_damivsvideobasic_pi1.php', '_pi1', 'CType', 0);

// catch the new or edit command
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_procdm.php:tx_damivsvideobasic_procdm';

// catch the delete command
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_proccm.php:tx_damivsvideobasic_proccm';

?>
