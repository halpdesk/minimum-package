<?php

namespace Halpdesk\LaravelMinimumPackage\Facades;


use Illuminate\Support\Facades\Facade;

class PackageServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'LaravelMinimumPackageFacade';
    }
}
