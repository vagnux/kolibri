<?php
/*
 * Copyright (C) 2016 Vagner Rodrigues
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */

class cmsEditView {
	
	function pageList($pages) {
		
		$cod = "<h3>Pages</h3>";
		
		$t = new dataTable();
		page::addBody($cod);
		
		$form = new formEasy();
		$form->action(config::siteRoot() . '/index.php/cms_pageEditor/newPage/')->method('post')->openForm();
		$form->type('submit')->class('btn btn-primary')->value('New Page')->done();
		$form->closeForm();
		page::addBody($form->printform());		
		page::addBody($t->loadTable($pages));
		page::render();
		
	}
	
	
	function newPage() {
		
		
		$cod = "<h3>Pages</h3>";
		page::addCssFile(config::siteRoot() . "/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.css");
		page::addJsFile(config::siteRoot() . "/vendors/bootstrap-tagsinput/dist/bootstrap-tagsinput.js");
		
		$form = new formEasy();
		$form->action(config::siteRoot() . '/index.php/cms_pageEditor/savePage/')->method('post')->openForm();
		$form->addhtml('<div class="row">');
			$form->addhtml('<div class="col-xs-12 col-sm-6 col-md-8">');
				$form->addhtml('<div class="form-group">');
					$form->type('button')->value('Save')->class('btn btn-success')->done();
				$form->addhtml('</div>');
			$form->addhtml('</div>');
		$form->addhtml('</div>');
		$form->addhtml('<div class="row">');
			
		
			$form->addhtml('<div class="col-xs-12 col-md-8">');
			
					$form->addhtml('<div class="panel-heading">Page Data</div>');
					$form->addhtml('<div class="panel panel-default">');
						$form->addhtml('<div class="panel-body">');
							$form->addhtml('<div class="form-group">');
								$form->addText("Page name", 'pageName', '');
							$form->addhtml('</div>');
							$form->addhtml('<div class="form-group">');
							$form->addText("Page Alias", 'pageAlias', '');
							$form->addhtml('</div>');
							$form->addhtml('<div class="form-group">');
								//$form->addText("Page template name", 'pageTemplate', '');
								$form->addDatalist("Page template name.", 'pageTemplate', '');
							$form->addhtml('</div>');
							$form->addhtml('<div class="form-group">');
								$form->type('hidden')->name('customCss')->done();
								$form->type('hidden')->name('customJs')->done();
								$form->type('hidden')->name('customHtml')->done();
							$form->addhtml('</div>');
						$form->addhtml('</div>');
					$form->addhtml('</div>');
			$form->addhtml('</div>');
		//$form->addhtml('</div>');
			$form->addhtml('<div class="col-md-4">');
				$form->addhtml('<div class="panel-heading">Edit page</div>');
				$form->addhtml('<div class="panel panel-default">');
								$form->addhtml('<div class="container-fluid">');
								$form->addhtml('<div class="row">');
								$form->addhtml('<div class="col-xs-6 col-sm-3">');
								$form->addhtml('<div class="form-group">');
								$form->type('button')->value('Edit CSS')->onclick('openCssWindow();')->class('btn btn-info')->done();
								$form->addhtml('</div>');
								$form->addhtml('</div>');
								$form->addhtml(' <div class="col-xs-6 col-sm-3">');
								$form->addhtml('<div class="form-group">');
								$form->type('button')->value('Edit JS')->onclick('openJsWindow();')->class('btn btn-info')->done();
								$form->addhtml('</div>');
								$form->addhtml('</div>');
								//$form->addhtml(' <div class="col-xs-6 col-sm-3">');
								//$form->addhtml('<div class="form-group">');
								//$form->type('button')->value('Edit HTML')->onclick('openJsWindow();')->class('btn btn-info')->done();
								//$form->addhtml('</div>');
								//$form->addhtml('</div>');
								$form->addhtml(' <div class="col-xs-6 col-sm-3>');
								$form->addhtml('<div class="form-group">');
								$form->type('button')->value('Edit Template')->onclick('$("#templateWindow").modal();')->class('btn btn-info')->done();
								$form->addhtml('</div>');
								$form->addhtml('</div>');
								$form->addhtml('</div>');
								$form->addhtml('</div>');
								$form->addhtml('<hr>');
								
								$form->addhtml('<div class="form-group">');
								$form->addhtml('<div class="bs-example">
								<label of="tagList">Tags<label>
            					<input type="datalist" id="tagList" name="tagList" value="" data-role="tagsinput" />
         						 </div>');
							$form->addhtml('</div>');
							$form->addhtml('<div class="form-group">');
							$form->addhtml('<div class="bs-example">
								<label of="catList">Categories<label>
            					<input type="text" id="catList" name="catList" value="" data-role="tagsinput" />
         						 </div>');
							$form->addhtml('</div>');
						$form->addhtml('</div>');
				$form->addhtml('</div>');
			$form->addhtml('</div>');
		$form->addhtml('</div>');
		
		$form->closeForm();
		
		
		
		$templateWindow = '<!-- Modal -->
		  <div class="modal fade" id="templateWindow" role="dialog">
		    <div class="modal-dialog  modal-lg">
		    
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">Edit Template</h4>
		        </div>
		        <div class="modal-body">
		          
				<iframe width="100%" height="1000" src="::siteroot::/vendors/layoutit-gh-pages/en/index.html"></iframe>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
		      
		    </div>
		  </div>';
		
		$cssWindow = '<!-- Modal -->
		  <div class="modal fade" id="cssWindow" role="dialog">
		    <div class="modal-dialog  modal-lg">
				
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
 		          <h4 class="modal-title">CSS Editor</h4>
		        </div>
		        <div class="modal-body">
					<textarea id="cssEditor" style="height: 550px; width: 100%;" name="cssEditor">window.onload = function () {
                document.getElementById("hello").addEventListener("click", function () {
                    alert("Bem-vindo à Wikipédia!");
                }, false);
            };
				</textarea>
				
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
				
		    </div>
		  </div>';
		
		
		$jsWindow = '<!-- Modal -->
		  <div class="modal fade" id="jsWindow" role="dialog">
		    <div class="modal-dialog  modal-lg">
				
		      <!-- Modal content-->
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal">&times;</button>
		          <h4 class="modal-title">JavaScript Editor</h4>
		        </div>
		        <div class="modal-body">
				
				<textarea id="jsEditor" style="height: 550px; width: 100%;" name="jsEditor">window.onload = function () {
                document.getElementById("hello").addEventListener("click", function () {
                    alert("Bem-vindo à Wikipédia!");
                }, false);
            };
				</textarea>
		        </div>
		        <div class="modal-footer">
		          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div>
				
		    </div>
		  </div>';
		
		
		$js = 'editAreaLoader.init({
			id: "jsEditor"	// id of the textarea to transform	
					
			,start_highlight: true	// if start with highlight
			//,font_size: "10"	
			,allow_resize: "yes"
			,allow_toggle: false
			,language: "en"
			,syntax: "js"
			,toolbar: "save, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight"
			,save_callback: "js_save"
			,EA_load_callback: "editAreaLoaded"
			,min_height: 350,
		});
		
	
		editAreaLoader.init({
			id: "cssEditor"	// id of the textarea to transform	
					
			,start_highlight: true	// if start with highlight
			//,font_size: "10"	
			,allow_resize: "yes"
			,allow_toggle: false
			,language: "en"
			,syntax: "css"
			,toolbar: "save, |, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight"
			,save_callback: "css_save"
			,EA_load_callback: "editAreaLoaded"
			,min_height: 350,
		});
		
		function editAreaLoaded(id){
			if(id=="cssEditor")
			{
				
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
			var dencodedString = Base64.decode($("input[name=customCss]").val());
			editAreaLoader.setValue("cssEditor",dencodedString);
				
			}
			if(id=="jsEditor")
			{
				
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
			var dencodedString = Base64.decode($("input[name=customJs]").val());
			editAreaLoader.setValue("jsEditor",dencodedString);
				
			}
		}

		function openCssWindow() {
			
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
			var dencodedString = Base64.decode($("input[name=customCss]").val());
		
			
			editAreaLoader.setValue("cssEditor",dencodedString);
			$("#cssWindow").modal();
		}
	
		function openJsWindow() {
			
				
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
			var dencodedString = Base64.decode($("input[name=customJs]").val());
			editAreaLoader.setValue("jsEditor",dencodedString);
			$("#jsWindow").modal();
		}
		
		
		function js_save(id,content)
		{
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

			var encodedString = Base64.encode(content);
			
			$("input[name=customJs]").val(encodedString);
			console.log(encodedString); 
		}

		function css_save(id,content)
		{
			var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

			var encodedString = Base64.encode(content);
			
			$("input[name=customCss]").val(encodedString);
			
			console.log(encodedString); 
		}
		
		';
		
		page::addBody($cod);
		page::addBody($form->printform());
		page::addBody($templateWindow);
		page::addBody($cssWindow);
		page::addBody($jsWindow);
		page::addJsFile(config::siteRoot() . "/vendors/editarea/edit_area/edit_area_full.js");
		page::addJsScript($js);
		page::render();
		
		
	}
	
}