<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Mimey\MimeTypes;
use Orchid\Platform\Dashboard;
use Orchid\Platform\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Attachment.
 */
class Attachment extends Model
{
    use LogsActivity;

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
        'description',
        'alt',
        'hash',
        'disk',
        'group',
    ];

    /**
     * @var string
     */
    protected static $logAttributes = ['*'];

    /**
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the address by which you can access the file.
     *
     * @param string $default
     *
     * @return string
     */
    public function url($default = null): ?string
    {
        $disk = $this->getAttribute('disk');

        if (Storage::disk($disk)->exists($this->physicalPath())) {
            return Storage::disk($disk)->url($this->physicalPath());
        }

        return $default;
    }

    /**
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * @return string
     */
    public function physicalPath(): string
    {
        return $this->path.$this->name.'.'.$this->extension;
    }

    /**
     * Get the contents of a file.
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function read(): string
    {
        return Storage::disk($this->getAttribute('disk'))->get($this->physicalPath());
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        if ($this->exists) {
            if (self::where('hash', $this->hash)->where('disk', $this->disk)->count() <= 1) {
                //Physical removal of all copies of a file.
                Storage::disk($this->disk)->delete($this->physicalPath());
            }
            $this->relationships()->delete();
        }

        return parent::delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationships()
    {
        return $this->hasMany(Dashboard::model(Attachmentable::class), 'attachment_id');
    }

    /**
     * Get MIME type for file.
     *
     * @return string
     */
    public function getMimeType(): string
    {
        $mimes = new MimeTypes();

        $type = $mimes->getMimeType($this->getAttribute('extension'));

        return $type ?? 'unknown';
    }
}
