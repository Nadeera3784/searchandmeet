<?php

namespace App\Services\Domain;

class DomainDataService
{
    public function checkIdentifier($identifier)
    {
        if(!session()->has('current_domain')) return false;
        return $identifier == session()->get('current_domain');
    }
}
