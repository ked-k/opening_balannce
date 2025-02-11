<?php

namespace App\Http\Livewire\Management;

use Throwable;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Management\Zone;
use App\Models\Management\Aduit;
use App\Models\Management\Feeder;
use App\Models\Management\District;
use App\Models\Management\MeterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class AuditsComponent extends Component
{
    use WithPagination, WithFileUploads;
    
    public $perPage = 15;

    public $search = '';

    public $orderBy = 'created_at';

    public $orderAsc = true;
    public $createNew = false;

    public $mode = 'add';

    public $delete_id;

    public $edit_id;

    public $iteration = 1;

    public $template;

    public $page_title;

    protected $paginationTheme = 'bootstrap';

    public $purpose;
    public $location;
    public $district_id;
    public $zone_id;
    public $feeder_id;
    public $meter_type_id;
    public $meter_number;
    public $customer;
    public $customer_contact;
    public $business_type;
    public $anomaly;
    public $customer_ref_no;
    public $supply_type;
    public $created_by;       
    public $anomaly_image;
    public $clamp_on_reading;
    public $ciu_reading;
    public $average_consamption;
    public $total_consumption;
    public $test_interpretation;
    public $action_taken;
    public $reseon_left_on;
    public $remarks;
    public $police_letter = 1;
    public $police_letter_image;
    public $box_image;
    public $form_image;
    public $house_image;
    public $date_received;
    public $received_by;
    public $receiver_action;
    public $receiver_comment;
    public $currentUserInfo;
    public $cordinates;
    public function export()
    {
        // return (new AduitsExport())->download('Aduits.xlsx');
    }
    public function updatedCreateNew()
    {
        // if($this->createNew = true && $this->mode != 'edit'){
        //     $this->resetInputs();
        // }
      
        // $this->mode = 'add';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
       
       
        // dd($this->currentUserInfo);
        $this->page_title = 'Sample Types';
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'purpose'=>'required|string',
            'location'=>'required|string',
            'district_id'=>'required|integer',
            'zone_id'=>'required|integer',
            'feeder_id'=>'required|integer',
            'meter_type_id'=>'required|integer',
            'meter_number'=>'required|string',
            'customer'=>'required|string',
            'customer_contact'=>'nullable|string',
            'anomaly'=>'required|string',
            'business_type'=>'required|string',
            'customer_ref_no'=>'nullable|string',
            'supply_type'=>'required|string',     
            'anomaly_image'=>'required|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'clamp_on_reading'=>'nullable|string',
            'ciu_reading'=>'nullable|string',
            'average_consamption'=>'nullable|string',
            'total_consumption'=>'nullable|string',
            'test_interpretation'=>'nullable|string',
            'action_taken'=>'nullable|string',
            'reseon_left_on'=>'nullable|string',
            'remarks'=>'required|string',
            'police_letter_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'box_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'house_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
        ]);
    }
    public function validateNewData()
    {
        $this->validate([
            'purpose'=>'required|string',
            'location'=>'required|string',
            'district_id'=>'required|integer',
            'zone_id'=>'required|integer',
            'feeder_id'=>'required|integer',
            'meter_type_id'=>'required|integer',
            'meter_number'=>'required|string',
            'business_type'=>'required|string',
            'customer'=>'required|string',
            'customer_contact'=>'nullable|string',
            'anomaly'=>'required|string',
            'customer_ref_no'=>'nullable|string',
            'supply_type'=>'required|string',     
            'anomaly_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'clamp_on_reading'=>'required|string',
            'ciu_reading'=>'nullable|string',
            'average_consamption'=>'nullable|string',
            'total_consumption'=>'nullable|string',
            'test_interpretation'=>'nullable|string',
            'action_taken'=>'nullable|string',
            'reseon_left_on'=>'nullable|string',
            'remarks'=>'required|string',
            // 'police_letter'=>'nullable|integer',
            'police_letter_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'box_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'house_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
            'form_image'=>'nullable|mimes:jpg,bmp,png,pdf,docx|max:10240|file|min:2',
        ]);

    }
    public function storeData()
    {
       $this->validateNewData();
       $anomaly_path=null;
       $police_path = null;
       $box_path = null;
       $house_path =null;

       try {
        if($this->anomaly_image !=''){
            $path = 'Umeme/Audits/anomalies/'.date("Y-m");
            $anomaly_name = date('Ymdhis').'_'.time().'.'.$this->anomaly_image->extension();
            $anomaly_path = $this->anomaly_image->storeAs($path, $anomaly_name);
        }
        if($this->police_letter_image !=''){
            $path = 'Umeme/Audits/police/'.date("Y-m");
            $police_name = date('Ymdhis').'_'.time().'.'.$this->police_letter_image->extension();
            $police_path = $this->police_letter_image->storeAs($path, $police_name);
        }
        if($this->box_image !=''){
            $path = 'Umeme/Audits/box/'.date("Y-m");
            $box_name = date('Ymdhis').'_'.time().'.'.$this->box_image->extension();
            $box_path = $this->box_image->storeAs($path, $box_name);
        }
        if($this->house_image !=''){
            $path = 'Umeme/Audits/house/'.date("Y-m");
            $house_name = date('Ymdhis').'_'.time().'.'.$this->house_image->extension();
            $house_path = $this->house_image->storeAs($path, $house_name);
        }
        if($this->form_image !=''){
            $path = 'Umeme/Audits/form/'.date("Y-m");
            $form_name = date('Ymdhis').'_'.time().'.'.$this->form_image->extension();
            $form_path = $this->form_image->storeAs($path, $form_name);
        }
        $ip = Request()->ip();
        // $ip = '41.75.176.139'; /* Static IP address */
        $currentUserInfo = Location::get($ip);
        $Aduit = new Aduit();
        $Aduit->purpose = $this->purpose;
        $Aduit->anomaly = $this->anomaly;
        $Aduit->location = $this->location;
        $Aduit->district_id = $this->district_id;
        $Aduit->zone_id = $this->zone_id;
        $Aduit->feeder_id = $this->feeder_id;
        $Aduit->meter_type_id = $this->meter_type_id;
        $Aduit->meter_number = $this->meter_number;
        $Aduit->business_type = $this->business_type;
        $Aduit->customer = $this->customer;
        $Aduit->customer_contact = $this->customer_contact;
        $Aduit->customer_ref_no = $this->customer_ref_no;
        $Aduit->supply_type = $this->supply_type;
        $Aduit->anomaly_image = $anomaly_path;
        $Aduit->clamp_on_reading = $this->clamp_on_reading;
        $Aduit->ciu_reading = $this->ciu_reading;
        $Aduit->average_consamption = $this->average_consamption;
        $Aduit->total_consumption = $this->total_consumption;
        $Aduit->test_interpretation = $this->test_interpretation;
        $Aduit->action_taken = $this->action_taken;
        $Aduit->reseon_left_on = $this->reseon_left_on;
        $Aduit->remarks = $this->remarks;
        $Aduit->police_letter_image = $police_path;
        $Aduit->police_letter = $this->police_letter;
        $Aduit->box_image = $box_path;
        $Aduit->house_image = $house_path;        
        $Aduit->form_image = $form_path;
        $Aduit->cordinates = $this->cordinates;
        $Aduit->latitude = $currentUserInfo->latitude??null;
        $Aduit->longitude = $currentUserInfo->longitude??null;
        $Aduit->city = $currentUserInfo->cityName??null;
        
        $Aduit->save();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Aduit created successfully!']);
        
        } catch (\Exception $error) {
            Log::error($error . 'not saved.');
            Log::info($error);		// informational messages
            Log::debug($error);	
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Something went wrong!',
                'text' => 'Failed data not saved!'. $error,
            ]);
             $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Aduit record not created!']);
        }
    }
    public function editData(Aduit $Aduit)
    {
        $this->edit_id = $Aduit->id;
        $this->purpose = $Aduit->purpose ;
        $this->location = $Aduit->location;
        $this->anomaly = $Aduit->anomaly;
        $this->district_id = $Aduit->district_id ;
        $this->zone_id = $Aduit->zone_id;
        $this->feeder_id = $Aduit->feeder_id;
        $this->meter_type_id = $Aduit->meter_type_id;
        $this->meter_number = $Aduit->meter_number;
        $this->business_type = $Aduit->business_type;
        $this->customer = $Aduit->customer;
        $this->customer_contact = $Aduit->customer_contact;
        $this->customer_ref_no = $Aduit->customer_ref_no;
        $this->supply_type = $Aduit->supply_type;
        $this->anomaly_image = $Aduit->anomaly_image;
        $this->clamp_on_reading = $Aduit->clamp_on_reading;
        $this->ciu_reading = $Aduit->ciu_reading;
        $this->average_consamption = $Aduit->average_consamption;
        $this->total_consumption = $Aduit->total_consumption;
        $this->test_interpretation = $Aduit->test_interpretation;
        $this->action_taken = $Aduit->action_taken;
        $this->reseon_left_on = $Aduit->reseon_left_on;
        $this->remarks = $Aduit->remarks;
        $this->police_letter_image = $Aduit->police_letter_image;
        $this->police_letter = $Aduit->police_letter;
        $this->box_image = $Aduit->box_image;
        $this->house_image = $Aduit->house_image;
        $this->mode = 'edit';
        $this->createNew = true;
    }

    public function resetInputs()
    {
        $this->reset([ 
        'purpose',
        'location',
        'district_id',
        'zone_id',
        'feeder_id',
        'meter_type_id',
        'meter_number',
        'customer',
        'customer_contact',
        'anomaly',
        'customer_ref_no',
        'supply_type',
        'created_by',       
        'anomaly_image',
        'clamp_on_reading',
        'ciu_reading',
        'average_consamption',
        'total_consumption',
        'test_interpretation',
        'action_taken',
        'reseon_left_on',
        'remarks',
        'police_letter_image',
        'box_image',
        'house_image',
        'date_received',
        'received_by',
        'receiver_action',
        'receiver_comment',
        'business_type',
    ]);
        $this->mode = 'add';
        $this->createNew = false;
        $this->iteration = rand();
    }

    public function updateData()
    {
        $this->validateNewData();
        $Aduit = Aduit::find($this->edit_id);
        $Aduit->purpose = $this->purpose;
        $Aduit->anomaly = $this->anomaly;
        $Aduit->location = $this->location;
        $Aduit->district_id = $this->district_id;
        $Aduit->zone_id = $this->zone_id;
        $Aduit->feeder_id = $this->feeder_id;
        $Aduit->meter_type_id = $this->meter_type_id;
        $Aduit->meter_number = $this->meter_number;
        $Aduit->business_type = $this->business_type;
        $Aduit->customer = $this->customer;
        $Aduit->customer_contact = $this->customer_contact;
        $Aduit->customer_ref_no = $this->customer_ref_no;
        $Aduit->supply_type = $this->supply_type;
        $Aduit->anomaly_image = $this->anomaly_image;
        $Aduit->clamp_on_reading = $this->clamp_on_reading;
        $Aduit->ciu_reading = $this->ciu_reading;
        $Aduit->average_consamption = $this->average_consamption;
        $Aduit->total_consumption = $this->total_consumption;
        $Aduit->test_interpretation = $this->test_interpretation;
        $Aduit->action_taken = $this->action_taken;
        $Aduit->reseon_left_on = $this->reseon_left_on;
        $Aduit->remarks = $this->remarks;
        $Aduit->police_letter_image = $this->police_letter_image;
        $Aduit->police_letter = $this->police_letter;
        $Aduit->box_image = $this->box_image;
        $Aduit->house_image = $this->house_image;
        $Aduit->update();

        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Aduit updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function cancel()
    {
        $this->mode = 'add';
        $this->createNew = false;
        $this->delete_id = '';
        $this->edit_id = '';
        $this->resetInputs();
    }

    public function deleteAudit()
    {
        try{

            $audit = Aduit::where('id',$this->delete_id)->delete();

        }  catch(Throwable $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted '.$error.'!']);
        }
    }

    public function close()
    {
        $this->resetInputs();
    }

    public $latitude;
    public $longitude;

    protected $listeners = ['coordinatesSubmitted'];

    public function submitForm()
    {
        // Handle form submission
    }

    public function coordinatesSubmitted($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function render()
    {
        $data['districts'] = District::where('is_active',1)->get();
        $data['meter_types'] = MeterType::where('is_active',1)->get();
        $data['zones'] = Zone::where('is_active',1)  ->when($this->district_id, function ($query) {
            $query->where('district_id', $this->district_id);
        })->get();
        $data['feeders'] = Feeder::where('is_active',1)->get();
        $data['audits'] = Aduit::search($this->search)->with(['district','zone'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->where('status','Pending')
        ->paginate($this->perPage);
        return view('livewire.management.audits-component',$data);
    }
}
