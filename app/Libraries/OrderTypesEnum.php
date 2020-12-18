<?php

namespace App\Libraries;

class OrderTypesEnum extends BasicEnum
{
    const MANU  = 'Manual';
    const GUAR  = 'Garantías';
    const SUGG  = 'Sugerido';


    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getTypesOrder()
    {
        return [
            '1' => self::MANU,
            '2' => self::GUAR,
            '3' => self::SUGG,

        ];
    }
}