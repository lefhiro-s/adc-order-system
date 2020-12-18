<?php

namespace App\Libraries;

class OrderStatusEnum extends BasicEnum
{
    const CREATED   = 'CREADO';
    const APPROVED  = 'APROBADO';
    const REJECTED  = 'RECHAZADO';
    const GENERATED = 'GENERADO';
    const ERROR     = 'ERROR';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getStatusOrder()
    {
        return [
            '1' => self::CREATED,
            '2' => self::APPROVED,
            '3' => self::REJECTED,
            '4' => self::GENERATED,
            '5' => self::ERROR,

        ];
    }
}