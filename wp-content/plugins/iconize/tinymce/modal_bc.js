/**
 * Bootstrap modal plugin for inline dialogs
 */

(function() {

	tinymce.create( 'tinymce.plugins.BootstrapModalDialog', {

		init: function( ed, url ) {

			tinymce.create( 'tinymce.BMWindowManager:tinymce.InlineWindowManager', {

				BMWindowManager : function( ed ) {

					this.parent(ed);
				},

				open: function( f, p ) {

					if ( f.bmDialog ) {

						var ed;

						// Initialize tinyMCEPopup if it exists and the editor is active.
						if ( tinyMCEPopup && typeof tinyMCE != 'undefined' && ( ed = tinyMCE.activeEditor ) && ! ed.isHidden() ) {

							tinyMCEPopup.init();
						}
					}

					var t = this, element;

					if ( ! f.wpDialog && ! f.bmDialog ) {

						return this.parent( f, p );

					} else if ( ! f.id ) {

						return;
					}

					element = jQuery('#' + f.id);

					if ( ! element.length ) {

						return;
					}

					t.features = f;
					t.params = p;
					t.onOpen.dispatch( t, f, p );
					t.element = t.windows[ f.id ] = element;

					// Store selection
					t.bookmark = t.editor.selection.getBookmark(1);

					if ( f.bmDialog ) {

						element.wpbsmodal('show');

					} else {

						// Create the wpdialog if necessary
						if ( ! element.data('wpdialog') ) {

							element.wpdialog({
								title: f.title,
								width: f.width,
								height: f.height,
								modal: true,
								dialogClass: 'wp-dialog',
								zIndex: 300000
							});
						}

						element.wpdialog('open');
					}
				},

				close: function() {

					if ( ! this.features.wpDialog && ! this.features.bmDialog ) {

						return this.parent.apply( this, arguments );
					}

					if ( this.features.bmDialog ) {

						this.element.wpbsmodal('hide');

					} else {

						this.element.wpdialog('close');

					}
				}
			});

			// Replace window manager
			ed.onBeforeRenderUI.add( function() {

				ed.windowManager = new tinymce.BMWindowManager(ed);

			});
		},

		getInfo: function() {

			return {
				longname  : 'TinyMCE Bootstrap Modal Dialog Plugin',
				author    : 'Mladen Ivancevic',
				authorurl : 'http://codecanyon.net/user/mladen16/',
				infourl   : 'http://codecanyon.net/user/mladen16/',
				version   : '1.0'
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'bootstrapmodal', tinymce.plugins.BootstrapModalDialog );
})();
