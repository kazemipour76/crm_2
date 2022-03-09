<?php
namespace App\Utilities;

use Illuminate\Support\Collection;

class MessageBag {

    CONST TYPE_SUCCESS = 'success';
    CONST TYPE_DANGER = 'danger';
    CONST TYPE_WARNING = 'warning';
    CONST TYPE_INFO = 'info';
    const SESSION_ID = 'MASSAGE_BAG';

    public static function push($message, $type = self::TYPE_DANGER)
    {
        $models = collect(session(self::SESSION_ID));
        $models->push([
           'message' => $message,
           'type' => $type
        ]);
        session()->put(self::SESSION_ID, $models->toArray());
    }


    public static function get(): Collection {
        return collect(session(self::SESSION_ID));
    }

    public static function pull(): Collection {
        return collect(session()->pull(self::SESSION_ID));
    }


}
