<?php

namespace App\Services;

use App\Models\HelpDesk\Ticket;
use App\Models\NetworkManagement\Institution;
use App\Models\SampleManagement\ReferralRequest;
use App\Models\SampleManagement\SampleShipment;
use Illuminate\Support\Str;

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

        return str_shuffle($randomNumber.$randomSymbol.$randomUppercase.$randomLowercase);
    }

    //Generate standard ticket reference
    public static function ticketReference()
    {
        $reference = '';
        $yearStart = date('y');
        $latestReference = Ticket::select('reference_number')->orderBy('id', 'desc')->first();

        if ($latestReference) {
            $referenceNumberSplit = explode('-', $latestReference->reference_number);
            $referenceYear = (int) filter_var($referenceNumberSplit[0], FILTER_SANITIZE_NUMBER_INT);

            if ($referenceYear == $yearStart) {
                $reference = $referenceNumberSplit[0].'-'.str_pad(((int) filter_var($referenceNumberSplit[1], FILTER_SANITIZE_NUMBER_INT) + 1), 3, '0', STR_PAD_LEFT).'TR';
            } else {
                $reference = '#NIMS'.$yearStart.'-001TR';
            }
        } else {
            $reference = '#NIMS'.$yearStart.'-001TR';
        }

        return $reference;
    }
}
