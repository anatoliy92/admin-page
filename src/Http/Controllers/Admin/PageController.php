<?php namespace Avl\AdminPage\Controllers\Admin;

use Darmen\Moderation\Services\ModerationService;
use App\Http\Controllers\Avl\AvlController;
use Avl\AdminPage\Models\Page;
use App\Models\{Sections, Langs};
use Illuminate\Http\Request;
use Cache;

class PageController extends AvlController
{
    protected $langs = null;

    protected $section;

    /** @var ModerationService  */
    private $moderationService;

    public function __construct (Request $request, ModerationService $moderationService) {
        parent::__construct($request);

        $this->langs = Langs::get();

        $this->section = Sections::find($request->id) ?? null;

        view()->share([ 'section' => $this->section ]);

        $this->moderationService = $moderationService;
    }

    public function index()
    {
        if (!$this->section->page) { $this->section->page()->save(new Page()); }

        return view('adminpage::pages.index', [
            'section' => $this->section->refresh(),
            'langs' => $this->langs,
        ]);
    }

    public function update(Request $request)
    {
        $this->validate(request(), [
            'button' => 'required|in:add,save',
            'page_description_ru' => '',
        ]);

        $page = Page::findOrFail($request->page);

        foreach ($this->langs as $lang) {
            $page->{'description_' . $lang->key} = $request->input('page_description_' . $lang->key) ?? null;

            // Параллельно очищаем кэш страниц
            if (Cache::has('page--' . $lang->key . '-' . $this->section->id)) {
                Cache::forget('page--' . $lang->key . '-' . $this->section->id);
            }
        }

        if ($page->save()) {
            return redirect()->back()->with(['success' => ['Сохранение прошло успешно!']]);
        }
        return redirect()->back()->with(['errors' => ['Что-то пошло не так.']]);
    }
}
