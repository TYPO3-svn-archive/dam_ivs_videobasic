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
 * @subpackage	tx_damivsvideobasic_procdm
 */
class tx_damivsvideobasic_procdm
{
	// extension key
	protected $extKey = 'dam_ivs_videobasic';


	/**
	 * Preprocess (p.e. prepare data-structure)
	 *
	 * @param	string			$fieldArray	All changed fields and values
	 * @param	string			$table		Table name
	 * @param	int				$id			Record uid
	 * @param	t3lib_TCEmain	$pObj		Reference to parent object
	 * @return	void			Nothing
	 */
	public function processDatamap_preProcessFieldArray(&$fieldArray, $table, $id, &$pObj)
	{

	}

	/**
	 * Postprocess (p.e. after setting data)
	 *
	 * @param	string			$status		Get status
	 * @param	string			$table		Table name
	 * @param	int				$id			Record uid
	 * @param	string			$fieldArray	All changed fields and values
	 * @param	t3lib_TCEmain	$pObj		Reference to parent object
	 * @return	void			Nothing
	 */
	public function processDatamap_postProcessFieldArray ($status,$table,$id,&$fieldArray,&$pObj)
	{

		// if table is tx_dam...
		if($table == 'tx_dam')
		{
			// unserialize the configuration of this extension
			$conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

			// extract all database columns to a variable for easily access to data
			@extract(t3lib_BEfunc::getRecord($table,$id,'file_path,file_name,tx_damivsvideobasic_encode,tx_damivsvideobasic_location'));

			// if the field encode = 1 or location is set...
			if( (isset($fieldArray['tx_damivsvideobasic_encode']) && $fieldArray['tx_damivsvideobasic_encode']=='1'))
			{
				// get extension path
				$extPath = t3lib_extMgm::extPath($this->extKey);
				// include the needed json RPC Client
				require_once($extPath.'/3rdparty/jsonrpcphp/jsonRPCClient.php');

				// set extension key for ext_emconf.php
				$_EXTKEY = $this->extKey;
				// include the ext_emconf.php
				require_once($extPath.'/ext_emconf.php');

				// create a instance of a class "json RPC Client"
				$client = new jsonRPCClient($conf['urlServer'].'/typo3video.php');

				// set extension information for encoding server
				$extInfo = array('exttitle' => trim($EM_CONF[$this->extKey]['title']),
							'extversion' => trim($EM_CONF[$this->extKey]['version']));

				// if is set location, then set location from new input
				if(isset($fieldArray['tx_damivsvideobasic_location']))
				    $tx_damivsvideobasic_location = $fieldArray['tx_damivsvideobasic_location'];

				// set video information for encoding server
				$video = array('projecthash' => $conf['projectHash'],
							'damid' => $id,
							'urlserver' => t3lib_div::getIndpEnv(TYPO3_REQUEST_HOST),
							'uploaddir' => $file_path,
							'filenameupload' => $file_name,
							'fixwidth' => $conf['fixwidth'],
							'screenshots' => $conf['screenshots'],
							'location' => $tx_damivsvideobasic_location,
							'status' => '0');

				// try to send commitVideo command to encoding server
				try
				{
					$response = $client->commitVideo($extInfo, $video);
					$fieldArray['tx_damivsvideobasic_status'] = 1;
				}
				catch (Exception $e) {
					$fieldArray['tx_damivsvideobasic_status'] = 2;
					$results['error'] = $e->getMessage();
					t3lib_div::devLog('response', $this->extKey, 1, $results);
				}

			}
		}

		$dataVar = array($conf);

		//$results = array('status' => $status, 'table' => $table, 'id' => $id, 'fieldArray' => $fieldArray, 'pObj' => $pObj);
		//t3lib_div::devLog('values', $this->extKey, 1, $results);

	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_procdm.php'])
{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/hooks/class.dam_ivs_videobasic_procdm.php']);
}

?>
