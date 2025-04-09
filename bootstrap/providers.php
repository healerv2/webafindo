<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    App\Providers\ScheduleServiceProvider::class,
    App\Providers\XenditServiceProvider::class,
    RouterOS\Laravel\ServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
];
