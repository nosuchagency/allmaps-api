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
}
