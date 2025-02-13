<?php

namespace App\Imports\Inventory\Items;

use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\Inventory\Item\InvItem;
use App\Models\Inventory\Settings\InvCategory;
use App\Models\Inventory\Settings\InvUnitOfMeasure;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

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
        $entry_type = session()->get('entry_type');
        if (empty(array_filter($row))) {
            return null;
        }
        if (!$unit_id && $entry_type) {
            return null;
        }

        $validatedData = Validator::make($row, [
            'name' => 'required|string',
            'price' => 'numeric',
            'uom' => 'required|string',
            'category' => 'required|string',
        ])->validate();

        // Find an existing record with the same name
        $itemData = InvItem::where(['name' => $validatedData['name']])->first();
        $duplicateIds = [];
        // If an existing record is found update
        if ($itemData) {
            $itemData->name = $validatedData['name'];
            $itemData->cost_price = $validatedData['price'];
            $itemData->update();
            $this->attachUnit($unit_id, $entry_type, $itemData->id);
            return null;
        }

        $cat = InvCategory::where('name', $validatedData['category'])->first();
        if (!$cat) {
            $cat = new InvCategory();
            $cat->name = $validatedData['category'];
            $cat->is_active = 1;
            $cat->description = $validatedData['category'];
            $cat->save();
            $cat_id = $cat->id;
        } else {
            $cat_id = $cat->id;
        }

        $item_code = GeneratorService::generateInitials($cat->name ?? 'B R C I') . '_' . GeneratorService::getNumber(4) . date('md');
        // Create a new itemData instance and populate its attributes from the validated data
        $uom = InvUnitOfMeasure::where('name', $validatedData['uom'])->first();
        if (!$uom) {
            $uom = new InvUnitOfMeasure();
            $uom->name = $validatedData['uom'];
            $uom->packaging_type = 'Single';
            $uom->is_active = 1;
            $uom->description = $validatedData['uom'];
            $uom->save();
            $uom_id = $uom->id;
        } else {
            $uom_id = $uom->id;
        }
        $itemData = new InvItem([
            'name' => $validatedData['name'] ?? null,
            'uom_id' => $uom_id ?? null,
            'category_id' => $cat_id ?? 2,
            'item_code' => $item_code ?? GeneratorService::getNumber(5) . date('md'),
            'max_qty' => 200,
            'min_qty' => 10,
            'cost_price' => $validatedData['price'],
            'description' => $validatedData['name'] ?? null,
            'expires' => 1,
        ]);

        // Insert the itemData into the database
        $itemData->save();
        $this->attachUnit($unit_id, $entry_type, $itemData->id);
        return $itemData;
        // } catch (Throwable $error) {
        // Log::error($error . 'failed to import record.');

        // Add the duplicate name to the array
        //    return session()->flash('error', $error);
        // }
    }

    public function attachUnit($unit_id, $entry_type, $item_id)
    {
        $brand = 'N/A';

        $unitable = null;
        $check = null;
        if ($entry_type == 'Project') {
            $unitable = Project::find($unit_id);

        } elseif ($entry_type == 'Department') {
            $unitable = Department::find($unit_id);
        }
        $unit_type = get_class($unitable);
        $unit_id = $unitable->id;
        $check = InvDepartmentItem::where('inv_item_id', $item_id)
            ->where(['unitable_id' => $unit_id, 'unitable_type' => $unit_type])
            ->where('brand', $brand)->exists();

        if ($check) {

            return null;

        } else {
            $dept_item = new InvDepartmentItem();
            $dept_item->brand = $brand;
            $dept_item->inv_item_id = $item_id;
            $dept_item->entry_type = $entry_type;
            $dept_item->unitable()->associate($unitable);
            $dept_item->save();
        }
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
