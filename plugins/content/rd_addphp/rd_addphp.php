<?php
/** ensure this file is being included by a parent file */
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.plugin.plugin');

class plgContentRd_AddPhp extends JPlugin
{
	public function onContentBeforeDisplay($contex, &$row, &$params, $page=0 )
	{

		// expression to search for
		$regex = '/{(rdaddphp)\s*(.*?)}/i';

		$plugin =& JPluginHelper::getPlugin('content', 'rd_addphp');

		// find all instances of plugin and put in $matches
		$matches = array();

		if($row->text) $text=&$row->text;
		else $text=&$row->introtext;
		
		preg_match_all( $regex, $text, $matches, PREG_SET_ORDER );

		foreach ($matches as $elm) {

			parse_str( $elm[2], $args );
			$phpfile=@$args['file'];
			$output = "";		
			if ( $phpfile ) {
				$phpfile = JPATH_ROOT . DS . $phpfile;	
				if (file_exists($phpfile)) {				
					ob_start();
					include($phpfile);
					$output .= ob_get_contents();
					ob_end_clean();
				} else {
					$output = "File: $phpfile don't exists";
				}
			}
			$text = preg_replace($regex, $output, $text, 1);
		}

	}
/* EOF */
}
?>