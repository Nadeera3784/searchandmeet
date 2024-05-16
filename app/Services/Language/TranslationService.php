<?php


namespace App\Services\Language;


use App\Models\Language;

class TranslationService
{
    private $freeLanguages = [

    ];

    public function getTranslationCombinations($personA, $personB)
    {
        $combinations = [];
        //check if any intersecting combinations exist
        if(!array_intersect($personA->preferredLanguages->pluck('id')->toArray(), $personB->preferredLanguages->pluck('id')->toArray())) {
            //else find matching combinations
            if ($personA->preferredLanguages->count() > 0 && $personB->preferredLanguages->count() > 0) {
                foreach ($personA->preferredLanguages as $languageA) {
                    foreach ($personB->preferredLanguages as $languageB) {
                        if ($languageA->id !== $languageB->id) {
                            $price = $this->getTranslationPrice($languageA, $languageB);
                            array_push($combinations, [
                                'first' => $languageA,
                                'second' => $languageB,
                                'price' => $price,
                                'code' => $this->getCombinationCode($languageA, $languageB)
                            ]);
                        }
                    }
                }
            }
        }

        return $combinations;
    }

    public function getTranslationPrice($languageA, $languageB)
    {
        $english = Language::where('name', 'English')->first();
        if(in_array($languageA->id, $this->freeLanguages) || in_array($languageB->id, $this->freeLanguages))
        {
            return 0;
        }

        if($languageA->id === $english->id || $languageB->id === $english->id)
        {
            return 20;
        }

        if($languageA->id !== $english->id && $languageB->id !== $english->id)
        {
            return 40;
        }

        return 0;
    }

    public function getCombinationCode($languageA, $languageB)
    {
       return "$languageA->id,$languageB->id";
    }

    public function getCombinationByCode($code)
    {
       if($code)
       {
           $ids = explode(',', $code);
           $languageA = Language::find($ids[0]);
           $languageB = Language::find($ids[1]);

           if($languageA && $languageB)
           {
               return [
                   0 => $languageA,
                   1 => $languageB,
               ];
           }
       }

       return [];
    }

}