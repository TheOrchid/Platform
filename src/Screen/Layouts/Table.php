<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\TD;
use Orchid\Screen\Repository;
use Illuminate\Contracts\View\Factory;

/**
 * Class Table.
 */
abstract class Table extends Base
{
    /**
     * @var string
     */
    protected $template = 'platform::layouts.table';

    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target;

    /**
     * @param Repository $repository
     *
     * @return Factory|\Illuminate\View\View
     */
    public function build(Repository $repository)
    {
        if (! $this->checkPermission($this, $repository)) {
            return;
        }

        $columns = collect($this->columns())->filter(static function (TD $column) {
            return $column->isSee();
        });

        return view($this->template, [
            'rows'         => $repository->getContent($this->target),
            'columns'      => $columns,
            'iconNotFound' => $this->iconNotFound(),
            'textNotFound' => $this->textNotFound(),
            'subNotFound'  => $this->subNotFound(),
            'striped'      => $this->striped(),
        ]);
    }

    /**
     * @return string
     */
    protected function iconNotFound(): string
    {
        return 'icon-table';
    }

    /**
     * @return string
     */
    protected function textNotFound(): string
    {
        return __('Records not found');
    }

    /**
     * @return string
     */
    protected function subNotFound(): string
    {
        return '';
    }

    /**
     * @return bool
     */
    protected function striped(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    abstract protected function columns(): array;
}
