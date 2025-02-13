<?php

namespace App\Imports;

use App\Models\Finance\ExpenseType;
use App\Models\Finance\FmsCurrencies;
use App\Models\Finance\FmsTransaction;
use App\Models\Finance\Project;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransactionsImport implements ToModel, WithHeadingRow
{
    // public function startRow(): int
    // {
    //     return 2;
    // }

    /**
     * @param  Failure[]  $failures
     */

    public function model(array $row)
    {
        // try {
        // Validate the data
        $unit_id = session()->get('unit_id');

        if (empty(array_filter($row))) {
            return null;
        }
        if (!$unit_id) {
            return null;
        }

        $validatedData = Validator::make($row, [
            'reference' => 'required',
            'date' => 'numeric',
            'amount' => 'numeric',
            'type' => 'required|string|in:Income,Expense',
            'category' => 'required|string|in:Salaries,Fuel,Supplies,Equipment,Travel,Other Services,Other Direct Costs,Participants Honorarium,Grants Installments,Field Activities',
            'memo' => 'required|string',
            'client' => 'required|string',
            'currency' => 'required|string|in:UGX,USD,GBP,EURO',
        ])->validate();
        $dateValue = $validatedData['date'];
        // dd($dateValue);
        $date = Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
        // $formattedDate = $date->format('Y-m-d');
        $payable = Project::where('id', $unit_id)->first();
        // Find an existing record with the same name
        $itemData = FmsTransaction::where(['trx_ref' => $validatedData['reference'], 'project_id' => $unit_id])->first();
        $duplicateIds = [];
        // If an existing record is found update
        if ($itemData) {
            return null;
        }

        $currency = FmsCurrencies::where('code', $validatedData['currency'])->first();
        if (!$currency) {
            return null;
        } else {
            $currency_id = $currency->id;
            $rate = $currency->exchange_rate;
            $amount_local = $validatedData['amount'] * $rate;
        }
        $trx_no = GeneratorService::getNumber(4) . date('md');
        // Create a new itemData instance and populate its attributes from the validated data
        $expType = ExpenseType::where('name', $validatedData['category'])->first();
        if (!$expType) {
            $expType = new ExpenseType();
            $expType->name = $validatedData['category'];
            $expType->type = $validatedData['type'];
            $expType->is_active = 1;
            $expType->save();
            $expType_id = $expType->id;
        } else {
            $expType_id = $expType->id;
        }
        $trans = new FmsTransaction();
        $trans->trx_no = $trx_no;
        $trans->trx_ref = $validatedData['reference'];
        $trans->trx_date = $date;
        $trans->client = $validatedData['client'];
        $trans->total_amount = $validatedData['amount'];
        $trans->amount_local = $amount_local;
        $trans->rate = $rate;
        $trans->project_id = $unit_id;
        $trans->currency_id = $currency_id;
        $trans->expense_type_id = $expType_id;
        $trans->trx_type = $validatedData['type'];
        $trans->entry_type = 'OP';
        $trans->description = $validatedData['memo'];
        $trans->requestable()->associate($payable);
        $trans->save();

        return $trans;
        // } catch (Throwable $error) {
        // Log::error($error . 'failed to import record.');

        // Add the duplicate name to the array
        //    return session()->flash('error', $error);
        // }
    }

    /**
     * @param  array  $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    /**
     * @return string|array
     */
    public function uniqueBy()
    {
        return 'name';
    }

    public function rules(): array
    {
        return [
            // 'name' => 'required|unique:sample_data',
            //'specimen_type' => 'required',
            // 'collection_date' => 'required',
        ];
    }

    public function batchSize(): int
    {
        return 5;
    }

    // public function chunkSize(): int
    // {
    //     return 100;
    // }
}
