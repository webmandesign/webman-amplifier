/**
 * WebMan Visual Composer plugin additional shortcode attributes helper scripts
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 */

(function(e){e(".wpb_edit_form_elements .wm-radio-block.custom-label input:checked").parent(".input-item").addClass("active");e(".wpb_edit_form_elements .wm-radio-block.custom-label input").on("change",function(){e(this).parent(".input-item").addClass("active").siblings(".input-item").removeClass("active")})})(window.jQuery)