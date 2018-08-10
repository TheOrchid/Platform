<?php

declare(strict_types=1);

namespace Orchid\Attachment\Models;

use Orchid\Platform\Dashboard;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Attachment.
 */
class Attachment extends Model
{
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
    ];

    /**
     * Attachment constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

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
     * @param string $size
     *
     * @return string
     */
    public function url($size = ''): string
    {
        $disk = $this->getAttribute('disk');

        if (! empty($size)) {
            $size = '_'.$size;

            if (! Storage::disk($disk)->exists($this->physicalPath())) {
                return $this->url(null);
            }
        }

        return Storage::disk($disk)->url($this->path.$this->name.$size.'.'.$this->extension);
    }

    /**
     * @return string
     */
    public function physicalPath() : string
    {
        return $this->path.$this->name.'.'.$this->extension;
    }

    /**
     * Get the contents of a file.
     *
     * @return string
     */
    public function read() : string
    {
        return Storage::disk(static::getAttribute('disk'))->get(static::physicalPath());
    }

    /**
     * @param null $width
     * @param null $height
     * @param int  $quality
     *
     * @return \Intervention\Image\Image
     */
    public function getSizeImage($width = null, $height = null, $quality = 100)
    {
        return Image::cache(function ($image) use ($width, $height, $quality) {
            $image->make(static::read())->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode(static::getAttribute('extension'), $quality);
        }, 10, true);
    }

    /**
     * @return bool|null
     */
    public function delete()
    {
        if ($this->exists) {
            if (self::where('hash', $this->hash)->count() <= 1) {
                $this->removePhysicalFile($this, $this->getAttribute('disk'));
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
     * Physical removal of all copies of a file.
     *
     * @param self   $attachment
     * @param string $storageName
     */
    private function removePhysicalFile(self $attachment, $storageName)
    {
        $storage = Storage::disk($storageName);

        $storage->delete($attachment->path.$attachment->name.'.'.$attachment->extension);

        if (substr($this->mime, 0, 5) !== 'image') {
            return;
        }

        foreach (array_keys(config('platform.images', [])) as $format) {
            $storage->delete($attachment->path.$attachment->name.'_'.$format.'.'.$attachment->extension);
        }
    }

    /**
     * Get MIME type for file.
     *
     * @return string
     */
    public function getMimeType() : string
    {
        $mimes = new \Mimey\MimeTypes();

        $type = $mimes->getMimeType($this->getAttribute('extension'));

        if (is_null($type)) {
            return 'unknown';
        }

        return $type;
    }
}
