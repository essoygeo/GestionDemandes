<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */


    public function boot()
    {
        // Partage des notifications avec la vue topbar
        View::composer('partials.topbar', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $notifications = Notification::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);

                $unreadCount = Notification::where('user_id', $userId)
                    ->where('is_read', false)
                    ->count();

                $view->with([
                    'notifications' => $notifications,
                    'unreadCount' => $unreadCount,
                ]);
            }
        });
    }

}
