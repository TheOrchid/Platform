<?php

namespace Orchid\Foundation\Http\Forms\Tools\Advertising;

use Illuminate\Http\Request;
use Orchid\Forms\Form;
use Orchid\Foundation\Core\Models\Adv;
use Orchid\Foundation\Core\Models\TermTaxonomy;
use Orchid\Foundation\Facades\Alert;

class AdvertisingMainForm extends Form
{
    use CodeOperations;

    /**
     * @var string
     */
    public $name = 'Общее';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Adv::class;

    /**
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @param $item
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get($item = null)
    {
        $adsCategory = collect(config('ads.category'));
        $weekDays = collect(config('ads.days'));

        return view('dashboard::container.tools.advertising.info', [
            'item'       => $item,
            'categories' => $adsCategory,
            'weekDays'   => $weekDays,
        ]);
    }

    /**
     * @param Request|null $request
     * @param null         $adv
     *
     * @return mixed|void
     */
    public function persist(Request $request = null, $adv = null)
    {
        $requestContent = $request->all();

        $code = $requestContent['code'];

        $fullSavePath = $this->createDbPath($code);

        unset($requestContent['_token']);
        unset($requestContent['_method']);
        unset($requestContent['code']);
        if (!($adv instanceof Adv)) {
            $adv = Adv::create([
                'content'   => $requestContent,
                'file_name' => $fullSavePath,
            ]);
        } else {
            $segments = $request->segments();
            $item_id = $segments[count($segments) - 1];

            $adv = Adv::where('id', $item_id)->first();

            $adv->content = $requestContent;
            $adv->file_name = $fullSavePath;
        }

        $adv->save();

        Alert::success('success');
    }

    /**
     * @param Request      $request
     * @param TermTaxonomy $termTaxonomy
     */
    public function delete(Request $request, TermTaxonomy $termTaxonomy)
    {
    }
}
