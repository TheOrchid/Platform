<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Newsletter extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'lang',
    ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'updated_at',
        'created_at',
    ];

    /**
     * @param Newsletter $newsletter
     *
     * @return Newsletter
     */
    public function creating(Newsletter $newsletter)
    {
        if (is_null($newsletter->lang)) {
            $newsletter->lang = App::getLocale();
        }

        return $newsletter;
    }
}
