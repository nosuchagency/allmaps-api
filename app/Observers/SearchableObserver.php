<?php

namespace App\Observers;

use App\Models\Searchable;

class SearchableObserver
{
    /**
     * Handle to the searchable "installed" event.
     *
     * @param  \App\Models\Searchable $searchable
     *
     * @return void
     */
    public function created(Searchable $searchable)
    {
        
    }

    /**
     * Handle to the searchable "uninstalled" event.
     *
     * @param  \App\Models\Searchable $searchable
     *
     * @return void
     */
    public function deleted(Searchable $searchable)
    {

    }
}
