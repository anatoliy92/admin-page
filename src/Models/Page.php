<?php namespace Avl\AdminPage\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTrait;
use LaravelLocalization;
use App\Models\Media;

class Page extends Model
{
	use ModelTrait;

	protected $table = 'pages';

	protected $modelName = __CLASS__;

	protected $lang = null;

	protected $guarded = [];

	public function __construct (array $attributes = array())
	{
		parent::__construct($attributes);

		$this->lang = LaravelLocalization::getCurrentLocale();
	}

	public function media ($type = 'image')
	{
		return Media::whereModel('Avl\AdminPage\Models\Page')->where('model_id', $this->id)->where('type', $type);
	}

    public function images ()
    {
        return $this->media('image')->where(function ($query) {
            $query->whereNull('lang')->orWhere('lang', $this->lang);
        })->whereGood(true)->orderBy('main', 'DESC')->orderBy('sind', 'DESC')->get();
    }

    public function files ()
    {
        return $this->media('file')->where(function ($query) {
            $query->whereNull('lang')->orWhere('lang', $this->lang);
        })->whereGood(true)->orderBy('sind', 'DESC')->get();
    }

	public function getTextAttribute ($value, $lang = null) {
		$text = (!is_null($lang)) ? $lang : $this->lang;

		return ($this->{'description_' . $text}) ? $this->{'description_' . $text} : null ;
	}
}
