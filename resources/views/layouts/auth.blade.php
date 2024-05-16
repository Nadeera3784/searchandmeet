<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="/css/app.css"/>

    <link rel="icon" href="img/favicon.svg" sizes="any" type="image/svg+xml">

    <title>Search Meetings - Meeting</title>
</head>
@inject('domainDataService', 'App\Services\Domain\DomainDataService')
<body>
@include('components.toaster')
@include('layouts.nav')
@yield('content')
<script type="text/javascript" src="/js/app.js"></script>
@yield('custom-js')
</body>
</html>
