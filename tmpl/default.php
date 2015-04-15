<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_custom
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$file = JURI::base().'modules/mod_counter/counter.txt';

if($type == 'd'){
    $value = (!is_null($params->get('moduletime_value_date'))) ? $params->get('moduletime_value_date') : '00/00/0000 00:00:00';
}else{
    $value = $getCount->count;
}
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="<?php echo JURI::base() . 'modules/mod_counter/js/jquery.counter.js'; ?>"></script>
<link rel="stylesheet" href="<?php echo JURI::base() . 'modules/mod_counter/css/counter.css'; ?>" type="text/css" />

<div class="counter<?php echo $moduleclass_sfx ?>">
    <div id="clock"></div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery('#clock').counter({
           value: '<?php echo $value; ?>',
           of: '<?php echo $of; ?>',
           to: '<?php echo $to; ?>',
           theme:'<?php echo $theme;?>', 
           time:'<?php echo $speed;?>',
           type:'<?php echo $type;?>',
           counting: '<?php echo $params->get('module_counting');?>'
       });
    });
</script>
