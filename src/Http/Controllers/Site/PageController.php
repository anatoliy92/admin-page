<?php namespace Avl\AdminPage\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Site\Sections\SectionsController;
use App\Models\Sections;
use Cache;
use View;

class PageController extends SectionsController
{

	public function index ()
	{

		if ($this->section->type != 'page') {
			return redirect()->route('site.' . $this->section->type . '.index', ['alias' => $this->section->alias]);
		}

		return Cache::remember('page--' . $this->lang . '-' . $this->section->id, 15, function() {

			$template = 'site.templates.page.full.' . $this->getTemplateFileName($this->section->current_template->file_full);

			$template = (View::exists($template)) ? $template : 'site.templates.page.full.default';

			return view($template, [
				'text' => (isset($this->section->page)) ? $this->section->page->text : '',
				'data' => (isset($this->section->page)) ? $this->section->page : null,
				'print' => true
			])->render();
		});
	}

}
