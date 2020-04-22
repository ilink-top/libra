<?php

namespace App\Observers;

use App\Models\AdminMenu;
use Cache;

class AdminMenuObserver
{
    /**
     * Handle the admin menu "created" event.
     *
     * @param  \App\Models\AdminMenu  $adminMenu
     * @return void
     */
    public function created(AdminMenu $adminMenu)
    {
        Cache::forget($adminMenu->cacheKey);
    }

    /**
     * Handle the admin menu "updated" event.
     *
     * @param  \App\Models\AdminMenu  $adminMenu
     * @return void
     */
    public function updated(AdminMenu $adminMenu)
    {
        Cache::forget($adminMenu->cacheKey);
    }

    /**
     * Handle the admin menu "deleted" event.
     *
     * @param  \App\Models\AdminMenu  $adminMenu
     * @return void
     */
    public function deleted(AdminMenu $adminMenu)
    {
        Cache::forget($adminMenu->cacheKey);
    }

    /**
     * Handle the admin menu "restored" event.
     *
     * @param  \App\Models\AdminMenu  $adminMenu
     * @return void
     */
    public function restored(AdminMenu $adminMenu)
    {
        Cache::forget($adminMenu->cacheKey);
    }

    /**
     * Handle the admin menu "force deleted" event.
     *
     * @param  \App\Models\AdminMenu  $adminMenu
     * @return void
     */
    public function forceDeleted(AdminMenu $adminMenu)
    {
        Cache::forget($adminMenu->cacheKey);
    }
}
