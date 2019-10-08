<?php namespace Avl\AdminPage\Controllers\Admin\Ajax;

use App\Http\Controllers\Avl\AvlController;
	use App\Models\{Sections, Media, Langs};
	use Illuminate\Support\Facades\Storage;
	use Avl\AdminPage\Models\Page;
	use Illuminate\Http\Request;
	use Carbon\Carbon;
	use Image;

class MediaController extends AvlController
{

		/**
		 * Загрузка изображений
		 * @param  Request $request
		 * @return JSON
		 */
		public function pageImages(Request $request)
		{
			if ($request->Filedata->getSize() < config('adminpage.max_file_size')) {

				if (in_array(strtolower($request->Filedata->extension()), config('adminpage.valid_image_types'))) {

					$page = Page::where('section_id', $request->input('section_id'))->first();

					if ($page) {
							$sind = $page->media()->orderBy('sind', 'DESC')->first();
							$item = ($sind) ? ++$sind->sind : 1 ;

							$picture = new Media;
							$picture->model = 'Avl\AdminPage\Models\Page';
							$picture->model_id = $page->id;
							$picture->type = 'image';
							$picture->sind = $item;
							$picture->title_ru = $request->Filedata->getClientOriginalName();
							$picture->published_at = Carbon::now();

							if ($picture) {

								/* Загружаем файл и получаем путь */
								$path = $request->Filedata->store(config('adminpage.path_to_image'));

								$img = Image::make(Storage::get($path));
								$img->resize(1000, 1000, function ($constraint) {
									$constraint->aspectRatio();
									$constraint->upsize();
								})->stream();

								Storage::put($path, $img);

								$picture->url = $path;

								if ($picture->save()) {
									return [
										'success' => true,
										'html' => view('adminpage::pages.snippets.image', [
											'image' => Media::find($picture->id)->toArray()
										])->render()
									];
								}

								$picture->delete();
							}
					}

					return ['errors' => ['Ошибка загрузки, обратитесь к администратору.']];
				}

				return ['errors' => ['Ошибка загрузки, формат изображения не допустим для загрузки.']];
			}

			return ['errors' => ['Размер фотографии не более <b>12-х</b> мегабайт.']];
		}

		/**
		 * Загрузка файлов
		 * @param  Request $request
		 * @return JSON
		 */
		public function pageFiles(Request $request)
		{
			// $request->file('Filedata')->getSize();
			// ini_get('post_max_size');

			$page = Page::where('section_id', $request->input('section_id'))->first();

			if ($page) {
				$sind = $page->media('file')->orderBy('sind', 'DESC')->first();
				$item = ($sind) ? ++$sind->sind : 1 ;

				$media = new Media();

				$media->model = 'Avl\AdminPage\Models\Page';
				$media->model_id = $page->id;
				$media->good = 1;
				$media->type = 'file';
				$media->sind = $item;
				$media->lang = $request->input('lang');
				$media->{'title_' . $request->input('lang')} = $request->Filedata->getClientOriginalName();
				$media->published_at = Carbon::now();

				if ($media->save()) {
					$path = $request->Filedata->store(config('adminpage.path_to_file'));

					if ($path) {
						$media->url = $path;

						if ($media->save()) {
							return [
								'success' => true,
								'html' => view('adminpage::pages.snippets.file', [
									'file' => $media->toArray()
								])->render()
							];
						}

						$media->delete();
					}
				}
			}

			return ['errors' => ['Ошибка загрузки, обратитесь к администратору.']];
		}
}
