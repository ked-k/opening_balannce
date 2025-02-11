<div>
    @section('title', 'Projects')
    @include('livewire.layouts.partials.inc.create-resource')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <x-table-utilities>
                            <div class="d-flex align-items-center ml-4 col-md-3">
                                <label for="orderBy" class="form-label text-nowrap mr-2 mb-0">OrderBy</label>
                                <select wire:model="orderBy" class="form-control">
                                    <option type="created_at">Name</option>
                                    <option type="id">Latest</option>
                                </select>
                            </div>
                        </x-table-utilities>
                        <div class="tab-content">
                            {{-- @include('livewire.grants.projects.inc.filter') --}}

                            <div class="table-responsive">
                                <table class="table table-striped mb-0 w-100 sortable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('Funding') }}</th>
                                            <th>{{ __('Start Date') }}</th>
                                            <th>{{ __('End Date') }}</th>
                                            {{-- <th>{{ __('PI') }}</th> --}}
                                            {{-- <th>{{ __('Progress Status') }}</th> --}}
                                            <th>{{ __('F&A %') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('public.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($projects as $key=>$project)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td title="{{ $project->name }}">{{ $project->project_code }}</td>
                                                <td>{{ $project->project_category }}</td>
                                                <td>@money_formart($project->fundingBalance())</td>
                                                <td>@formatDate($project->start_date)</td>
                                                <td>@formatDate($project->end_date)</td>
                                                {{-- <td>{{ $project->principalInvestigator?->fullName ?? 'N/A' }}</td> --}}
                                                <td><span
                                                        class="badge bg-danger">{{ $project->fa_percentage_fee }}</span>
                                                </td>
                                                {{-- <td><span class="badge bg-info">{{ ucfirst($project->progress_status) }}</span></td> --}}
                                                @if ($project->start_date > today())
                                                    <td><span class="badge bg-info">Coming soon...</span>

                                                    </td>
                                                @elseif ($project->end_date >= today())
                                                    <td><span class="badge bg-success">Running</span>
                                                        @if ($project->days_to_expire >= 0)
                                                            + ({{ $project->days_to_expire }}) days
                                                        @else
                                                        @endif
                                                    </td>
                                                @else
                                                    <td><span class="badge bg-danger">Ended</span></td>
                                                @endif

                                                <td>
                                                    <div class="d-flex justify-content-between">
                                                        <button class="btn btn-sm btn-outline-success m-1"
                                                            data-toggle="modal" data-target="#addnew"
                                                            wire:click="loadProject({{ $project->id }})"
                                                            title="{{ __('public.edit') }}">
                                                            <i class="fa fa-edit fs-18"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="btn-group float-end">
                                        {{ $projects->links('vendor.livewire.bootstrap') }}
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end tab-content-->
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('New Project') }}</h5>
                        <button type="button" class="close" wire:click="close()" data-dismiss="modal"
                            aria-hidden="true">×</button>
                    </div>
                    @include('livewire.finance.project-form')
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#addnew').modal('hide');
                $('#delete_modal').modal('hide');
                $('#show-delete-confirmation-modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
