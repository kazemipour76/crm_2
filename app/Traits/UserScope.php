<?php

namespace App\Traits;

trait UserScope
{

    public function scopeUser($query)
    {
//        $query->where('_user_id', \Auth::id());
    }

    public function fillUser()
    {
//        $this->_user_id = \Auth::id();
    }

}
