<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Orchid\Platform\Models\User;
use Cartalyst\Tags\TaggableTrait;
use Illuminate\Support\Collection;
use Orchid\Support\Facades\Dashboard;
use Orchid\Platform\Traits\Attachment;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Platform\Traits\JsonRelations;
use Orchid\Platform\Traits\MultiLanguage;
use Cviebrock\EloquentSluggable\Sluggable;
use Orchid\Screen\Exceptions\TypeException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use TaggableTrait,
        SoftDeletes,
        Sluggable,
        MultiLanguage,
        Searchable,
        Attachment,
        JsonRelations,
        FilterTrait;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * Recording entity.
     *
     * @var \Orchid\Press\Entities\Many|\Orchid\Press\Entities\Single|null
     */
    protected $entity = null;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'content',
        'options',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'type'    => 'string',
        'slug'    => 'string',
        'content' => 'array',
        'options' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'publish_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var
     */
    protected $allowedFilters = [
        'id',
        'user_id',
        'type',
        'status',
        'content',
        'options',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * @var
     */
    protected $allowedSorts = [
        'id',
        'user_id',
        'type',
        'status',
        'slug',
        'publish_at',
        'created_at',
        'deleted_at',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug',
            ],
        ];
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     *
     * @throws \Throwable| TypeException
     */
    public function toSearchableArray()
    {
        $entity = $this->getEntityObject();

        if (method_exists($entity, 'toSearchableArray')) {
            return $entity->toSearchableArray($this->toArray());
        }

        return [];
    }

    /**
     * Get Behavior Class.
     *
     * @param null $slug
     *
     * @return \Orchid\Press\Entities\Many|\Orchid\Press\Entities\Single|null
     *
     * @throws \Throwable|TypeException
     */
    public function getEntityObject($slug = null)
    {
        if (! is_null($this->entity)) {
            return $this->entity;
        }

        return $this->getEntity($slug ?: $this->getAttribute('type'))->entity;
    }

    /**
     * @param $slug
     * @return $this
     *
     * @throws \Throwable|TypeException
     */
    public function getEntity($slug)
    {
        $this->entity = Dashboard::getEntities()->where('slug', $slug)->first();

        throw_if(is_null($this->entity), TypeException::class, "{$slug} Type is not found");

        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getOptions() : Collection
    {
        return collect($this->options);
    }

    /**
     * @param      string $key
     * @param null $default
     *
     * @return null
     */
    public function getOption($key, $default = null)
    {
        $option = $this->getAttribute('options');

        if (is_null($option)) {
            $option = [];
        }

        if (array_key_exists($key, $option)) {
            return $option[$key];
        }

        return $default;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function checkLanguage($key) : bool
    {
        $locale = $this->getOption('locale', []);

        if (array_key_exists($key, $locale)) {
            return filter_var($locale[$key], FILTER_VALIDATE_BOOLEAN);
        }

        return false;
    }

    /**
     * Get the author's posts.
     *
     * @return Model|null|object|static
     */
    public function getUser()
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id')->first();
    }

    /**
     * Get tags for post as string.
     *
     * @return mixed
     */
    public function getStringTags()
    {
        return $this->tags->implode('name', static::getTagsDelimiter());
    }

    /**
     * Main image (First image).
     *
     * @param null $size
     *
     * @return mixed
     */
    public function hero($size = null)
    {
        $first = $this->attachment('image')->oldest('sort')->first();

        return $first ? $first->url($size) : null;
    }

    /**
     * Comments relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Dashboard::model(Comment::class), 'post_id');
    }

    /**
     *   Author relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() : BelongsTo
    {
        return $this->belongsTo(Dashboard::model(User::class), 'user_id');
    }

    /**
     * Whether the post contains the term or not.
     *
     * @param string $taxonomy
     * @param string $term
     *
     * @return bool
     */
    public function hasTerm($taxonomy, $term) : bool
    {
        return isset($this->terms[$taxonomy]) && isset($this->terms[$taxonomy][$term]);
    }

    /**
     * Gets all the terms arranged taxonomy => terms[].
     *
     * @return array
     */
    public function getTermsAttribute() : array
    {
        $taxonomies = $this->taxonomies;
        foreach ($taxonomies as $taxonomy) {
            $taxonomyName = $taxonomy['taxonomy'] == 'post_tag' ? 'tag' : $taxonomy['taxonomy'];
            $terms[$taxonomyName][$taxonomy->term['slug']] = $taxonomy->term['name'];
        }

        return $terms ?? [];
    }

    /**
     * Taxonomy relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function scopeTaxonomies() : BelongsToMany
    {
        return $this->belongsToMany(Dashboard::model(Taxonomy::class), 'term_relationships', 'post_id', 'term_taxonomy_id');
    }

    /**
     * @param string $taxonomy
     * @param mixed  $term
     *
     * @return mixed
     */
    public function taxonomy($taxonomy, $term)
    {
        return $this->whereHas('taxonomies', function ($query) use ($taxonomy, $term) {
            $query->where('taxonomy', $taxonomy)->whereHas('term', function ($query) use ($term) {
                $query->where('slug', $term);
            });
        });
    }

    /**
     * @param $title
     *
     * @return string
     */
    public function makeSlug($title) : string
    {
        $slug = Str::slug($title);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get only published posts.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePublished(Builder $query) : Builder
    {
        return $query->status('publish');
    }

    /**
     * Get only posts with a custom status.
     *
     * @param Builder $query
     * @param string  $postStatus
     *
     * @return Builder
     */
    public function scopeStatus(Builder $query, string $postStatus) : Builder
    {
        return $query->where('status', $postStatus);
    }

    /**
     * Get only posts from a custom post type.
     *
     * @param Builder $query
     * @param string  $type
     *
     * @return Builder
     */
    public function scopeType(Builder $query, string $type) : Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Get only posts from an array of custom post types.
     *
     * @param Builder $query
     * @param array   $type
     *
     * @return Builder
     */
    public function scopeTypeIn(Builder $query, array $type) : Builder
    {
        return $query->whereIn('type', $type);
    }

    /**
     * @param Builder $query
     * @param null    $entity
     *
     * @return Builder
     * @throws \Throwable
     */
    public function scopeFiltersApply(Builder $query, $entity = null) : Builder
    {
        if (! is_null($entity)) {
            try {
                $this->getEntity($entity);
            } catch (TypeException $e) {
            }
        }

        return $this->filter($query);
    }

    /**
     * @param Builder $query
     * @param bool    $dashboard
     *
     * @return Builder
     */
    private function filter(Builder $query, $dashboard = false) : Builder
    {
        $filters = $this->entity->getFilters($dashboard);
        foreach ($filters as $filter) {
            $query = $filter->filter($query);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param null    $entity
     *
     * @return Builder
     * @throws \Throwable | TypeException
     */
    public function scopeFiltersApplyDashboard(Builder $query, $entity = null) : Builder
    {
        if (! is_null($entity)) {
            $this->getEntity($entity);
        }

        return $this->filter($query, true);
    }
}
