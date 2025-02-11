<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\Project;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FmsProjectsComponent extends Component
{
    use WithPagination;

    //Filters
    public $projectIds;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;
    public $filter_fa_fee_exemption;
    public $project_code;
    public $name;
    public $project_category = 'Project';
    public $project_type = 'Primary';
    // public $associated_institution;
    // public $grant_id;
    public $sponsor_id;
    public $funding_amount;
    public $currency_id;
    public $proposal_submission_date;

    public $fa_fee_exemption = true;
    public $fa_percentage_fee;

    public $start_date;
    public $end_date;
    public $edit_id;
    public $funding_source;
    public $project_summary;
    public $progress_status;

    public $project;
    public $project_id;
    public $loadingInfo = '';
    public $editMode = false;

    protected $listeners = [
        'loadProject',
    ];

    public function updatedFafeeExemption()
    {
        if ($this->fa_fee_exemption) {
            $this->fa_percentage_fee = 0;
        }
    }

    public function loadProject($details)
    {
        $this->project_id = $details['projectId'];
        $this->loadingInfo = $details['info'];

        $project = Project::findOrFail($this->project_id);
        $this->project = $project;
        $this->project_type = $project->project_type;
        $this->project_category = $project->project_category;
        // $this->associated_institution = $project->associated_institution;
        $this->project_code = $project->project_code;
        $this->name = $project->name;
        // $this->grant_id = $project->grant_id??null;
        $this->sponsor_id = $project->sponsor_id;
        $this->funding_amount = $project->funding_amount;
        $this->currency_id = $project->currency_id;
        $this->proposal_submission_date = $this->project->proposal_submission_date;
        // $this->pi = $project->pi??null;
        // $this->co_pi = $project->co_pi??null;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;

        $this->fa_fee_exemption = $project->fa_fee_exemption;
        $this->fa_percentage_fee = $project->fa_percentage_fee;

        $this->project_summary = $project->project_summary;
        $this->progress_status = $project->progress_status;

        $this->editMode = true;
    }

    public function storeProject()
    {
        $this->validate([
            'project_type' => 'required',
            'project_category' => 'required',
            'project_code' => 'required',
            'name' => 'required',
            'funding_amount' => 'required',
            'funding_source' => 'required',
            'currency_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'fa_percentage_fee' => 'required',
            'project_summary' => 'nullable',
            'progress_status' => 'required',
        ]);

        DB::transaction(function () {

            $projectDTO = Project::updateOrCreate(
                ['id' => $this->edit_id],
                [
                    'project_type' => $this->project_type,
                    'project_category' => $this->project_category,
                    'project_code' => $this->project_code,
                    'name' => $this->name,
                    'funding_amount' => $this->funding_amount,
                    'funding_source' => $this->funding_source,
                    'currency_id' => $this->currency_id,
                    'start_date' => $this->start_date,
                    'end_date' => $this->end_date,
                    'fa_fee_exemption' => $this->fa_fee_exemption ?? true,
                    'fa_percentage_fee' => $this->fa_percentage_fee,
                    'project_summary' => $this->project_summary,
                    'progress_status' => $this->progress_status,
                ]
            );
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Project/study details created successfully']);

        });
    }

    public function resetInputs()
    {
        $this->reset([
            'project_type',
            'project_category',
            'project_code',
            'name',
            'funding_amount',
            'currency_id',
            'start_date',
            'end_date',
            'fa_percentage_fee',
            'project_summary',
            'progress_status',
        ]);

    }
    public function projectCreated($details)
    {
        $this->project_id = $details['projectId'];
    }

    public function updatedCreateNew()
    {
        // $this->reset();
        $this->toggleForm = !$this->toggleForm;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function filterProjects()
    {
        $projects = Project::search($this->search)

            ->when($this->project_category != '', function ($query) {
                $query->where('project_category', $this->project_category);
            })
            ->when($this->project_type != '', function ($query) {
                $query->where('project_type', $this->project_type);
            })
            ->when($this->progress_status != '', function ($query) {
                $query->where('progress_status', $this->progress_status);
            })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })
            ->when($this->filter_fa_fee_exemption, function ($query) {$query->where(['fa_fee_exemption' => $this->filter_fa_fee_exemption]);})
            ->addSelect([
                'projects.*',
                DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire'),
            ]);

        $this->projectIds = $projects->pluck('id')->toArray();

        return $projects;
    }

    public function export()
    {
        if (count($this->projectIds) > 0) {
            // return (new ProjectListExport($this->projectIds))->download('Projects_' . date('d-m-Y') . '_' . now()->toTimeString() . '.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Project selected for export!',
            ]);
        }
    }

    public function render()
    {
        $data['projects'] = $this->filterProjects()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.finance.fms-projects-component', $data);
    }
}
