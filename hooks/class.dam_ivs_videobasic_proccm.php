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
 * Plugin 'Media (DAM) Video Basic' for the 'dam_ivs_videobasic' extension.
 *
 * @author	Sebastian Siebert <ss@imagine-vs.de>
 * @package	TYPO3
 * @subpackage	tx_damivsvideobasic_proccm
 */
class tx_damivsvideobasic_proccm
{

	/**
	 * Preprocess (p.e. prepare data-structure)
	 *
	 * @param	string			$command	Command
	 * @param	string			$table		Table name
	 * @param	int				$id			Record uid
	 * @param	mixed			$value		Unused
	 * @param	t3lib_TCEmain	$pObj		Reference to parent object
	 * @return	void			Nothing
	 */
	public function processCmdmap_preProcess($command, &$table, &$id, &$value, &$pObj)
	{
		//$dataVar = array('command' => $command, 'table' => $table, 'id' => $id, 'value' => $value, 'pObj' => $pObj);
		//t3lib_div::devLog('tx_damivsvideobasic_proccm->processCmdmap_preProcess', 'tx_damivsvideobasic', 1, $dataVar);
	}

	/**
	 * Postprocess (p.e. remove all relations of this plugin)
	 *
	 * @param	string			$command	Command
	 * @param	string			$table		Table name
	 * @param	int				$srcId		Record uid
	 * @param	mixed			$destId		Unused
	 * @param	t3lib_TCEmain	$pObj		Reference to parent object
	 * @return	void			Nothing
	 */
	public function processCmdmap_postProcess($command, $table, $srcId, $destId, &$pObj)
	{
		//$dataVar = array('command' => $command, 'table' => $table, 'srcId' => $srcId, 'destId' => $destId, 'pObj' => $pObj);
		//t3lib_div::devLog('tx_damivsvideobasic_proccm->processCmdmap_preProcess', 'tx_damivsvideobasic', 1, $dataVar);
	}
	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_proccm.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_proccm.php']);
}


?>
