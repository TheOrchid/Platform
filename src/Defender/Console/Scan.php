<?php

namespace Orchid\Defender\Console;

use App\Defender;
use Illuminate\Console\Command;

class Scan extends Command
{
    /**
     * @var Defender
     */
    public $defender;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'defender:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->defender = new Defender();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->defender->scan()->export();
    }
}
