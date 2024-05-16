<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use \Sushi\Sushi;

    protected $casts = [
        'date' => 'date',
    ];
    protected $rows = [
        [
            'title' => 'Self-serve digital platforms in, Global Trade in digital services is booming. how you can unleash its full potential',
            'image_url' => '/img/shutterstock_2036348216.jpg',
            'description' => "Since the start of COVID-19, self-serve platforms have been a great way for people to keep in touch with each other and stay informed about what's going on. Virtual meeting rooms provide an opportunity for businesses who might otherwise not get their message across so easily face -to--face or via phone calls because they're too busy running operations day",
            'date' => '2021-09-01',
            'path' => '2021-09/Self-serve-digital-platforms-in-Global-Trade-in-digital-services-is-booming-how-you-can-unleash-its-full-potential'
        ],
    ];
}
