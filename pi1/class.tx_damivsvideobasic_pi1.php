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

require_once(PATH_tslib.'class.tslib_pibase.php');
//include_once($_SERVER['DOCUMENT_ROOT'].'/typo3/contrib/jsonrpcphp/jsonRPCClient.php');

/**
 * Plugin 'Media (DAM) Video Basic' for the 'dam_ivs_videobasic' extension.
 *
 * @author	Sebastian Siebert <ss@imagine-vs.de>
 * @package	TYPO3
 * @subpackage	tx_damivsvideobasic_pi1
 */
class tx_damivsvideobasic_pi1 extends tslib_pibase {
	// same as class name
    var $prefixId = 'tx_damivsvideobasic_pi1';
	// path to this script relative to the extension dir
    var $scriptRelPath = 'pi1/class.tx_damivsvideobasic_pi1.php';
	// the extension key
    var $extKey = 'dam_ivs_videobasic';
	// set CHash true
    var $pi_checkCHash = TRUE;

    /**
     * The main method of the PlugIn
     *
     * @param    string        $content: The PlugIn content
     * @param    array        $conf: The PlugIn configuration
     * @return    The content that is displayed on the website
     */
    function main($content,$conf)
	{
		// get typoscript configuration
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		// set the ampersand for special html version
		if($this->conf['ampersand']=='xhtml')
		    $ampersand = '&amp;';
		else if($this->conf['ampersand']=='html')
		    $ampersand = '&';

		// set uid from this object
		$uid = $this->cObj->data['uid'];
		// get the information about image orientating
		$imageorient = $this->cObj->data['imageorient'];

		// get the id from video in relation by tt_content object
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local AS uid','tx_dam_mm_ref',' uid_foreign='.$uid.' AND tablenames=\'tt_content\'','','','1');
		$damrelation = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// get all information about the video from relation
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_dam',' uid='.$damrelation['uid'],'','','1');
		$metainfo = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// get the id from screenshot in relation by tx_dam object
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid_local AS uid','tx_dam_mm_ref',' uid_foreign='.$damrelation['uid'].' AND tablenames=\'tx_dam\'','','','1');
		$damrelation = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// get all information about the screenshot from relation
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*','tx_dam',' uid='.$damrelation['uid'],'','','1');
		$metainfo2 = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// choose the classname to image orientating
		if($imageorient==0)
			$position = 'video_center';
		else if($imageorient==1)
			$position = 'video_right';
		else if($imageorient==2)
			$position = 'video_left';

		$flash = '';

		// set url from local
		$videoURL = urlencode('/'.str_replace(PATH_site,'',$metainfo['tx_damivsvideobasic_streamdir']).$metainfo['tx_damivsvideobasic_filenamestream']);

		// set start random md5sum for difference videos
		mt_srand($this->make_seed());
		$md5 = md5(mt_rand());

		// create a flash html output
		$flash = '<div id="video_'.$md5.'"></div>
<script type="text/javascript">
swfobject.embedSWF(
    "http://'.$_SERVER['HTTP_HOST'].'/'.t3lib_extMgm::siteRelPath($this->extKey).'res/flash/NonverBlaster.swf","video_'.$md5.'",
    "'.$metainfo['tx_damivsvideobasic_width'].'",
    "'.$metainfo['tx_damivsvideobasic_height'].'",
    "9.0.0",
    "",
    {
	videoURL: \''.$videoURL.'\',
	teaserURL: \''.urlencode('/'.$metainfo2['file_path'].$metainfo2['file_name']).'\',
	allowSmoothing: \''.$this->conf['flashVars.']['allowsmoothing'].'\',
	autoPlay: \''.$this->conf['flashVars.']['autoplay'].'\',
	buffer: \''.$this->conf['flashVars.']['buffer'].'\',
	showTimeCode: \''.$this->conf['flashVars.']['showtimecode'].'\',
	loop: \''.$this->conf['flashVars.']['loop'].'\',
	controlColour: \''.$this->conf['flashVars.']['controlcolour'].'\',
	scaleIfFullscreen: \''.$this->conf['flashVars.']['scaleiffullscreen'].'\',
	showScalingButton: \''.$this->conf['flashVars.']['showscalingbutton'].'\'
    },
    {
	quality: \''.$this->conf['flashParams.']['quality'].'\',
	allowScriptAccess: \''.$this->conf['flashParams.']['allowscriptaccess'].'\',
	wmode: \''.$this->conf['flashParams.']['wmode'].'\',
	swLiveConnect: \''.$this->conf['flashParams.']['swliveconnect'].'\',
	allowfullscreen: \''.$this->conf['flashParams.']['allowfullscreen'].'\',
	scale: \''.$this->conf['flashParams.']['scale'].'\'
    });
</script>';

		// set the contents in template with own placeholder
		$template = $this->conf['videoTemplate'];
		$template = str_replace('###FLASHVIDEO###',$flash,$template);

		$template = str_replace('###TITLE###',$this->pi_getLL("title"),$template);
		$template = str_replace('###VIDEO_TITLE###',$metainfo['title'],$template);
		$template = str_replace('###DESCRIPTION###',$this->pi_getLL("description"),$template);
		$template = str_replace('###VIDEO_DESCRIPTION###',$metainfo['description'],$template);

		$content = '';
		$content .= '<div class="'.$position.'">';
		$content .= $template;
		$content .= '</div>';

		$GLOBALS['TSFE']->additionalHeaderData[] = '<script type="text/javascript" src="/typo3conf/ext/dam_ivs_videobasic/res/js/swfobject.js"></script>';

		return $this->pi_wrapInBaseClass($content);
    }

	// needed by randomize numbers
    public function make_seed()
    {
	    list($usec, $sec) = explode(' ', microtime());
	    return (float) $sec + ((float) $usec * 100000);
    }
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/pi1/class.tx_damivsvideobasic_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/dam_ivs_videobasic/pi1/class.tx_damivsvideobasic_pi1.php']);
}

?>