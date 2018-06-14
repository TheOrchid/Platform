<?php

declare(strict_types=1);

namespace Orchid\Press\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Orchid\Press\Models\Page;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @var
     */
    public $locales;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('platform.posts');
        $this->locales = collect(config('press.locales'));
    }

    /**
     * @param Page $page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function show(Page $page = null)
    {
        $this->checkPermission('platform.posts.type.'.$page->slug);

        return view('platform::container.posts.page', [
            'type'    => $page->getEntityObject($page->slug),
            'locales' => $this->locales,
            'post'    => $page,
        ]);
    }

    /**
     * @param Page    $page
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     */
    public function update(Page $page, Request $request)
    {
        $this->checkPermission('platform.posts.type.'.$page->slug);
        $type = $page->getEntityObject($page->slug);

        $page->fill($request->all())->save([
            'user_id'    => Auth::user()->id,
            'type'       => 'page',
            'slug'       => $page->slug,
            'status'     => 'publish',
            'options'    => $page->getOptions(),
            'publish_at' => Carbon::now(),
        ]);

        foreach ($type->getModules() as $module) {
            $module = new $module();
            $module->save($type, $page);
        }

        Alert::success(trans('platform::common.alert.success'));

        return back();
    }
}
