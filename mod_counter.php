<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

modCounterHelper::eventScheduled();

if ($params->def('prepare_content', 1))
{
	JPluginHelper::importPlugin('content');
	$module->content = JHtml::_('content.prepare', $module->content, '', 'mod_counter.content');
}

$type  = $params->get('module_type');
$speed = (!is_null($params->get('moduletime_speed'))) ? $params->get('moduletime_speed') : '1000';
$theme = (!is_null($params->get('theme'))) ? $params->get('theme') : 'blue';
$of = $params->get('moduletime_value_of');
$to = $params->get('moduletime_value_to');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$getScheduled = modCounterHelper::getScheduled($params);
//echo '<!-- Event ';
//echo var_dump(modCounterHelper::dropScheduled());
//echo '-->';

if($type == 'n'){
    
    if($params->get('module_counting') == '1'){
        
        if($getScheduled){ //SE TIVER AGENDAMENTO PRA CONTAR

            $getCount = modCounterHelper::getCount($params);
            if($getCount){
                if($getCount->ofbegin != $of){ //SE ADMINISTRADOR INSERIU NOVA CONTAGEM
                    modCounterHelper::updateCount($params);
                    modCounterHelper::updateScheduled($params);
                }
                
                if($getCount->intervaltime != $speed){
                    //modCounterHelper::updateCount($params);
                    modCounterHelper::updateCountIntervalTime($params);
                    modCounterHelper::updateScheduled($params);
                }
                
            }else{
                modCounterHelper::setCount($params);
                modCounterHelper::setScheduled($params);
            }

            if($getCount->count >= $getCount->toend){
                modCounterHelper::dropScheduled();
            }
        }else{ //SE NAO TIVER AGENDAMENTO PRA CONTAR

            $getCount = modCounterHelper::getCount($params);
            if($getCount){ //SE TABELA COUNTER NAO TIVER VAZIA
                modCounterHelper::updateCount($params);
            }else{
                modCounterHelper::setCount($params);
            }
            
            modCounterHelper::setScheduled($params);
            
        }
    }else{
        $getCount = modCounterHelper::getCount($params);
        modCounterHelper::dropScheduled();
    }
    
}

require JModuleHelper::getLayoutPath('mod_counter', $params->get('layout', 'default'));