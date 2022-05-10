<?php

namespace Grkztd\MfCloud\Misc;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade{

    protected static function getFacadeAccessor(){
        return 'grkztd.mfcloud.invoice';
    }
}
