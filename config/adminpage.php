<?php

/**
 * Config for page module
 *
 */

return [

	/**
	 * Размер загружаемого файла в байтах (12582912 байт = 12 мб)
	 */
	'max_file_size' => 12582912,

	/**
	 * Путь к каталогу с изображениями
	 */
	'path_to_image' => 'data/media/page/images',

	/**
	 * Путь к каталогу с файлами
	 */
	'path_to_file' => 'data/media/page/files',

	/**
	 * Формат возможных для загрузки изображений
	 */
	'valid_image_types' => ['jpg', 'jpeg', 'gif', 'png', 'JPEG', 'JPG', 'PNG', 'GIF']


];
