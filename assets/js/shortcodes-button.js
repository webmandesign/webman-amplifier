/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since       1.0
 * @version     1.0.9.2
 */

!function(){"use strict";tinymce.PluginManager.add("wmShortcodes",function(a){var c=new Array,d=new Array,e="undefined"==typeof wmShortcodesArray?[{name:"Shortcode",code:"","class":"shortcode"}]:wmShortcodesArray,f="_id"+Math.floor(1e3*Math.random()+1);for(var g in e)c[g]={text:e[g].name,id:"wm"+("0"+g).slice(-2)+"_"+e[g]["class"],"class":e[g]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=e[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=e[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};if("undefined"!=typeof wmShortcodesArrayVC)for(var g in wmShortcodesArrayVC)d[g]={text:wmShortcodesArrayVC[g].name,id:"wm"+("0"+g).slice(-2)+"_"+wmShortcodesArrayVC[g]["class"],"class":wmShortcodesArrayVC[g]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=wmShortcodesArrayVC[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=wmShortcodesArrayVC[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};a.addButton("wm_shortcodes_list",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list"+f,icon:!1,menu:c}),"undefined"!=typeof wmShortcodesArrayVC&&a.addButton("wm_shortcodes_list_vc",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list_vc"+f,icon:!1,menu:d})})}();