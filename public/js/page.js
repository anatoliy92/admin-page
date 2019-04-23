$(document).ready(function() {

	/* Загрузка медиа объектов */
		$('#upload-photos').uploadifive({
				'auto'			: true,
				'removeCompleted' : true,
				'simUploadLimit' : 1,
				'buttonText'	: 'Выберите Изображение',
				'height'	    : '100%',
				'width'			: '100%',
				'checkScript'	: '/ajax/check',
				'uploadScript'	: '/ajax/page-images',
				'fileType'		: 'image/*',
				'formData'		: {
						'_token'      : $('meta[name="_token"]').attr('content'),
						'section_id'  : $('#section_id').val()
				 },
				'folder'		: '/uploads/tmps/',

				'onUploadComplete' : function( file, data ) {
						var $data = JSON.parse(data);
						if ($data.success) {
								$('#sortable').prepend($data.html);
						}

						if ($data.errors) {
								messageError($data.errors);
						}
				}
		});

		$('#upload-files').uploadifive({
				'auto'			: true,
				'removeCompleted' : true,
				'buttonText'	: 'Выберите файл для загрузки',
				'height'	    : '100%',
				'width'			: '100%',
				'checkScript'	: '/ajax/check',
				'uploadScript'	: '/ajax/page-files',
				'folder'		: '/uploads/tmps/',
				'onUpload'     : function(filesToUpload) {
						$('#upload-files').data('uploadifive').settings.formData = {
								'_token'      : $('meta[name="_token"]').attr('content'),
								'section_id'  : $('#section_id').val(),
								'model_id'	  : $('#model_id').val(),
								'lang'        : $("#select--language-file").val()
						};
				},
				'onUploadComplete' : function( file, data ) {
					var $data = JSON.parse(data);

					if ($data.success) {
						$('#sortable-files').prepend($data.html);
					}

					if ($data.errors) {
						messageError($data.errors);
					}
				}
		});
	/* Загрузка медиа объектов */

});
