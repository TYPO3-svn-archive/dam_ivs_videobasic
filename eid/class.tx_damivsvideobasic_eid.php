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

require_once(t3lib_extMgm::extPath('dam_ivs_videobasic').'/3rdparty/jsonrpcphp/jsonRPCServer.php');

define('LOCATION_LOCAL',0);

/**
 * Plugin 'Media (DAM) Video Basic' for the 'dam_ivs_videobasic' extension.
 *
 * @author	Sebastian Siebert <ss@imagine-vs.de>
 * @package	TYPO3
 * @subpackage	tx_damivsvideobasic
 */
class tx_damivsvideobasic_eID
{

    /**
     * The main method of the PlugIn
     *
     * @param    string        $content: The PlugIn content
     * @param    array        $conf: The PlugIn configuration
     * @return    The content that is displayed on the website
     */
	public function main($video,$screenshots)
	{
		// generate database connection
		tslib_eidtools::connectDB();
		// get database entry of video file
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_dam','uid='.$video['damid']);
		$dam = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// set path for encoded video and screenshots
		$pathToEncodedVideo = PATH_site.$dam['file_path'].'encoded_basic_'.$dam['file_name'];
		// make new directory for encoded video and screenshots
		t3lib_div::mkdir($pathToEncodedVideo);

		// if local streaming...
		if($video['location']==LOCATION_LOCAL)
		{

			// routine for saving videos from encoding server
			$ch = curl_init($video['filenamestream']);
			$fp = fopen($pathToEncodedVideo.'/'.basename($video['filenamestream']),'w');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);
			unset($ch);
			unset($fp);
			tx_dam::index_autoProcess($pathToEncodedVideo.'/'.basename($video['filenamestream']));

			// routine for saving screenshots from encoding server
			foreach($screenshots as $screenshot)
			{
				$ch = curl_init($screenshot);
				$fp = fopen($pathToEncodedVideo.'/'.basename($screenshot),'w');
				curl_setopt($ch, CURLOPT_FILE, $fp);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
				fclose($fp);
				unset($ch);
				unset($fp);
				tx_dam::index_autoProcess($pathToEncodedVideo.'/'.basename($screenshot));
			}

			$update = array('tx_damivsvideobasic_streamdir' => $pathToEncodedVideo.'/',
						'tx_damivsvideobasic_filenamestream' => basename($video['filenamestream']),
						'tx_damivsvideobasic_width' => $video['width'],
						'tx_damivsvideobasic_height' => $video['height'],
						'tx_damivsvideobasic_status' => '3');
		}

		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_dam','uid='.$video['damid'],$update);

		return 'ok';
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/eid/class.tx_damivsvideobasic_eid.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ivs_video_basiccessing/pi1/class.tx_damivsvideobasic_eid.php']);
}

$SOBE = t3lib_div::makeInstance('tx_damivsvideobasic_eID');

jsonRPCServer::handle($SOBE)
	or print 'no request';

?>
