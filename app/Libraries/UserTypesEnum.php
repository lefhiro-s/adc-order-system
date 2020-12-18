<?php

namespace App\Libraries;

class UserTypesEnum extends BasicEnum
{
    const ADMIN = 'Administrador';
    const USER  = 'Usuario';
    const DESC  = 'Desactivado';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getTypesUser()
    {
        return [
            '1' => self::USER,
            '2' => self::ADMIN,
            '0' => self::DESC
        ];
    }
}