<?php 
defined('_JEXEC') or die(); 
?>
<div class="sf-post">
	<a href="https://twitter.com/<?php echo $item->user->screen_name; ?>" class="sf-image">
		<img src="<?php echo $item->user->image; ?>" alt="<?php echo $item->user->name; ?>" class="sf-pic" />
	</a>
	<a href="https://twitter.com/<?php echo $item->user->screen_name; ?>">
		<img src="modules/mod_social_feed/assets/twitter.png" class="sf-icon" alt="Twitter">
		<h4>@<?php echo $item->user->name; ?></h4>
	</a>
	<p><?php echo $item->text; ?></p> 
	<a href="https://twitter.com/<?php echo $item->user->screen_name; ?>/status/<?php echo $item->post_id; ?>" target="_blank"><?php echo $item->time_ago; ?></a>
</div>