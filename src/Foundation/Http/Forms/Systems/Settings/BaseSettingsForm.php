<?php

namespace Orchid\Foundation\Http\Forms\Systems\Settings;

use Orchid\Foundation\Core\Models\Setting;
use Orchid\Foundation\Services\Forms\Form;
use Orchid\Foundation\Facades\Alert;

class BaseSettingsForm extends Form
{
    public $name = 'Base';

    /**
     * Base Model.
     *
     * @var
     */
    protected $model = Setting::class;


    /**
     * Validation Rules Request.
     *
     * @var array
     */
    protected $rules = [
        //'settings' => 'required|array',
    ];

    /**
     * Display Settings App.
     */
    public function get()
    {
        $settings = $this->model->get([
            'site_descriptions',
            'site_adress',
            'site_phone',
            'site_email',
        ]);

        return view('dashboard::container.systems.settings.base', $settings);
    }

    /**
     * Save Base Settings.
     */
    public function persist()
    {
        $settings = $this->request->except('_token');
        foreach ($settings as $key => $value) {
            $this->model->set($key, $value);
        }
        Alert::success('Message');
    }
}
