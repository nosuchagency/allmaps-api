<?php

namespace App\Observers;

use App\Models\Container;

class ContainerObserver
{
    /**
     * Handle to the container "created" event.
     *
     * @param  \App\Models\Container $container
     *
     * @return void
     */
    public function created(Container $container)
    {
        $container->folders()->create([
            'name' => request()->get('folder_name') ?? 'Auto generated folder',
            'primary' => true
        ]);
    }

    /**
     * Handle the container "updated" event.
     *
     * @param  \App\Models\Container $container
     *
     * @return void
     */
    public function deleting(Container $container)
    {
        $container->folders()->each(function ($folder) {
            $folder->delete();
        });
    }

    /**
     * Handle the container "restoring" event.
     *
     * @param  \App\Models\Container $container
     *
     * @return void
     */
    public function restoring(Container $container)
    {
        $container->folders()->each(function ($folder) {
            $folder->restore();
        });
    }
}
