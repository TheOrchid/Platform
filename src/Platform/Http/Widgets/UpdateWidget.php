<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Widgets;

use Orchid\Widget\Widget;
use Orchid\Platform\Dashboard;
use Composer\Semver\Comparator;
use Illuminate\Support\Facades\Cache;

class UpdateWidget extends Widget
{
    /**
     * Dashboard::VERSION.
     *
     * @var string
     */
    public $currentVersion;

    /**
     * Packagist API URL.
     *
     * @var string
     */
    public $apiURL = 'https://packagist.org/p/orchid/platform.json';

    /**
     * Minutes.
     *
     * @var int
     */
    public $cache = 1440;

    /**
     * UpdateWidget constructor.
     */
    public function __construct()
    {
        $this->currentVersion = Dashboard::VERSION;
    }

    /**
     * @return mixed
     */
    public function handler()
    {
        $status = Cache::remember('platform-update-widget', $this->cache, function () {
            return $this->getStatus();
        });

        return view('platform::widgets.update', [
            'status' => $status,
        ]);
    }

    /**
     * @return bool
     */
    public function getStatus(): bool
    {
        try {
            $versions = json_decode(file_get_contents($this->apiURL), true)['packages']['orchid/platform'];

            foreach ($versions as $key => $version) {
                if (Comparator::greaterThan($version['version'],
                        $this->currentVersion) && $key != 'dev-master') {
                    return true;
                }
            }

            return false;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
