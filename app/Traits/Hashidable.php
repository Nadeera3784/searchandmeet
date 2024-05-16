<?php


namespace App\Traits;


trait Hashidable
{
    public function getRouteKey()
    {
        return \Hashids::connection(get_called_class())->encode($this->getKey());
    }

    public static function decodeRouteKey($routeKey) {
        $id = \Hashids::connection(get_called_class())->decode($routeKey)[0] ?? null;
        $modelInstance = resolve(get_called_class());

        return  $modelInstance->findOrFail($id);
    }
}
