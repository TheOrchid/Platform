<?php

namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Http\Controllers\Controller;
use Orchid\Monitor\Monitor;

class MonitorController extends Controller
{
    /**
     * MonitorController constructor.
     */
    public function __construct()
    {
        $this->checkPermission('dashboard.systems.monitor');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || $this->shell_exec_enabled() == false) {
            return view('dashboard::container.systems.monitor.disable', []);
        }

        $monitor = new Monitor();

        return view('dashboard::container.systems.monitor.index', [
            'info'        => $monitor->info(),
            'hardware'    => $monitor->hardware(),
            'loadAverage' => $monitor->loadAverage(),
            'memory'      => $monitor->memory(),
            'network'     => $monitor->network(),
            'storage'     => $monitor->storage(),
        ]);
    }

    /**
     * @return bool
     */
    private function shell_exec_enabled()
    {
        $disabled = explode(',', ini_get('disable_functions'));

        return !in_array('shell_exec', $disabled);
    }
}
