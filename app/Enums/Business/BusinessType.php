<?php

namespace App\Enums\Business;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BusinessType extends Enum
{
    const Wholesale_And_Distributing = 1;
    const Exporter = 2;
    const Manufacturing = 3;
    const Internet_And_Web_Services = 4;
    const Legal_Services = 5;
    const Travel_And_Tourism  = 6;
    const Marketing_And_Advertising  = 8;
    const News_And_Media = 8;
    const Real_Estate = 9;
    const Shopping_And_Retail = 10;
    const eCommerce_And_SaaS = 11;
    const Sports_And_Recreation = 12;
    const Transportation = 13;
    const Utilities = 14;
    const Wedding_Events_And_Meetings = 15;
    const Accounting_And_Tax_Services = 16;
    const Arts_Culture_And_Entertainment = 17;
    const Auto_Sales_And_Service = 18;
    const Banking_And_Finance = 19;
    const Business_Services = 20;
    const Community_Organizations = 21;
    const Education = 22;
    const Health_And_Wellness = 23;
    const Insurance = 24;
    const Government_Agency = 25;
    const Private_Limited_Company = 26;
}