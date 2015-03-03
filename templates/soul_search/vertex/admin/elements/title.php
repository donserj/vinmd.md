<?php
/**
 * @version		$Id: spacer.php 20972 2011-03-16 13:57:36Z chdemko $
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('JPATH_BASE') or die;

/**
 * Renders a spacer element
 *
 * @package		Joomla.Framework
 * @subpackage	Parameter
 * @deprecated	JParameter is deprecated and will be removed in a future version. Use JForm instead.
 * @since		1.5
 */

class JElementTitle extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Title';

	function fetchTooltip($label, $description, &$node, $control_name, $name) {
		return '&#160;';
	}

	function fetchElement($name, $value, &$node, $control_name)
	{
		if ($value) {
			return JText::_($value);
		} else {
			return '&nbsp;';
		}
	}
}