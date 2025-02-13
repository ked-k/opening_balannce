<?php

namespace App\Services;

class GeneratorService
{
    public static function password($length = 2)
    {
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomNumber = '';
        $randomSymbol = '';
        $randomUppercase = '';
        $randomLowercase = '';
        for ($i = 0; $i < $length; $i++) {
            $randomNumber .= $numbers[rand(0, strlen($numbers) - 1)];
            $randomSymbol .= $symbols[rand(0, strlen($symbols) - 1)];
            $randomUppercase .= $uppercase[rand(0, strlen($uppercase) - 1)];
            $randomLowercase .= $lowercase[rand(0, strlen($lowercase) - 1)];
        }

        return str_shuffle($randomNumber . $randomSymbol . $randomUppercase . $randomLowercase);
    }

    //Generate standard ticket reference
    public static function getNumber($length)
    {
        $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return str_shuffle($randomString);
        return $randomString;
    }
}
