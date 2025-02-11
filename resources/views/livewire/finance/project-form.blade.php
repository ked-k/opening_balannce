<div class="modal-body">
    <form wire:submit.prevent="storeProject">
        <div class="row">

            <div class="mb-3 col-md-3">
                <label for="project_category" class="form-label required">{{ __('Category') }}</label>
                <select class="form-control" id="project_category" wire:model.lazy="project_category">
                    <option selected value="">Select</option>
                    <option value="Project">Project</option>
                    <option value="Study">Study</option>
                    {{-- <option value="Grant">Grant</option> --}}
                </select>
                @error('project_category')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="project_type" class="form-label required">{{ __('Type') }}</label>
                <select class="form-control" id="project_type" wire:model.lazy="project_type">
                    <option selected value="">Select</option>

                    <option value="Primary">Primary</option>
                    <option value="Non-Primary">Non-Primary</option>


                </select>
                @error('project_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3 col-md-6">
                <label for="project_code" class="form-label required">{{ __('Project/Study/Grant Code') }}</label>
                <input type="text" id="project_code" class="form-control" wire:model.defer="project_code">
                @error('project_code')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label for="name" class="form-label required">{{ __('Name') }}</label>
                <input type="text" id="name" class="form-control" wire:model.defer="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>




            <div class="mb-3 col-md-6">
                <label for="funding_source" class="form-label">{{ __('Funding Source') }}</label>
                <input type="text" id="funding_source" class="form-control" wire:model.defer="funding_source">
                @error('funding_source')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="funding_amount" class="form-label">{{ __('Funding Amount') }}</label>
                <input type="number" id="funding_amount" class="form-control" wire:model.defer="funding_amount"
                    step="0.01">
                @error('funding_amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="currency_id" class="form-label required">{{ __('Currency') }}</label>
                <select class="form-control" id="currency_id" wire:model.lazy="currency_id">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="fa_percentage_fee" class="form-label @if (!$fa_fee_exemption) required @endif">F&A%
                </label>
                <input type="number" id="fa_percentage_fee" class="form-control" wire:model.defer="fa_percentage_fee"
                    max="100" min="0">
                @error('fa_percentage_fee')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="start_date" class="form-label required">Start Date</label>
                <input min='12-12-2024' type="date" id="start_date" class="form-control"
                    wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="end_date" class="form-label required">End Date</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-3">
                <label for="progress_status" class="form-label required">{{ __('Progress Status') }}</label>
                <select class="form-control" id="progress_status" wire:model.lazy="progress_status">
                    <option selected value="">Select</option>
                    <option value="Planning">Planning</option>
                    <option value="Pending Funding">Pending Funding</option>
                    <option value="Implementation">Implementation</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Data Analysis">Data Analysis</option>
                    <option value="Evaluation">Evaluation</option>
                    <option value="Reporting">Reporting</option>
                    <option value="Transition">Transition</option>
                    <option value="Completed">Completed</option>
                    <option value="On-hold">On Hold</option>
                    <option value="Terminated">Terminated</option>3
                </select>
                @error('progress_status')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label for="project_summary" class="form-label">{{ __('Project/Study/Grant Summary') }}</label>
                <textarea id="project_summary" class="form-control" wire:model.defer="project_summary"></textarea>
                @error('project_summary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
