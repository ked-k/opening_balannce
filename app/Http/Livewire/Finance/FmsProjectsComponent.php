<?php

namespace App\Http\Livewire\Finance;

use App\Models\Finance\MerpProject;
use App\Models\Finance\Project;
use App\Models\Finance\ProjectMou;
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
    public $grant_code;
    public $project;
    public $project_id;
    public $loadingInfo = '';
    public $editMode = false;
    public $mous;
    public $p_start_date;
    public $merp_id;
    public $savedMous;
    public $delete_id;
    public $mou_delete_id;

    protected $listeners = [
        'loadProject',
    ];

    public $mou_count = 1; // to keep track of the number of MOU fields

    protected $rules = [
        'name' => 'required|string|max:255',
        'mous.*.funding_amount' => 'required|numeric',
        'mous.*.start_date' => 'required|date',
        'mous.*.end_date' => 'nullable|date|after_or_equal:mous.*.start_date',
    ];

    public function mount()
    {
        // Initial setup for the first MOU
        $this->savedMous = collect([]);
        $this->mountMou();
    }
    public function mountMou()
    {
        // Initial setup for the first MOU
        $this->mous[] = ['start_date' => '', 'end_date' => '', 'funding_amount' => ''];
    }

    public function updatedMerpId()
    {
        $project = MerpProject::where('id', $this->merp_id)->first();
        $this->name = $project->name ?? null;
        $this->project_code = $project->project_code ?? null;
    }
    public function addMou()
    {
        $this->mou_count++;
        $this->mous[] = ['start_date' => '', 'end_date' => '', 'funding_amount' => ''];
    }
    public function resetMous()
    {
        // Reset MOU fields to initial state (empty or with default values)
        $this->mous = [['start_date' => '', 'end_date' => '', 'funding_amount' => '']];
        $this->mou_count = 1; // Reset MOU count
    }

    public function removeMou($index)
    {
        unset($this->mous[$index]);
        $this->mous = array_values($this->mous); // Reindex the array after removal
        $this->mou_count--;
    }

    public function updatedFafeeExemption()
    {
        if ($this->fa_fee_exemption) {
            $this->fa_percentage_fee = 0;
        }
    }

    public function deleteProject($id)
    {
        // $this->delete_id = $id;
        ProjectMou::where('project_id', $id)->delete();
        Project::where('id', $id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Project/study details deleted successfully']);

    }
    public function deleteProjectMou($id)
    {
        ProjectMou::where('id', $id)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Project MOU details deleted successfully']);

    }
    public function loadProject($id)
    {
        $this->edit_id = $id;

        $project = Project::findOrFail($this->edit_id);
        $this->project = $project;
        $this->project_type = $project->project_type;
        $this->project_category = $project->project_category;
        // $this->associated_institution = $project->associated_institution;
        $this->project_code = $project->project_code;
        $this->name = $project->name;
        $this->grant_code = $project->grant_code ?? null;
        // $this->sponsor_id = $project->sponsor_id;
        $this->funding_source = $project->funding_source;
        $this->currency_id = $project->currency_id;
        // $this->proposal_submission_date = $this->project->proposal_submission_date;
        // $this->pi = $project->pi??null;
        $this->merp_id = $project->merp_id ?? null;
        $this->p_start_date = $project->start_date;
        // $this->end_date = $project->_date;

        $this->fa_fee_exemption = $project->fa_fee_exemption;
        $this->fa_percentage_fee = $project->fa_percentage_fee;

        $this->project_summary = $project->project_summary;
        $this->progress_status = $project->progress_status;

        $this->editMode = true;
        $this->savedMous = $project->mous ?? collect([]);

    }

    public function storeProject()
    {
        $this->validate([
            'project_type' => 'required',
            'project_category' => 'required',
            'project_code' => 'required',
            'name' => 'required',
            // 'funding_amount' => 'required',
            'funding_source' => 'nullable',
            'currency_id' => 'required',
            // 'p_start_date' => 'required|date',
            'merp_id' => 'nullable|numeric',
            'fa_percentage_fee' => 'required',
            'project_summary' => 'nullable',
            'progress_status' => 'required',
        ]);

        DB::transaction(function () {

            $project = Project::updateOrCreate(
                ['id' => $this->edit_id],
                [
                    'project_type' => $this->project_type,
                    'project_category' => $this->project_category,
                    'grant_code' => $this->grant_code,
                    'project_code' => $this->project_code,
                    'name' => $this->name,
                    'merp_id' => $this->merp_id,
                    'funding_amount' => $this->funding_amount,
                    'funding_source' => $this->funding_source,
                    'currency_id' => $this->currency_id,
                    // 'start_date' => $this->p_start_date,
                    // 'end_date' => $this->p_start_date,
                    'fa_fee_exemption' => $this->fa_fee_exemption ?? true,
                    'fa_percentage_fee' => $this->fa_percentage_fee,
                    'project_summary' => $this->project_summary,
                    'progress_status' => $this->progress_status,
                ]
            );

            if ($this->mou_count > 0) {

                // foreach ($this->mous as $mouData) {
                //     if (isset($mouData['id'])) {
                //         $mou = ProjectMou::findOrFail($mouData['id']);
                //         $mou->update($mouData);
                //     } else {
                //         $mouData['project_id'] = $project->id;
                //         ProjectMou::create($mouData);
                //     }
                // }
                foreach ($this->mous as $mou) {
                    ProjectMou::create([
                        'project_id' => $project->id,
                        'start_date' => $mou['start_date'],
                        'end_date' => $mou['end_date'],
                        'funding_amount' => $mou['funding_amount'],
                    ]);
                }
            }
            $this->resetInputs();
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Project/study details created successfully']);

        });
    }

    public function close()
    {
        $this->resetInputs();
        $this->mou_count = 1;
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
            'p_start_date',
            'end_date',
            'fa_percentage_fee',
            'project_summary',
            'progress_status',
            'edit_id',
            'merp_id',
            'grant_code',
        ]);
        $this->resetMous();
        $this->savedMous = collect([]);
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
        $data['merpCodes'] = MerpProject::all();
        return view('livewire.finance.fms-projects-component', $data);
    }
}
