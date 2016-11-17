(function ( $ ) {
	$.fn.slider = function(opt) {	
		
		opt = $.extend({}, $.fn.slider.defaults, opt);
		
		$.wait = function( callback, seconds){
		   return window.setTimeout( callback, seconds )
		};
		
		$.interval = function( callback, seconds){
		   return window.setInterval( callback, seconds )
		};	
					
		return this.each(function(){
			var $this 	= $(this);	
			var $parent = $this.find(opt.parent);
						
			$.next = function(){
				var $list  = $parent.find(opt.list);	
				var $item  = $list.eq(0);				
				var $clone = $item.clone();
				$parent.append($clone);
				$item.addClass(opt.hide);
				
				$.wait(function(){	
					$item.remove();
				}, opt.transitionTime);	
			}
						
			$.prev = function(){
				var $list 	= $parent.find(opt.list);	
				var $item 	= $list.eq(($list.length-1));
				var $clone	= $item.clone();
				
				$clone.addClass(opt.hide);
				$parent.prepend($clone);
								
				$.wait(function(){	
					$item.remove();
					$clone.removeClass(opt.hide);
				}, opt.transitionTime);		
			}			
			
			if(opt.auto) {
				$.interval($.next, opt.wait);
			}
			
			if(opt.next){			
				$this.find(opt.next).click($.next);
			}
			
			if(opt.prev){
				$this.find(opt.prev).click($.prev);
			}
			
		});			
	};	
		
	/* Defaults */

	$.fn.slider.defaults = {
		parent: 'ul',
		list: 'li',
		hide: 'slider-hide',
		auto: true,
		wait: 5000,
		transitionTime: 500,
		next: false,
		prev: false
	}

	$(document).ready(function() { 
				
		$.wait = function( callback, seconds){
		   return window.setTimeout( callback, seconds )
		};
		
		$.interval = function( callback, seconds){
		   return window.setInterval( callback, seconds )
		}; 
					
		$('.social-feed').slider({
			parent: 'ul',
			list: 'li',
			hide: 'slider-hide',
			wait: 5000	
		});
		
	});
	
}( jQuery ));