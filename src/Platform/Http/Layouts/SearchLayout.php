<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Layouts;

use Throwable;
use Orchid\Screen\Field;
use Orchid\Screen\Repository;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Dashboard;
use Illuminate\Database\Eloquent\Model;

class SearchLayout extends Rows
{
    /**
     * @param Repository $query
     *
     * @return bool
     */
    public function canSee(Repository $query): bool
    {
        return Dashboard::getGlobalSearch()->count() > 0;
    }

    /**
     * @throws Throwable
     *
     * @return array
     */
    public function fields(): array
    {
        $searchModel = $this->query->get('model');

        $layouts = Dashboard::getGlobalSearch()
            ->map(function (Model $model) use ($searchModel) {
                $radio = Radio::make('type')
                    ->value(get_class($model))
                    ->horizontal()
                    ->placeholder($model->searchLabel());

                if ($model instanceof $searchModel) {
                    $radio->checked(true);
                }

                return $radio;
            });

        $layouts->prepend(Label::make('test')->title(__('Choose record type:')));

        return [
            Field::group($layouts->all()),
        ];
    }
}
