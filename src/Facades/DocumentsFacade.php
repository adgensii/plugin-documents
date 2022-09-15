<?php

namespace Botble\Documents\Facades;

use Botble\Documents\DocumentsSupport;
use Illuminate\Support\Facades\Facade;

class DocumentsFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     */
    protected static function getFacadeAccessor()
    {
        return DocumentsSupport::class;
    }

}