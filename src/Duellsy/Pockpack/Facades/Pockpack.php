<?php namespace Duellsy\Pockpack\Facades;

use Illuminate\Support\Facades\Facade;

class Pockpack extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'pockpack'; }

}
