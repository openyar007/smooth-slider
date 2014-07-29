(function($) {
	jQuery.fn.smoothSlider=function(args){
		var defaults={
				sliderWidth		:900,
				sliderHeight		:320,
				navArr			:0
				
		}
		options=jQuery.extend({},defaults,args);
			this.smoothSliderSize=function(){
				var wrapWidth=jQuery(this).outerWidth(true);
				var slideri=jQuery(this).find('.smooth_slideri');
				var slideriW;
				//calculate max-width of slideri
				if(options.navArr==0) slideriW=wrapWidth;
				else slideriW=wrapWidth-(48+10); //48px for arrows and 10 for additional margin for text
				slideri.css('max-width',slideriW+'px');
				//float excerpt bellow image 
				var sldrThumb=jQuery(this).find('.smooth_slider_thumbnail');	
				var sldrThumbW=sldrThumb.outerWidth(true);
				
				if(slideriW-sldrThumbW < 70){
					sldrThumb.removeClass('smoothLeft');
					sldrThumb.addClass('smoothNone');
				}
				else{
					sldrThumb.removeClass('smoothNone');
					sldrThumb.addClass('smoothLeft');
				}
				//slider height
				var iht=0;
				jQuery(this).find(".smooth_slideri").each(function(idx,el){
					if(jQuery(el).outerHeight(true)>iht)iht=jQuery(el).outerHeight(true);
				});
				var ht=iht + jQuery(this).find(".sldr_title").outerHeight(true) + jQuery(this).find(".smooth_nav").outerHeight(true);
				jQuery(this).height(ht);
				return jQuery(this);
			};
			this.smoothSliderSize();
			self=this;
			//On Window Resize
			jQuery(window).resize(function() { 
				self.smoothSliderSize();
			});
	}
})(jQuery);
