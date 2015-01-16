/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.1
 */

!function(){"use strict";tinymce.PluginManager.add("wmShortcodes",function(a){var c=new Array,d=new Array,e="undefined"==typeof wmShortcodesArray?[{name:"Shortcode",code:"","class":"shortcode"}]:wmShortcodesArray,f="_id"+Math.floor(1e3*Math.random()+1);for(var g in e)c[g]={text:e[g].name,id:"wm"+("0"+g).slice(-2)+"_"+e[g]["class"],"class":e[g]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=e[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=e[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};if("undefined"!=typeof wmShortcodesArrayShort)for(var g in wmShortcodesArrayShort)d[g]={text:wmShortcodesArrayShort[g].name,id:"wm"+("0"+g).slice(-2)+"_"+wmShortcodesArrayShort[g]["class"],"class":wmShortcodesArrayShort[g]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=wmShortcodesArrayShort[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=wmShortcodesArrayShort[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};a.addButton("wm_shortcodes_list",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list"+f,icon:!1,menu:c}),"undefined"!=typeof wmShortcodesArrayShort&&a.addButton("wm_shortcodes_list_short",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list_short"+f,icon:!1,menu:d})})}();