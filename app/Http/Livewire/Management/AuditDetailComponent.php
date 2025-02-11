<?php

namespace App\Http\Livewire\Management;

use App\Models\User;
use Livewire\Component;
use App\Models\Management\Aduit;
use Illuminate\Support\Facades\Storage;

class AuditDetailComponent extends Component
{
    public $audit_id, $receiver_action, $receiver_comment,$taken_by,$service_oder_no, $result, $new_meter_no, $issued_to,$energy_recovery, $amount_paid, 
    $status ='Result Added';
    public $status_result;
    public $auditDetails, $meter_charge, $proof_of_payement;
    public function mount($id)
    {
        $this->audit_id = $id;
    }
    public function receiveMeter()
    {
       $audit = Aduit::where('id', $this->audit_id)->first();
       $audit->result='Received';
       $audit->received_by=auth()->user()->id;
       $audit->receiver_action=$this->receiver_action;
       $audit->receiver_comment=$this->receiver_comment;
       if($this->receiver_action =='Scheduled' && $this->status_result =='Issued'){
        $audit->status='Issued';
        $audit->new_meter_no=$this->new_meter_no;
        $audit->issued_to=$this->issued_to;
       }else{
        $audit->status='Received';
        $audit->taken_by=$this->taken_by;
        $audit->service_oder_no=$this->service_oder_no;
       }
      
       $audit->update();          
    
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Meter received  successfully!']);
    }
    public function addMeterResults()
    {
        if($this->status ==null){
            $this->status ='Result Added';
        }
        Aduit::where('id', $this->audit_id)->update(['status'=>$this->status,
        'result'=>$this->result,
        'new_meter_no'=>$this->new_meter_no,
        'issued_to'=>$this->issued_to,
        'energy_recovery'=>$this->energy_recovery,
        'amount_paid'=>$this->amount_paid,
        'meter_charge'=>$this->meter_charge
    ]);
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Meter result added  successfully!']);
    }

    public function receiveIssuedMeter()
    {
        Aduit::where('id', $this->audit_id)->update(['status'=>'Completed',
        'date_completed'=>date('Y-m-d'),
    ]);
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Meter received  successfully!']);
    }

    public function issueMeter()
    {
        $this->validate([
            'issued_to'=>'required|string',
            'new_meter_no'=>'required|string',]);
        Aduit::where('id', $this->audit_id)->update([
        'status'=>'Issued',
        'new_meter_no'=>$this->new_meter_no,
        'issued_to'=>$this->issued_to,
        'date_issued'=>date('Y-m-d'),
    ]);
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Meter issued  successfully!']);
    }
    
    public function resetInputs()
    {
        $this->reset([  
        'receiver_action',
        'receiver_comment',
        'status',
        'taken_by',
        'service_oder_no',
        'result',
        'new_meter_no',
        'issued_to',
        'energy_recovery',
        'amount_paid',
        'meter_charge'
        ,]);
    }
    public function downloadAnomalyimage()
    {
        if($this->auditDetails){
        $file = storage_path('app/').$this->auditDetails->anomaly_image;
        if (file_exists($file)) {
            return Storage::download($this->auditDetails->anomaly_image, 'Anomaly Image'.date('His'));
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
        }else{
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
    }

    public function downloadPoliceimage()
    {
        if($this->auditDetails){
        $file = storage_path('app/').$this->auditDetails->police_letter_image;
        if (file_exists($file)) {
            return Storage::download($this->auditDetails->police_letter_image, 'Police letter Image'.date('His'));
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
        }else{
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
    }

    public function downloadBoximage()
    {
        if($this->auditDetails){
        $file = storage_path('app/').$this->auditDetails->box_image;
        if (file_exists($file)) {
            return Storage::download($this->auditDetails->box_image, 'Box Image'.date('His'));
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
        }else{
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
    }

    public function downloadHouseimage()
    {
        if($this->auditDetails){
        $file = storage_path('app/').$this->auditDetails->house_image;
        if (file_exists($file)) {
            return Storage::download($this->auditDetails->house_image, 'House Image'.date('His'));
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
        }else{
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'File not found! ']);
        }
    }

   

    public function render()
    {
        $data['audit']= $this->auditDetails = Aduit::with(['district','zone','user','meterType','feeder'])->where('id', $this->audit_id)->first();
        $data['users']= User::all();
        $this->new_meter_no =$data['audit']->new_meter_no;
        return view('livewire.management.audit-detail-component',$data);
    }
}
