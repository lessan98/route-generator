<?php

namespace Test\RouteGenerator;

abstract class TicketType{

    const Bus = 0;

    const Train = 1;

    const Boat = 2;

    const Airplane = 3;

    public static $availableTypes = [self::Bus, self::Train, self::Boat, self::Airplane];

    public static function isValid(int $num){
        return in_array($num, self::$availableTypes);
    }
}