<?php
defined('_JEXEC') or die();

require_once __DIR__ . '/helpers/twitter/feed.php';		
require_once __DIR__ . '/helpers/facebook/page.php';		
require_once __DIR__ . '/helpers/facebook.php';
require_once __DIR__ . '/helpers/twitter.php';		

abstract class SocialHelper
{	
	public static function getList($params)
	{		
		$self = get_called_class();
		
		$cache = JFactory::getCache($self);
		$cache->setCaching(1);
		$cache->setLifeTime($params->get('cache_time'));	
		
		$list = $cache->call( array( $self, 'getListDefault' ), $params );
							
		return $list;
	}
	
	public static function getListDefault($params)
	{
		$self = get_called_class();
		
		$cache = JFactory::getCache($self);
		$cache->setCaching(1);	
		$cache->setLifeTime($params->get('cache_time'));
		
		$list = new stdClass;	
		$list->hash = array();
		$list->feed = array();
		$list->facebook = $self::sortRepeatable($params->get('facebook'));
		$list->twitter  = $self::sortRepeatable($params->get('twitter'));
								
		foreach($list as $feed => &$data) : 
			foreach($data as $key => &$account) :	
				$account->data = $cache->call( array( $self, 'cleanFeed'), $cache->call( array( $feed, 'loadFeed' ), $account->name ), $feed);
				
				if(is_array($account->data)) : 				
					$list->feed = array_merge($list->feed, $account->data);		
				endif;				
				
			endforeach;		
		endforeach;
		
		$list->feed = array_slice($self::sortFeed($list->feed), 0, 20);		
		$list->hash = md5(serialize($list));
				
		return $list;
	}
	
	public static function cleanFeed($data, $type)
	{		
		$self = get_called_class();
		
		if(!$data || !$type)
		{
			return false;
		}
		
		foreach($data as &$item)
		{	
			switch($type) 
			{
				case 'twitter' :
					$i 						= new stdClass;
					$i->post_id				= $item->id_str;
					$i->type 				= $type;
					$i->text 				= $item->text;
					$i->created 			= strtotime($item->created_at);
					$i->time_ago			= $self::getDateString($item->created_at);
					$i->user				= new stdClass;
					$i->user->id			= $item->user->id;
					$i->user->name			= $item->user->name;
					$i->user->screen_name	= $item->user->screen_name;
					$i->user->image			= str_replace('normal','bigger', $item->user->profile_image_url);					
					break;
				case 'facebook' :
					$item->id = explode('_',$item->id);
					$i 				= new stdClass;	
					$i->post_id		= $item->id[1];
					$i->type 		= $type;
					$i->text 		= isset($item->message) ? $item->message : $item->story ;
					$i->created 	= strtotime($item->created_time);
					$i->time_ago	= $self::getDateString($item->created_time);
					$i->user		= new stdClass;
					$i->user->id	= $item->from->id;
					$i->user->name	= $item->from->name;	
					break;
			}
	
			$item = $i;	
		}
		
		foreach($data as &$item)
		{
			if(strlen($item->text) > 100)
			{
				$item->text = substr($item->text, 0, 100);
				$item->text = substr($item->text, 0, strrpos($item->text, ' '));
				$item->text .= '...';
			}
			$pattern = '@((https://)+([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@';
			$replacement = "<a href=\"$1\" target=\"_blank\">$1</a>";
			$item->text = preg_replace($pattern, $replacement, $item->text);
			
			$pattern = '@((http://)+([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.\,]*(\?\S+)?)?)*)@';
			$replacement = "<a href=\"$1\" target=\"_blank\">$1</a>";
			$item->text = preg_replace($pattern, $replacement, $item->text);
			
			$pattern = ' /@([A-Za-z0-9_]+)/';
			$replacement = "<a href=\"https://twitter.com/$1\" target=\"_blank\">@$1</a>";
			$item->text = preg_replace($pattern, $replacement, $item->text);
			
			$pattern = '/#([A-Za-z0-9_]+)/';
			$replacement = "<a href=\"https://twitter.com/search?q=%23$1&amp;src=hash\" target=\"_blank\">#$1</a>";
			$item->text = preg_replace($pattern, $replacement, $item->text);
		}
		return $data;
	}
	
	public static function sortFeed(&$feed)
	{	
		$self = get_called_class();
		
		usort($feed, function($a, $b)
		{
			return strcmp($b->created, $a->created);
		});
	
		return $feed;
	}
	
	public static function sortRepeatable($data = null)
	{			
		$self = get_called_class();
	
		if(!$data) 
		{
			return false;
		}
	
		$data = json_decode($data);
		$list = array();
		
		foreach($data as $key => $item) :
			foreach($item as $k => $i) :

				if(empty($list[$k])) :
					$list[$k] = new stdClass;
				endif;		
				$list[$k]->$key = $i;
				$list[$k]->data = array();
				

			endforeach;
		endforeach;

		return $list;			
	}	
	
	public static function getDateString($date)
	{	
		$self = get_called_class();
		
		$date = strtotime($date);		
		$now = time();
		
		if($date < $now) {		
				$diff_int = ($now - $date) / 3600;		
				if($diff_int < 1) {		
				$time_ago = 'just now';		
			}else if(($diff_int < 24) && $diff_int > 1) {	
				$time_ago  = '' . floor($diff_int) . ' hours ago';				
			} elseif(($diff_int > 24) && $diff_int < 168) {	
				$days = $diff_int / 24;		
				if($days < 2) {		
					$time_ago  = '1 day ago';				
				} else {					
					$time_ago  = floor($days) . ' days ago';			
				}								
			} else {			
				$weeks = $diff_int / 169;
				if($weeks <= 2) {	
					$time_ago = floor($weeks) . ' week ago';			
				} else {						
					$time_ago = floor($weeks) . ' weeks ago';					
				}									
			}			
		}			
		return $time_ago;		
	}
}