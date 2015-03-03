<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
class JMMController extends JController
{

	function display($cachable = false) 
	{
		
		parent::display($cachable);
		$viewName=JRequest::getCmd('view');
		JMMHelper::addSubmenu($viewName);		
	}

	function saveCannedQuery(){
		$mainframe=JFactory::getApplication();
		$title=JRequest::getString('title');
		$dbname=JRequest::getVar('dbname');
		$query=JRequest::getVar('query');
		$model=&$this->getModel('SQL');
		$response=$model->saveCannedQuery(JRequest::get( 'post' ));
		echo json_encode($response);
		$mainframe->close();
	}
	function saveSiteTable(){		
		$mainframe=JFactory::getApplication();
		$title=JRequest::getString('title');
		$dbname=JRequest::getVar('dbname');
		$query=JRequest::getVar('query');
		$model=&$this->getModel('SQL');
		$response=$model->saveSiteTable(JRequest::get( 'post' ));
		echo json_encode($response);
		$mainframe->close();
	}
}
