<?php

namespace Orchid\Core\Observers;

class NewsletterObserver
{
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
