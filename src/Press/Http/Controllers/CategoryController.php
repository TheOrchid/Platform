<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Illuminate\Http\Request;
use Orchid\Press\Models\Taxonomy;
use Orchid\Support\Facades\Alert;
use Orchid\Platform\Http\Controllers\Controller;
use Orchid\Platform\Http\Forms\Category\CategoryFormGroup;

class CategoryController extends Controller
{
    /**
     * @var CategoryFormGroup
     */
    public $form;

    /**
     * CategoryController constructor.
     *
     * @param CategoryFormGroup $form
     */
    public function __construct(CategoryFormGroup $form)
    {
        $this->checkPermission('platform.systems.category');
        $this->form = $form;
    }

    /**
     * @return bool
     */
    public function index()
    {
        return $this->form->grid();
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return $this->form
            ->route('platform.systems.category.store')
            ->method('POST')
            ->render();
    }

    /**
     * @param Request  $request
     * @param Taxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Taxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        Alert::success(trans('platform::common.alert.success'));

        return back();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->form->render();
    }

    /**
     * @param Taxonomy $termTaxonomy
     *
     * @return mixed
     *
     * @internal param Request $request
     */
    public function edit(Taxonomy $termTaxonomy)
    {
        return $this->form
            ->route('platform.systems.category.update')
            ->slug($termTaxonomy->id)
            ->method('PUT')
            ->render($termTaxonomy);
    }

    /**
     * @param Request  $request
     * @param Taxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Taxonomy $termTaxonomy)
    {
        $this->form->save($request, $termTaxonomy);

        Alert::success(trans('platform::common.alert.success'));

        return back();
    }

    /**
     * @param Request  $request
     * @param Taxonomy $termTaxonomy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Taxonomy $termTaxonomy)
    {
        $this->form->remove($request, $termTaxonomy);

        Alert::success(trans('platform::common.alert.success'));

        return redirect()->route('platform.systems.category');
    }
}
