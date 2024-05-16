<?php

/**
 * Copyright (c) Vincent Klaiber.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://github.com/vinkla/laravel-hashids
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [
        \App\Models\Person::class => [
            'salt' => \App\Models\Person::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\User::class => [
            'salt' => \App\Models\User::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Business::class => [
            'salt' => \App\Models\Business::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Category::class => [
            'salt' => \App\Models\Category::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Order::class => [
            'salt' => \App\Models\Order::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\PurchaseRequirement::class => [
            'salt' => \App\Models\Order::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Transaction::class => [
            'salt' => \App\Models\Order::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Meeting::class => [
            'salt' => \App\Models\Meeting::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Lead::class => [
            'salt' => \App\Models\Lead::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\MeetingRequest::class => [
            'salt' => \App\Models\MeetingRequest::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Communication\Conversation::class => [
            'salt' => \App\Models\Communication\Conversation::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Package::class => [
            'salt' => \App\Models\Package::class. env('HASH_IDS'),
            'length' => 10,
        ],
        \App\Models\Matchmaking\Match::class => [
            'salt' => \App\Models\Matchmaking\Match::class. env('HASH_IDS'),
            'length' => 10,
        ],
    ],

];
