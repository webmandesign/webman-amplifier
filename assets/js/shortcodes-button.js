/**
 * WebMan Shortcode Generator button
 *
 * @package     WebMan Amplifier
 * @subpackage  Shortcodes
 *
 * @since    1.0
 * @version  1.1.3
 */

!function(){"use strict";tinymce.PluginManager.add("wmShortcodes",function(a){var c=0,d=new Array,e=new Array,f="undefined"==typeof wmShortcodesArray?[{name:"Shortcode",code:"","class":"shortcode"}]:wmShortcodesArray,g="_id"+Math.floor(1e3*Math.random()+1);for(c=0;c<f.length;c++)d[c]={text:f[c].name,id:"wm"+("0"+c).slice(-2)+"_"+f[c]["class"],"class":f[c]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=f[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=f[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};if("undefined"!=typeof wmShortcodesArrayShort)for(c=0;c<wmShortcodesArrayShort.length;c++)e[c]={text:wmShortcodesArrayShort[c].name,id:"wm"+("0"+c).slice(-2)+"_"+wmShortcodesArrayShort[c]["class"],"class":wmShortcodesArrayShort[c]["class"],onclick:function(b){var c=b.target.id;if(c=parseInt(c.substring(2,4)),""!=a.selection.getContent()){var d=wmShortcodesArrayShort[c].code.replace("{{content}}",a.selection.getContent());a.selection.setContent(d)}else{var d=wmShortcodesArrayShort[c].code.replace("{{content}}","TEXT");a.selection.setContent(d)}}};a.addButton("wm_shortcodes_list",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list"+g,icon:!1,menu:d}),"undefined"!=typeof wmShortcodesArrayShort&&a.addButton("wm_shortcodes_list_short",{type:"menubutton",text:"[s]",title:"Shortcode",id:"wm_shortcodes_list_short"+g,icon:!1,menu:e})})}();