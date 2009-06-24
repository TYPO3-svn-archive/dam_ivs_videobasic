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
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


require_once(PATH_t3lib.'class.t3lib_extobjbase.php');



/**
 * Module extension (addition to function menu) 'tx_dam_ivs_videobasic_modfunc_status' for the 'dam_ivs_videobasic' extension.
 *
 * @author		Sebastian Siebert <ss@imagine-vs.de>
 * @package		TYPO3
 * @subpackage	tx_dam_ivs_videobasic_modfunc_status
 */
class tx_dam_ivs_videobasic_modfunc_status extends t3lib_extobjbase {

	/**
	 * Returns the module menu
	 *
	 * @return    Array with menuitems
	 */
	function modMenu()    {
		global $LANG;

		return Array (
			"tx_dam_ivs_videobasic_modfunc_status_check" => "",
		);
	}

	/**
	 * Main method of the module
	 *
	 * @return    HTML
	 */
	function main()    {
		// Initializes the module. Done in this function because we may need to re-initialize if data is submitted!
		global $SOBE,$BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

		// set the path for navigation bar
		$infoPath = $this->pObj->getFolderNavBar($this->pObj->pathInfo);

		// create a instance of dam object
		$damObj = &t3lib_div::getUserObj('tx_dam');

		// create a html table with the informations from local server
		$table = '';
		$table .= '<table class="typo3-dblist typo3-filelist" cellspacing="0" border="0" style="width:100%">';
		$table .= '<tr>';
		$table .= '<td class="c-headLine" nowrap="nowrap" valign="top" align="left" style="border-bottom: 1px solid #888888; padding-left: 5px;">'.$LANG->getLL("filename").'</td>';
		$table .= '<td class="c-headLine" nowrap="nowrap" valign="top" align="left" style="border-bottom: 1px solid #888888; padding-left: 5px;">'.$LANG->getLL("size").'</td>';
		$table .= '<td class="c-headLine" nowrap="nowrap" valign="top" align="left" style="border-bottom: 1px solid #888888; padding-left: 5px;">'.$LANG->getLL("status").'</td>';
		$table .= '</tr>';


		$dh = dir($this->pObj->pathInfo['dir_path_absolute']);
		$count = 0;
		while (false !== ($entry = $dh->read()))
		{
			if($entry!=='.' and $entry!=='..' and is_file($this->pObj->pathInfo['dir_path_absolute'].$entry))
			{
				if(($count%2) == 0)
					$rowColor = '#FAFAFA';
				else
					$rowColor = '#F5F5F5';

				$fieldList = 'uid,pid,file_name, file_path, file_size,tx_damivsvideobasic_encode,tx_damivsvideobasic_status';
				$meta = $damObj->meta_getDataForFile($this->pObj->pathInfo['dir_path_absolute'].$entry, $fieldList);
				//t3lib_div::devLog('File Meta', 'dam_ivs_videobasic', 1, array('result' => $meta));
				$table .= '<tr style="background-color:'.$rowColor.';">';
				$table .= '<td class="typo3-dblist-item" style="padding-left:5px;">'.$meta['file_name'].'</td>';
				$table .= '<td class="typo3-dblist-item" style="padding-left:5px;">'.$meta['file_size'].'</td>';

				if($meta['tx_damivsvideobasic_status']=='0')
					$meta['tx_damivsvideobasic_status'] = $LANG->getLL("notsubmitted");
				if($meta['tx_damivsvideobasic_status']=='1')
					$meta['tx_damivsvideobasic_status'] = $LANG->getLL("wait");
				if($meta['tx_damivsvideobasic_status']=='2')
					$meta['tx_damivsvideobasic_status'] = $LANG->getLL("encodingerror");
				if($meta['tx_damivsvideobasic_status']=='3')
					$meta['tx_damivsvideobasic_status'] = $LANG->getLL("ready");

				$table .= '<td class="typo3-dblist-item" style="padding-left:5px;">'.$meta['tx_damivsvideobasic_status'].'</td>';
				$table .= '</tr>';

				$count++;
			}
		}

		$table .= '</table>';


		$theOutput.=$this->pObj->doc->spacer(5);
		$theOutput.=$this->pObj->doc->section($LANG->getLL("title"),$table,0,1);

		$theOutput.=$this->pObj->doc->divider(5);

		$menu=array();
		$menu[]=t3lib_BEfunc::getFuncCheck($this->pObj->id,"SET[tx_dam_ivs_videobasic_modfunc_status_check]",$this->pObj->MOD_SETTINGS["tx_dam_ivs_videobasic_modfunc_status_check"]).$LANG->getLL("checklabel");
		$theOutput.=$this->pObj->doc->spacer(5);
		$theOutput.=$this->pObj->doc->section("Menu",implode(" - ",$menu),0,1);

		return $theOutput;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/modfunc_file_status/class.tx_dam_ivs_videobasic_modfunc_status.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/modfunc_file_status/class.tx_dam_ivs_videobasic_modfunc_status.php']);
}

?>
