<?php

namespace App\Trait;

use DateTimeZone;

trait DateTrait
{
    private function getDateTime(int $unixtime): \DateTime{
        return \DateTime::createFromFormat('U', $unixtime, new DateTimeZone('Europe/Moscow'));
    }
}