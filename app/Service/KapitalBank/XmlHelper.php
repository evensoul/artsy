<?php

declare(strict_types=1);

namespace App\Service\KapitalBank;

class XmlHelper
{
    public static function generateXML(array $data): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><TKKPG>';
        $xml .= self::arrayToXML($data);
        $xml .= '</TKKPG>';
        return $xml;
    }

    public static function arrayToXML(array $data): string
    {
        $xml = '';
        foreach ($data as $key => $val) {
            $xml .= "<$key>";
            if (is_array($val)) {
                $xml .= self::arrayToXML($val);
            } else {
                $xml .= $val;
            }
            $xml .= "</$key>";
        }
        return $xml;
    }
}
