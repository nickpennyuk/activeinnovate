<?php 
defined('_JEXEC') or die(); 
?>
<div class="sf-post">
	<a href="https://facebook.com/<?php echo $item->user->id; ?>" class="sf-image">
		<img src="http://graph.facebook.com/<?php echo $item->user->id; ?>/picture?type=normal" alt="<?php echo $item->user->name; ?>" class="sf-pic" />
	</a>
	<a href="https://facebook.com/<?php echo $item->user->id; ?>">
		<h4><?php echo $item->user->name; ?></h4>
	</a>
	<p><?php echo $item->text; ?></p>
	<a href="https://facebook.com/<?php echo $item->user->id; ?>/posts/<?php echo $item->post_id; ?>" target="_blank"><?php echo $item->time_ago; ?></a>
</div>