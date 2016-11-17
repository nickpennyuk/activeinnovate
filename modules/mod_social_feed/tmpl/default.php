<?php 
defined('_JEXEC') or die(); 

$doc = JFactory::getDocument();
$doc->addScript('modules/mod_social_feed/assets/jquery.slider.js');

?>
<div class="social-feed moduletable hidden-xs<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if($module->showtitle) : ?> 
	<h3><img src="<?php echo $item->type; ?>" alt="" /><?php echo $module->title; ?></h3>	
	<?php endif; ?>
	<ul>
	<?php foreach($list->feed as $key => &$item) : ?>
		<li>
			<?php require JModuleHelper::getLayoutPath('mod_social_feed', 'default_'.$item->type); ?>
		</li>
	<?php endforeach; ?>
	</ul>
</div>