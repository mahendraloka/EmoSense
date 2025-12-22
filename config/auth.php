<?php

return [

    'guards' => [
        'mahasiswa' => [
            'driver' => 'session',
            'provider' => 'mahasiswas',
        ],

        'psikolog' => [
            'driver' => 'session',
            'provider' => 'psikologs',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'mahasiswas' => [
            'driver' => 'eloquent',
            'model' => App\Models\Mahasiswa::class,
        ],

        'psikologs' => [
            'driver' => 'eloquent',
            'model' => App\Models\Psikolog::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],
];
