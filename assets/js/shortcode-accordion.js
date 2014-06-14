/**
 * WebMan Accordion shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 * @version     1.0.9
 */

jQuery(function(){var a=jQuery('div[data-mode="accordion"]');a.find(".wm-item-content").hide(),a.each(function(){var a=jQuery(this),b=a.find(".wm-item").length;0<a.data("active")&&b>=a.data("active")&&(a.find(".wm-item").eq(a.data("active")-1).toggleClass("active"),a.find(".wm-item-content").eq(a.data("active")-1).show())}),a.on("click",".wm-item-title",function(){var b=jQuery(this);b.parent(".wm-item").toggleClass("active").siblings().removeClass("active").find(".wm-item-content").slideUp(),b.next(".wm-item-content").slideToggle()});var b=jQuery('div[data-mode="toggle"]');b.find(".wm-item-content").hide(),b.each(function(){var a=jQuery(this),b=a.find(".wm-item").length;0<a.data("active")&&b>=a.data("active")&&(a.find(".wm-item").eq(a.data("active")-1).toggleClass("active"),a.find(".wm-item-content").eq(a.data("active")-1).show())}),b.on("click",".wm-item-title",function(){var b=jQuery(this);b.parent(".wm-item").toggleClass("active"),b.next(".wm-item-content").slideToggle()});var d=(jQuery(".filterable-simple"),jQuery(".filterable-simple .wm-filter"));d.on("click","a",function(a){a.preventDefault();var b=jQuery(this),c=b.closest(".wm-filter").next(".wm-filter-this-simple");b.parent().hasClass("active")||(b.parent().addClass("active").siblings().removeClass("active"),"*"==b.data("filter")?c.children(".wm-item").slideDown():(c.children(".wm-item"+b.data("filter")).slideDown(),c.children(".wm-item").not(b.data("filter")).slideUp()))})});