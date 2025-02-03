<?php

declare(strict_types=1);

namespace Orchid\Screen\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Class Tabs.
 */
abstract class Tabs extends Layout
{
    /**
     * @var string
     */
    public $template = 'platform::layouts.tabs';

    /**
     * @var array
     */
    protected $variables = [
        'activeTab'    => null,
        'labels'       => [],
    ];

    /**
     * Layout constructor.
     *
     * @param Layout[] $layouts
     */
    public function __construct(array $layouts = [])
    {
        $this->layouts = $layouts;
    }

    /**
     * @return mixed
     */
    public function build(Repository $repository)
    {
        return $this->buildAsDeep($repository);
    }

    /**
     * @return $this
     */
    public function activeTab(string $name)
    {
        $this->variables['activeTab'] = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function labels(array $labels)
    {
        $this->variables['labels'] = $labels;

        return $this;
    }
}
