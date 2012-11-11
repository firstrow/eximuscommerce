
function setupElrteEditor(id, el_clicked, theme, height)
{
	$(el_clicked).hide();

	var lang = 'ru';
	var opts = {
		lang         : lang, 
		styleWithCSS : false,
		height       : height,
		toolbar      : theme,
		fmOpen : function(callback) {
			$('<div />').dialogelfinder({
				url: '/filemanager/connector',
				lang: lang,
				commandsOptions: {
					getfile: {
						oncomplete: 'destroy'
					}
				},
				getFileCallback: callback
			});
		}
	};

	$('#'+id).elrte(opts);

	return false;
}
