<?php

namespace Orchid\Database\Seeds;

use Orchid\Press\Models\Term;
use Illuminate\Database\Seeder;
use Orchid\Press\Models\Taxonomy;

class TermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Term::class, 20)->create()->each(function ($u) {
            $u->taxonomy()->saveMany(factory(Taxonomy::class, 1)->make());
        });
    }
}
