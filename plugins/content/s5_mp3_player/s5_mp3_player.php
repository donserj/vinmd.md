<?php



/**

* @file	s5_mp3_player.php - Modified from 1pixeloutplayer - duvien.com $

* @license GNU/GPL, see LICENSE.php, swf and js files are commercial and non-gpl licensed.

* Site: www.shape5.com

* Email: contact@shape5.com

* @copyright (C) 2009 Shape 5

*

*/



defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.event.plugin');

jimport('joomla.plugin.plugin');

jimport( 'joomla.html.parameter' );

// Get the application object.

$mainframe = JFactory::getApplication();

$doc = JFactory::getDocument();

$doc->addScript( JURI::base() .'plugins/content/s5_mp3_player/s5_mp3_player/s5_mp3_player.js');

//$mainframe->registerEvent( 'onPrepareContent', 's5_mp3_player' );

class plgContents5_mp3_player extends JPlugin{



	//function onContentBeforeDisplay($context, &$article, &$params, $page = 0) {
	function onContentPrepare($context, &$article, &$params, $page = 0) {	

		global $plugin;

		$regex = "#{s5_mp3(_+[a-zA-Z]+)?}(.*?){/s5_mp3(_+[a-zA-Z]+)?}#s";

		$plugin =& JPluginHelper::getPlugin('content', 's5_mp3_player');





		// perform the replacement

		$article->text = preg_replace_callback( $regex, 's5_mp3_player_replacer', @$article->text );



	}

}







function s5_mp3_player_parameterBuilder () {

	static $arParams = array();

	if (!$arParams) {

		// build the parameters list.

		$plugin =& JPluginHelper::getPlugin('content', 's5_mp3_player');
		
		$version = new JVersion();
		if($version->RELEASE <= '2.5'){
			$params = new JParameter( $plugin->params );
		}else {
			$params = new JRegistry( $plugin->params );
		}
		 
		

		$arParamNames = array('allowDownload','repeat','color_mcPlayBtn','colorhover_mcPlayBtn',

		'color_mcPauseLabel','color_mcSeparationArrow1', 'color_mcSeparationArrow2',

		'color_mcPlayLabel','color_mcMiddleBg','color_mcMiddleBg2','color_mcMiddle-mcBorder',

		'color_mcMiddle-mcBg','color_mcMiddle-mcProgress','color_mcMiddle-mcSlider',

		'color_mcSoundControl-mcSoundBack','color_mcSoundControl-mcSoundSlider',

		'color_mcDownloadBtn','colorhover_mcDownloadBtn',

		'color_mcDownloadProgress-mcBack','color_mcDownloadProgress-mcBorder','color_mcDownloadProgress-mcProgress',

		'downloadBarSpace', 'downloadBarHeight',

		'textcolor_fmtDownloadProgress','text_txtDownloadProgress_downloading','text_txtDownloadProgress_complete',

		'textcolor_fmtTime','textcolor_fmtSongName','textcolor_fmtDownload','text_txtDownload');



		foreach ($arParamNames as $sParamName) {

			if($sParamName == 'color_mcMiddleBg2' ){

				$arParams[] = "color_mcDownloadArrow=".$params->get($sParamName);

			}

			$arParams[] = $sParamName."=".$params->get($sParamName);



		}



	}

	static $playerWidth = '';

	static $playerHeight = '';

	if(!$playerWidth){

		$playerWidth = $params->get('width');

	}



	if(!$playerHeight){

		$playerHeight = $params->get('height');

	}



	static $sDefaultPath = '';

	if (!$sDefaultPath) {

		$sDefaultPath = JURI::base() . $params->get('defaultpath');  // zzz define the default path and hold it until needed

		$sDefaultPath = trim($sDefaultPath,' /'); // zzz

	}

	$arAllParams = array('sDefaultPath'=>$sDefaultPath,'playerWidth'=>$playerWidth,

	'playerHeight'=>$playerHeight,'arParams'=>$arParams);

	return $arAllParams;

}

function s5_mp3_player_replacer ( &$matches ) {



	$plugin =& JPluginHelper::getPlugin('content', 's5_mp3_player');
	
	$version = new JVersion();
	if($version->RELEASE <= '2.5'){
		$params = new JParameter( $plugin->params );
	}else {
		$params = new JRegistry( $plugin->params );
	}
	 
	



	$marginl = $params->get('marginl');

	$marginr = $params->get('marginr');

	$marginb = $params->get('marginb');

	$margint = $params->get('margint');



	$arAllParams = s5_mp3_player_parameterBuilder();

	extract ($arAllParams,EXTR_SKIP);



	global $ap_options, $ap_playerID;

	// Get next player ID

	$ap_playerID++;

	$arParams[] = "playerID=MP3Player_$ap_playerID";

	static $bAutostarted = 0;

	if (trim($matches[1])=='_auto') {

		// autostart is only engaged for the first mp3 on the page.

		if (!$bAutostarted) {

			$bAutostarted = 1;

			$arParams[] = 'autostart=1';

		}

	}
	
	$thisParams = explode("|",$matches[2]);
	$url_of_mp3 = "";
	
	if (strpos($thisParams[0],'http://')===FALSE and strpos($thisParams[0],'/')!==0) {

		// If the file is externally hosted or the path is redirected, do not use the default path

		$arParams[] = "mp3path={$sDefaultPath}/{$thisParams[0]}";
		$url_of_mp3 = "{$sDefaultPath}/{$thisParams[0]}";
		
	} else {

		if (strpos($thisParams[0],'/')===0) {

			$arParams[] = "mp3path=".JURI::base().ltrim($thisParams[0],'/');
			$url_of_mp3 = JURI::base().ltrim($thisParams[0],'/');

		} else {

			$arParams[] = "mp3path={$thisParams[0]}";
			$url_of_mp3 = $thisParams[0];

		}

	}
	
	$mobilelink = $params->get('mobilelink');
	$applelink = $params->get('applelink');
	$mobilelinktext = $params->get('mobilelinktext');
	$mobilelinkwidth = $params->get('mobilelinkwidth');
	$mobilelinkfontsize = $params->get('mobilelinkfontsize');
	$mobilelinkfontweight = $params->get('mobilelinkfontweight');
	$mobilelinkfontdecoration = $params->get('mobilelinkfontdecoration');
	$mobilelinkfontcolor = $params->get('mobilelinkfontcolor');
	$fluidwidth = $params->get('fluidwidth');
	
	$playerWidth = $playerWidth.'px';
	if ($fluidwidth == "1") {
	$playerWidth = '100%'; ?>
	<script type="text/javascript">//<![CDATA[
	window.onresize = s5_mp3_player_fluid;
	//]]></script>
	<?php } 
	
	if ($mobilelink == "1") { ?>
	<script type="text/javascript">//<![CDATA[
		document.write('<style>@media screen and (max-width: <?php echo $mobilelinkwidth; ?>px) { .s5_mp3_player_wrap { display:none !important; } .s5_mp3_player_mobile_link_wrap { display:block !important; } }</style>');
	//]]></script>
	<?php } 
	

	$res_player = '<div id="MP3Player_'.$ap_playerID.'_container" style="padding:0px; margin-left:'.$marginl.'px; margin-right:'.$marginr.'px; margin-top:'.$margint.'px; margin-bottom:'.$marginb.'px; height:'.$playerHeight.'px; width:'.$playerWidth.'" class="s5_mp3_player_wrap">

				<object type="application/x-shockwave-flash" data="'. JURI::base() .'plugins/content/s5_mp3_player/s5_mp3_player/s5_mp3_player.swf" id="MP3Player_'.$ap_playerID.'" height="100%" width="100%">

					<param name="movie" value="'. JURI::base() .'plugins/content/s5_mp3_player/s5_mp3_player/s5_mp3_player.swf" />

					<param name="FlashVars" value="'.implode('&amp;',$arParams).'" />

					<param name="quality" value="high" />

					<param name="menu" value="false" />

					<param name="wmode" value="opaque" />

				</object>

			</div>';
			
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	$show_apple_link = "no";
	if(preg_match('/iPhone|iPad|iPod/i', $agent)){ 
		$res_player = "";
		if ($applelink == "1") {
			$show_apple_link = "yes";
		}
	}
		
	if ($mobilelink == "1" || $show_apple_link == "yes") {
	$res_mobile = '<a href="'.$url_of_mp3.'" id="MP3Player_mobile_'.$ap_playerID.'_container" style="cursor:pointer; display:none; padding:0px; margin-left:'.$marginl.'px; margin-right:'.$marginr.'px; margin-top:'.$margint.'px; margin-bottom:'.$marginb.'px; font-size:'.$mobilelinkfontsize.'pt; color:#'.$mobilelinkfontcolor.'; text-decoration:'.$mobilelinkfontdecoration.'; font-weight:'.$mobilelinkfontweight.';" class="s5_mp3_player_mobile_link_wrap">'.$mobilelinktext.'</a>';
	}
	else {
	$res_mobile = "";
	}

	$res = $res_player.$res_mobile;
	
	return $res;

}

?>

