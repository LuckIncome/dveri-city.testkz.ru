<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Translation extends \TCG\Voyager\Models\Translation
{
    use QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    //
}
