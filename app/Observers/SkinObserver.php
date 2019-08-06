<?php

namespace App\Observers;

use App\Models\Skin;

class SkinObserver
{
    /**
     * Handle the skin "deleted" event.
     *
     * @param  Skin $skin
     *
     * @return void
     */
    public function deleted(Skin $skin)
    {
        $skin->removeDirectory();
    }
}
