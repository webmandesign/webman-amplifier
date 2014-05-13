/**
 * WebMan Slideshow shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */

jQuery(function(){function a(a){a.children().each(function(a,b){jQuery(b).parent().prepend(jQuery(b))})}jQuery().owlCarousel?jQuery(".wm-slideshow").each(function(){var c=jQuery(this),d=c.find(".wm-slideshow-container"),e=c.data("speed")?c.data("speed")+500:3500,f=d.data("pager")?d.data("pager"):!1,g=c.data("nav")&&!f?!0:!1,h=800,i="undefined"!=typeof i?i:!1;d.owlCarousel({autoPlay:e,stopOnHover:!0,navigation:!0,navigationText:["<",">"],pagination:g,slideSpeed:h,paginationSpeed:h,rewindSpeed:h,autoHeight:c.hasClass("auto-height"),singleItem:!0,transitionStyle:i,afterInit:function(){if(f){var a=jQuery(f+" > a").on("click",function(a){a.preventDefault()});jQuery.each(this.owl.userItems,function(b){jQuery(a[b]).on("click",function(){d.trigger("owl.goTo",b)})})}},autoPlayDirection:"rtl"!=jQuery("html").attr("dir")?!1:"rtl",startPosition:"rtl"!=jQuery("html").attr("dir")?!1:-1,beforeInit:"rtl"!=jQuery("html").attr("dir")?!1:a})}):jQuery().bxSlider&&jQuery(".wm-slideshow").each(function(){var b=jQuery(this),c=b.find(".wm-slideshow-container"),d=b.data("speed")?b.data("speed")+500:3500,e=b.data("nav")?!0:!1,f=c.data("pager")?c.data("pager"):null;c.bxSlider({mode:"rtl"!=jQuery("html").attr("dir")?"horizontal":"fade",pause:d,auto:!0,autoHover:!0,controls:!0,pager:e,pagerCustom:f,adaptiveHeight:b.hasClass("auto-height"),useCSS:!1})})});