<?php

declare(strict_types=1);

namespace Orchid\Platform\Traits;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Attachment
{
    /**
     * The Eloquent tags model name.
     *
     * @var string
     */
    protected static $attachmentModel = 'Orchid\Platform\Models\Attachment';

    /**
     * @return string
     */
    public static function getAttachmentModel(): string
    {
        return static::$attachmentModel;
    }

    /**
     * @param $model
     */
    public static function setAttachmentModel($model): void
    {
        static::$attachmentModel = $model;
    }

    /**
     * @param string $group
     *
     * @return MorphToMany
     */
    public function attachment($group = null): MorphToMany
    {
        $query = $this->morphToMany(
            static::$attachmentModel,
            'attachmentable',
            'attachmentable',
            'attachmentable_id',
            'attachment_id'
        );

        if (! is_null($group)) {
            $query->where('attachmentable_group', $group);
        }

        return $query;
    }
}
