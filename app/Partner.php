<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;
use TCG\Voyager\Traits\Translatable;

class Partner extends Model
{
    use Translatable, QueryCacheable;
    public $cacheFor = 2592000;
    protected static $flushCacheOnUpdate = true;
    protected $translatable = ['name', 'content'];
}
