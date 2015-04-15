<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_archive
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modCounterHelper
{
        static function eventScheduled()
	{
		$db		= JFactory::getDbo();
                $query = "SET GLOBAL event_scheduler = ON";
                $db->setQuery($query);
                $db->query();
	}
        
	static function getScheduled(&$params)
	{
		$db		= JFactory::getDbo();
                $db_name        = JFactory::getConfig();
                
		$query	= $db->getQuery(true);
		$query->select("*");
		$query->from("INFORMATION_SCHEMA.EVENTS");
		$query->where("EVENT_NAME='e_count_ts'");
		$query->where("EVENT_SCHEMA=" . $db->Quote($db_name->get('db')));

                $db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows;
	}
        
	static function setScheduled(&$params)
	{
                $time = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '5';
		$db = JFactory::getDbo();
                $query = "CREATE EVENT e_count_ts"
                       . " ON SCHEDULE"
                       . " EVERY $time SECOND"
                       . " DO"
                       . " UPDATE #__counter SET count=count+1"
                       ;
                $db->setQuery($query);
                $db->query();
	}
        
	static function dropScheduled()
	{
		$db             = JFactory::getDbo();
                $db_name        = JFactory::getConfig();
                
                $query = "DROP EVENT e_count_ts WHERE EVENT_SCHEMA = " . $db->Quote($db_name->get('db'));
                $db->setQuery($query);
                $db->query();
	}
        
	static function updateScheduled(&$params)
	{
                $time = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '1';
		$db = JFactory::getDbo();
                $query = "ALTER EVENT e_count_ts"
                       . " ON SCHEDULE"
                       . " EVERY $time SECOND"
                       . " DO"
                       . " UPDATE #__counter SET count=count+1"
                       ;
                $db->setQuery($query);
                $db->query();
	}
        
	static function getCount()
	{
                $db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select("*");
		$query->from("#__counter");
//		$query->where("id = 1");

                $db->setQuery($query);
		$row = $db->loadObject();

		return $row;
	}
        
	static function setCount(&$params)
	{
                $of = $params->get('moduletime_value_of');
                $to = $params->get('moduletime_value_to');
                $interval = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '5000';
                
                $db		= JFactory::getDbo();
		$query = $db->getQuery(true);
                
                $columns = array('count', 'ofbegin', 'toend', 'intervaltime');
                $values = array($of, $of, $to, $interval);
                
                $query->insert("#__counter");
                $query->columns($db->quoteName($columns));
                $query->values(implode(",", $values));

                $db->setQuery($query);
                $db->query();
	}
        
	static function updateCount(&$params)
	{
                $of = $params->get('moduletime_value_of');
                $to = $params->get('moduletime_value_to');
                $interval = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '5000';
                
                $db		= JFactory::getDbo();
		$query = $db->getQuery(true);
                $query->update('#__counter');
                $query->set('count = '.$db->Quote($of));
                $query->set('ofbegin = '.$db->Quote($of));
                $query->set('toend = '.$db->Quote($to));
                $query->set('intervaltime = '.$db->Quote($interval));
                
                $db->setQuery($query);
                $db->query();
	}
        
	static function updateCountIntervalTime(&$params)
	{
                $interval = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '5000';
                
                $db		= JFactory::getDbo();
		$query = $db->getQuery(true);
                $query->update('#__counter');
                $query->set('intervaltime = '.$db->Quote($interval));
                
                $db->setQuery($query);
                $db->query();
	}
}
