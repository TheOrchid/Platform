<?php

namespace Orchid\Foundation\Core\Builders;

use Illuminate\Database\Eloquent\Builder;

class CommentBuilder extends Builder
{
    /**
     * Where clause for only approved comments.
     *
     * @return \Orchid\Foundation\Core\Builders\CommentBuilder
     */
    public function approved()
    {
        return $this->where('approved', 1);
    }
}
