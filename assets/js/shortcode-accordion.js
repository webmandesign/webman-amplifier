/**
 * WebMan Accordion shortcode scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */

jQuery(function(){var e=jQuery('div[data-behaviour="accordion"]');e.find(".wm-item-content").hide();e.each(function(){var e=jQuery(this),t=e.find(".wm-item").length;if(0<e.data("active")&&t>=e.data("active")){e.find(".wm-item").eq(e.data("active")-1).toggleClass("active");e.find(".wm-item-content").eq(e.data("active")-1).show()}});e.on("click",".wm-item-title",function(e){var t=jQuery(this);t.parent(".wm-item").toggleClass("active").siblings().removeClass("active").find(".wm-item-content").slideUp();t.next(".wm-item-content").slideToggle()});var t=jQuery('div[data-behaviour="toggle"]');t.find(".wm-item-content").hide();t.each(function(){var e=jQuery(this),t=e.find(".wm-item").length;if(0<e.data("active")&&t>=e.data("active")){e.find(".wm-item").eq(e.data("active")-1).toggleClass("active");e.find(".wm-item-content").eq(e.data("active")-1).show()}});t.on("click",".wm-item-title",function(e){var t=jQuery(this);t.parent(".wm-item").toggleClass("active");t.next(".wm-item-content").slideToggle()});var n=jQuery(".filterable-simple"),r=jQuery(".filterable-simple .wm-filter");r.on("click","a",function(e){e.preventDefault();var t=jQuery(this),n=t.closest(".wm-filter").next(".wm-filter-this-simple");if(!t.parent().hasClass("active")){t.parent().addClass("active").siblings().removeClass("active");if("*"==t.data("filter")){n.children(".wm-item").slideDown()}else{n.children(".wm-item"+t.data("filter")).slideDown();n.children(".wm-item").not(t.data("filter")).slideUp()}}})})