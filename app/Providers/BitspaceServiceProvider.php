<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BitspaceServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Contracts\PlatformContract' => 'App\Repositories\ZoomRepository'
    ];

    public function register()
    {
//       foreach ($this->repositories as $interface => $implementation) {
//           $this->app->bind($interface, $implementation);
//           $this->app->when($implementation[1])
//               ->needs($interface)
//               ->give(function () {
//                   return new IndexRepository;
//               });
//       }

        foreach ($this->repositories as $interface => $implementation) {
           $this->app->bind($interface, $implementation);
        }
    }

}
