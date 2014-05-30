var smooth_waitForFinalEvent = (function () {
  var smooth_timers = {};
  return function (callback, ms, uniqueId) {
    if (!uniqueId) {
      uniqueId = "Don't call this twice without a uniqueId";
    }
    if (smooth_timers[uniqueId]) {
      clearTimeout (smooth_timers[uniqueId]);
    }
    smooth_timers[uniqueId] = setTimeout(callback, ms);
  };
})();
jQuery.fn.smoothSliderHeight=function(){
	var iht=0;
	jQuery(this).find(".smooth_slideri").each(function(idx,el){
		if(jQuery(el).outerHeight(true)>iht)iht=jQuery(el).outerHeight(true);
	});
	var ht=iht + jQuery(this).find(".sldr_title").outerHeight(true) + jQuery(this).find(".smooth_nav").outerHeight(true);
	jQuery(this).height(ht);
	return jQuery(this);
};