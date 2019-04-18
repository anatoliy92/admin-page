<?php namespace Avl\AdminPage\Controllers\Admin;

use App\Http\Controllers\Avl\AvlController;
use Avl\AdminPage\Models\Pages;
use App\Models\{Sections, Langs};
use Illuminate\Http\Request;
use Cache;

class PageController extends AvlController
{
		protected $langs = null;

		public function __construct (Request $request) {
			parent::__construct($request);

			$this->langs = Langs::get();
		}

		public function index($id)
		{
			$section = Sections::whereId($id)->firstOrFail();

			if (!$section->page) { $section->page()->save(new Pages()); }

			$this->authorize('update', $section);

			return view('adminpage::pages.index', [
					'section' => $section,
					'langs' => $this->langs,
			]);
		}

		public function update(Request $request, $id, $page_id = null)
		{

			$this->validate(request(), [
					'button' => 'required|in:add,save',
					'page_description_ru' => '',
			]);
			$page = Pages::findOrFail($page_id);

			foreach ($this->langs as $lang) {
				$page->{'description_' . $lang->key} = $request->input('page_description_' . $lang->key) ?? null;

				// Параллельно очищаем кэш страниц
				if (Cache::has('page--' . $lang->key . '-' . $id)) {
					Cache::forget('page--' . $lang->key . '-' . $id);
				}
			}

			if ($page->save()) {
				return redirect()->back()->with(['success' => ['Сохранение прошло успешно!']]);
			}
			return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
		}

}
