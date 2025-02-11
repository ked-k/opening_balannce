<?php

namespace App\Http\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Management\Aduit;

class IssuedMetersComponent extends Component
{
   
    use WithPagination;
    
    public $perPage = 15;

    public $search = '';

    public $orderBy = 'anomaly';

    public $orderAsc = true;
    public $createNew = false;

    public $mode = 'add';

    public $delete_id;

    public $edit_id;

    public $iteration = 1;

    public $template;

    public $page_title;

    public $district_id;

    protected $paginationTheme = 'bootstrap';

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


    public function close()
    {
        $this->resetInputs();
    }

    public function render()
    {
        $data['audits'] = Aduit::search($this->search)->with(['district','zone'])
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')->where(['issued_to'=>auth()->user()->id])
        ->paginate($this->perPage);
        return view('livewire.management.issued-meters-component',$data);
    }
}
