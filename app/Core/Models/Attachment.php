<?php

namespace Orchid\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Orchid\Facades\Dashboard;

class Attachment extends Model
{
    /**
     * @var string
     */
    protected $table = 'files';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'original_name',
        'mime',
        'extension',
        'size',
        'path',
        'user_id',
        'post_id',
    ];

    /**
     * Attachment types.
     *
     * @var array
     */
    public static $types = [
        'image' => [
            'png',
            'jpg',
            'jpeg',
            'gif',
        ],
        'video' => [
            'mp4',
            'mkv',
        ],
        'docs' => [
            'doc',
            'docx',
            'pdf',
            'xls',
            'xlsx',
            'xml',
            'txt',
            'zip',
            'rar',
            'svg',
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model('user', User::class));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model('post', Post::class));
    }

    /**
     * @param $type
     *
     * @return Attachment
     */
    public function type($type) : Attachment
    {
        if (array_key_exists($type, $this->types)) {
            return $this->whereIn('extension', $this->types[$type]);
        }

        return $this;
    }

    /**
     * @param string $size
     * @param string $prefix
     *
     * @return string
     */
    public function url($size = '', $prefix = 'public')
    {
        if (!empty($size)) {
            $size = '_'.$size;

            if (!Storage::disk($prefix)->exists(
                $this->path.
                $this->name.
                $size.
                '.'.
                $this->extension
            )
            ) {
                return $this->url(null, $prefix);
            }
        }

        return Storage::disk($prefix)->url(
            $this->path.
            $this->name.
            $size.
            '.'.
            $this->extension
        );
    }
}
