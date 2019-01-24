<?php

final class util
{

    public static function inverteData($data, $type = '')
    {
        if ($type == 'EUA') {
            $newDate = date("Y-m-d", strtotime($data));
        }

        if ($type == 'BRA') {
            $newDate = date("d/m/Y", strtotime($data));
        }

        if (! $newDate) {

            if (strpos($data, '/') !== false) {
                $newDate = date("Y-m-d", strtotime($data));
            }

            if (strpos($data, '-') !== false) {
                $newDate = date("d/m/Y", strtotime($data));
            }
        }

        return $newDate;
    }

    public static function money($value)
    {
        $value = str_replace(',', '.', $value);
        $values = explode('.', $value);
        $out = preg_replace("/[^0-9]/", "", $values[0]) . "." . preg_replace("/[^0-9]/", "", $values[1]);
        return $out;
    }
}