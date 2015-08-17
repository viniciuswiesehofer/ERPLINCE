/**
 * Define all the formatting buttons with the HTML code they set.
 */
				
				
var perchButtons=[	
		{
			id:'perchfeatures',
			image:'btn-lists.png',
			title:'Landx features list',
			allowSelection:false,
			fields:[{id:'featuretype', name:'Feture type', values:['list', 'box']}, {id:'title-1', name:'<small>(you can change icon using <b>"ICONIZE"</b> after insert.)</small><br>Title'},{id:'text', name:'Description', timeline:true}],
			generateHtml:function(obj){
				var x = jQuery('#perch-timeline').val();  

				if(jQuery('#perch-shortcode-featuretype').val() == 'list'){
					var output = '<ul class="feature-list">';
					for(e = 1; e <= x; e++) {
						output+= '<li><div class="icon-container pull-left"><span style="color: #ffffff;" class="iconized font-foundicons glyph-check"></span></div>';
						if( jQuery('#perch-shortcode-title-'+e).val() != '' ){
							output += '<h6>'+jQuery('#perch-shortcode-title-'+e).val()+'</h6>';
						}
						output += '<p>'+jQuery('#perch-shortcode-text-'+e).val()+'</p></div></li>';
					}
					output += "</ul>";
				}else{
					var output = '<div class="feature">';
					for(e = 1; e <= x; e++) {
						output+= '<div class="icon"><span class="iconized font-icomoon glyph-map2"></span></div>';
						if( jQuery('#perch-shortcode-title-'+e).val() != '' ){
							output += '<h4>'+jQuery('#perch-shortcode-title-'+e).val()+'</h4>';
						}
						output += '<p>'+jQuery('#perch-shortcode-text-'+e).val()+'</p></div></li>';
					}
					output += "</div>";
				}
				
				
				return output;
			}
		},
		{
			id:'perchtestimonial',
			image:'testimonial-group.png',
			title:'Landx Testimonial slider',
			allowSelection:false,
			fields:[{id:'name-1', name:'Name'}, {id:'title-1', name:'Title'}, {id:'website-1', name:'Wbsite url'}, {id:'link-1', name:'Client photo URL', upload:true},{id:'desc', name:'Description ', testimonial : true}],
			generateHtml:function(obj){
				var x = jQuery('#perch-testimonial').val(); 
				var output = '[perch-testimonials-group]';
				for(e = 1; e <= x; e++) { 
					output += '[perch-testimonial name="'+jQuery('#perch-shortcode-name-'+e).val()+'" title="'+jQuery('#perch-shortcode-title-'+e).val()+'" website="'+jQuery('#perch-shortcode-website-'+e).val()+'" image_url="'+jQuery('#perch-shortcode-link-'+e).val()+'"]'+jQuery('#perch-shortcode-desc-'+e).val()+'[/perch-testimonial]';
				}					
				output += '[/perch-testimonials-group]';	
				
				return output;
			}
		},
		{
			id:'perchcarousel',
			image:'btn-gallery.png',
			title:'Landx Image carousel',
			allowSelection:false,
			fields:[{id:'link-1', name:'Image url URL<br><small>(insert full image url)</small>', upload:true}, {id:'title', name:'Title', reupload : true}],
			generateHtml:function(obj){
				var x = jQuery('#perch-reupload').val(); 
				var output = '[landx-carousel]';
				for(e = 1; e <= x; e++) { 
					output += '[landx-image url="'+jQuery('#perch-shortcode-link-'+e).val()+'" title="'+ jQuery('#perch-shortcode-title-'+e).val()+'"]'; 
				}					
				output += '[/landx-carousel]';	
				
				return output;
			}
		},
		{
			id:'perchbreak',
			image:'cpanel-btn-break.png',
			title:'Insert Breake',
			allowSelection:false,
			generateHtml:function(){
				return '<br class="clear" />';
			}
		},
		
		
];

/**
 * Contains the main formatting buttons functionality.
 */
perchButtonManager={
	dialog:null,
	idprefix:'perch-shortcode-',
	ie:false,
	opera:false,
		
	/**
	 * Init the formatting button functionality.
	 */
	init:function(){
			
		var length=perchButtons.length;
		for(var i=0; i<length; i++){
		
			var btn = perchButtons[i];
			perchButtonManager.loadButton(btn);
			
		}
		
		if ( jQuery.browser.msie ) {
			perchButtonManager.ie=true;
		}
		
		if (jQuery.browser.opera){
			perchButtonManager.opera=true;
		}
		
	},
	
	/**
	 * Loads a button and sets the functionality that is executed when the button has been clicked.
	 */
	loadButton:function(btn){
		
		tinymce.create('tinymce.plugins.'+btn.id, {
	        init : function(ed, url) {
			        ed.addButton(btn.id, {
	                title : btn.title,
	                image : url+'/buttons/'+btn.image,
	                onclick : function() {
			        	
			           var selection = ed.selection.getContent();
	                   if(btn.allowSelection && selection && btn.fields){
							
	                	   //there are inputs to fill in, show a dialog to fill the required data
	                	   perchButtonManager.showDialog(btn, ed);
	                   }else if(btn.allowSelection && selection){
							
	                	   //modification via selection is allowed for this button and some text has been selected
							selection = btn.generateHtml(selection);
							ed.selection.setContent(selection);
	                   }else if(btn.fields){
	                	   //there are inputs to fill in, show a dialog to fill the required data
	                	   perchButtonManager.showDialog(btn, ed);
	                   }else if(btn.list){
	                	   ed.dom.remove('perchcaret');
		           		    ed.execCommand('mceInsertContent', false, '&nbsp;');	
	           			
	                	    //this is a list
	                	    var list, dom = ed.dom, sel = ed.selection;
	                	    
		               		// Check for existing list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		// Switch/add list type if needed
		               		ed.execCommand('InsertUnorderedList');
		               		
		               		// Append styles to new list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		if (list) {
		               			dom.addClass(list, btn.list);
		               		}
	                   }else{
	                	   //no data is required for this button, insert the generated HTML
	                	   ed.execCommand('mceInsertContent', true, btn.generateHtml());
	                   }
					   

				
						jQuery("#perch-shortcode-style").change(function () {
						    if (jQuery(this).val() == 'Spacer 4' || jQuery(this).val() == 'Spacer 3' || jQuery(this).val() == 'Spacer 2' || jQuery(this).val() == 'Style-3') {
						        jQuery("#perch-shortcode-icon").removeAttr('disabled');
						    } else {
						        jQuery("#perch-shortcode-icon").attr('disabled', 'disabled').val('');
						    }
						});
			
	                }
	            });
	        }
	    });
		
	    tinymce.PluginManager.add(btn.id, tinymce.plugins[btn.id]);
	},
	
	/**
	 * Displays a dialog that contains fields for inserting the data needed for the button.
	 */
	showDialog:function(btn, ed){

		
		if(perchButtonManager.ie){
			ed.dom.remove('perchcaret');
		    var caret = '<div id="perchcaret">&nbsp;</div>';
		    ed.execCommand('mceInsertContent', false, caret);	
			var selection = ed.selection;
		}
	    
		var html='<div>';
		var selection = ed.selection;
		var selectedvalue = ed.selection.getContent();

		for(var i=0, length=btn.fields.length; i<length; i++){
			var field=btn.fields[i], inputHtml='';
			if(btn.fields[i].selesction){
				//this field should be a text area
				if(selectedvalue){ 
					// unlimited input
					html+='<div class="perch-shortcode-field"><label>Selected Text</label><input type="text" value="'+selectedvalue+'" id="'+perchButtonManager.idprefix+"selection"+'"></div><div>';
				} 
				
			}

			if(btn.fields[i].colorpalette){
					//this field should be a text area
					inputHtml='<input type="text" class="color" value="" id="'+perchButtonManager.idprefix+btn.fields[i].id+'">';
			} else if(btn.fields[i].values && !btn.fields[i].disabled){
				//this is a select list
				inputHtml='<select id="'+perchButtonManager.idprefix+btn.fields[i].id+'">';
				jQuery.each(btn.fields[i].values, function(index, value){
					inputHtml+='<option value="'+value+'">'+value+'</option>';
				});
				inputHtml+='</select>';
			}else{
				if(btn.fields[i].textarea && !perchButtonManager.opera){
					//this field should be a text area
					inputHtml='<textarea id="'+perchButtonManager.idprefix+btn.fields[i].id+'" ></textarea>';
				} else if(btn.fields[i].upload && !perchButtonManager.opera){ 
					// upload input
					inputHtml='<input type="text" id="'+perchButtonManager.idprefix+btn.fields[i].id+'" class="perch-upload-field"/><a href="#" class="perch-upload-button">Upload button</a>';
				} else if(btn.fields[i].unlimitedinput && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<input type="text" class="otlist" id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1" /><input type="text" id="perch-list" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				}  else if(btn.fields[i].disabled && !perchButtonManager.opera){ 
					//this is a select list
					inputHtml='<select id="'+perchButtonManager.idprefix+btn.fields[i].id+'" disabled>';
					jQuery.each(btn.fields[i].values, function(index, value){
						inputHtml+='<option value="'+value+'">'+value+'</option>';
					});
					inputHtml+='</select>';
				} else if(btn.fields[i].lists && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<input type="text" class="lists" id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1" /><input type="text" id="perch-lists" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				} else if(btn.fields[i].tabs && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<textarea id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1"  class="tabs" ></textarea><input type="text" id="perch-tabs" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				} else if(btn.fields[i].toggles && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<textarea id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1"  class="accordion" ></textarea><input type="text" id="perch-toggles" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				} else if(btn.fields[i].testimonial && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<textarea id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1"  class="testimonial" ></textarea><input type="text" id="perch-testimonial" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				}else if(btn.fields[i].timeline && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<textarea id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1"  class="timeline" ></textarea><input type="text" id="perch-timeline" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				}else if(btn.fields[i].reupload && !perchButtonManager.opera){ 
					// unlimited input
					inputHtml='<input id="'+perchButtonManager.idprefix+btn.fields[i].id+'-1"  class="reupload" type="text" ><input type="text" id="perch-reupload" value="1" hidden /><br /><br /><strong>To add new field press Enter</strong>';
				}
				else{
					//this field should be a normal input
					inputHtml='<input type="text" id="'+perchButtonManager.idprefix+btn.fields[i].id+'" />';
				}
			}
			html+='<div class="perch-shortcode-field"><label>'+btn.fields[i].name+'</label>'+inputHtml+'</div>';
		}
		html+='<a href="" id="insertbtn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-text">Insert</span></a></div>';
			
		var dialog = jQuery(html).dialog({							
							width: 600,
							 title:btn.title, 
							 modal:true,
							 close:function(event, ui){
								jQuery(this).html('').remove();
							 }
							 });
		
		perchButtonManager.dialog=dialog;
		
		//set a click handler to the insert button
		dialog.find('#insertbtn').click(function(event){
			event.preventDefault();
			perchButtonManager.executeCommand(ed,btn,selection);
		});

			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".otlist").is(":focus")) {
				var i = jQuery('#perch-list').val();
				var n = Number(i)+Number(1);
				jQuery('<input type="text" class="otlist" id="perch-shortcode-list-'+n+'" />').insertAfter("#perch-shortcode-list-"+i);    
				jQuery('#perch-list').val(n);
			  }
			});
			
			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".tabs").is(":focus") && jQuery('#perch-tabs').val() <5) {
				var i = jQuery('#perch-tabs').val();
				var n = Number(i)+Number(1);
				jQuery('<div class="perch-shortcode-field"><label>Background color: </label><input type="text" id="perch-shortcode-color-'+n+'" class="color"></div><div class="perch-shortcode-field"><label>Title: </label><input type="text" id="perch-shortcode-title-'+n+'"></div><div class="perch-shortcode-field"><label>Text: </label><textarea id="perch-shortcode-text-'+n+'" class="tabs"></textarea></div>').insertBefore("#insertbtn");    
				jQuery('#perch-tabs').val(n);
			  }
			});
			
			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".testimonial").is(":focus")) {
				var i = jQuery('#perch-testimonial').val();
				var n = Number(i)+Number(1);
				jQuery('<div class="perch-shortcode-field"><label>Name</label><input type="text" id="perch-shortcode-name-'+n+'"></div><div class="perch-shortcode-field"><label>Title</label><input type="text" id="perch-shortcode-title-'+n+'"></div><div class="perch-shortcode-field"><label>Website url</label><input type="text" id="perch-shortcode-website-'+n+'"></div><div class="perch-shortcode-field"><label>Client photo URL</label><input type="text" class="perch-upload-field" id="perch-shortcode-link-'+n+'"><a class="perch-upload-button" href="#">Upload button</a></div><div class="perch-shortcode-field"><label>Description: </label><textarea class="testimonial" id="perch-shortcode-desc-'+n+'"></textarea></div>').insertBefore("#insertbtn");    
				jQuery('#perch-testimonial').val(n);
			  }
			});

			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".timeline").is(":focus")) {
				var i = jQuery('#perch-timeline').val();
				var n = Number(i)+Number(1);
				jQuery('<div class="perch-shortcode-field"><label>Title</label><input type="text" id="perch-shortcode-title-'+n+'"></div><div class="perch-shortcode-field"><label>Description: </label><textarea class="timeline" id="perch-shortcode-text-'+n+'"></textarea></div>').insertBefore("#insertbtn");    
				jQuery('#perch-timeline').val(n);
			  }
			});

			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".reupload").is(":focus")) {
				var i = jQuery('#perch-reupload').val();
				var n = Number(i)+Number(1);
				jQuery('<div class="perch-shortcode-field"><label>Image url URL</label><input type="text" class="perch-upload-field" id="perch-shortcode-link-'+n+'"><a class="perch-upload-button" href="#">Upload button</a></div><div class="perch-shortcode-field"><label>Title</label><input type="text" id="perch-shortcode-title-'+n+'" class="reupload"></div>').insertBefore("#insertbtn");    
				jQuery('#perch-reupload').val(n);
			  }
			});
			
			dialog.keyup(function(event){
			  if(event.keyCode == 13 && jQuery(".lists").is(":focus")) {
				var i = jQuery('#perch-lists').val();
				var n = Number(i)+Number(1);
				jQuery('<div class="perch-shortcode-field"><label>Type</label><select id="perch-shortcode-type-'+n+'"><option value="Cog">Cog</option><option value="Star">Star</option><option value="Check">Check</option><option value="User">User</option><option value="Pencil">Pencil</option><option value="Phone">Phone</option><option value="location-arrow">Location</option><option value="Mail">Mail</option><option value="microphone">Megaphone</option><option value="Thumbs-up">Thumbs-up</option><option value="Thumbs-down">Thumbs-down</option><option value="Camera">Camera</option><option value="Globe">Globe</option><option value="Heart">Heart</option><option value="Music">Music</option><option value="trash-o">trush</option><option value="upload">PopUp</option></select></div><div class="perch-shortcode-field"><label>Text</label><input type="text" class="lists" id="perch-shortcode-lists-'+n+'"></div>').insertBefore("#insertbtn");    
				jQuery('#perch-lists').val(n);
			  }
			});
			dialog.keyup(function(event){
				if(event.keyCode == 13 && jQuery(".accordion").is(":focus") && jQuery('#perch-toggles').val() <5 ) {
					var i = jQuery('#perch-toggles').val();
					var n = Number(i)+Number(1);
					jQuery('<div class="perch-shortcode-field"><label>Title: </label><input type="text" id="perch-shortcode-title-'+n+'"></div><div class="perch-shortcode-field"><label>Text: </label><textarea id="perch-shortcode-text-'+n+'" class="accordion"></textarea></div>').insertBefore("#insertbtn");    
					jQuery('#perch-toggles').val(n);
				}
			});
	},
	/**
	 * Executes a command when the insert button has been clicked.
	 */
	executeCommand:function(ed, btn, selection){

    		var values={}, html='';
    		var selection = ed.selection.getContent();
    		if(!btn.allowSelection){
    			//the button doesn't allow selection, generate the values as an object literal
	    		for(var i=0, length=btn.fields.length; i<length; i++){
	        		var id=btn.fields[i].id,
	        			value=jQuery('#'+perchButtonManager.idprefix+id).val();
	        		
	    			values[id]=value;
	    		}
	    		html = btn.generateHtml(values);
    		}else{
				var values={};
    			//the button allows selection - only one value is needed for the formatting, so
    			//return this value only (not an object literal)
    			values[btn.fields[0].id]=jQuery('#'+perchButtonManager.idprefix+btn.fields[0].id).attr("value");
				if(btn.fields.length>=2) {
					values[btn.fields[1].id]=jQuery('#'+perchButtonManager.idprefix+btn.fields[1].id).attr("value");
				}
				values["selection"]= jQuery('#'+perchButtonManager.idprefix+"selection").attr("value");

    			html = btn.generateHtml(values);
    		}
    		
    	perchButtonManager.dialog.remove();

    	if(perchButtonManager.ie){
	    	selection.select(ed.dom.select('div#perchcaret')[0], false);
	    	ed.dom.remove('perchcaret');
    	}

  		ed.execCommand('mceInsertContent', false, html);
    	
	}
};

/**
 * Init the formatting functionality.
 */
(function() {
	
	perchButtonManager.init();
    
})();
