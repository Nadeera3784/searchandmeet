<?php


namespace App\Repositories\Country;

interface CountryPriceRepositoryInterface
{
    public function getAll();

    public function getByCountry($country_id);

    public function updateData($country_id ,$percentage, $type);

}