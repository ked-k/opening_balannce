<?php

use App\Models\Finance\FmsCurrencies;

//CURRENCY HELPERS
function getCurrencies()
{
    $currencies = FmsCurrencies::all();

    return $currencies;
}

function getDefaultCurrency()
{
    $defaultCurrency = FmsCurrencies::where('system_default', true)->first();

    return $defaultCurrency;
}

function formatDate($expression)
{

    return $expression != null ? "<?php echo date('d-M-Y', strtotime($expression)); ?>" : "<?php echo 'N/A'; ?>";

}
