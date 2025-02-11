<div>
    @section('title', 'Requests')
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
                            <div class="table-responsive">
                                <table id="datableButton" class="table table-borderedtable-bordered table-striped mb-0 w-100 sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Key Type') }}</th>
                                            <th>{{ __('Feeder') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Box Number') }}</th>
                                            <th>{{ __('Padlock Number') }}</th>
                                            <th>{{ __('Hook No') }}</th>
                                            <th>{{ __('Requested By') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($key_requests as $key => $keycont)
                                        <tr @if ($keycont->status != 'Available') class="text-warning" @endif>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $keycont->key->type }}</td>
                                                <td>{{ $keycont->key->feeder }}</td>
                                                <td>{{ $keycont->key->location }}</td>
                                                <td>{{ $keycont->key->box_no??'N/A' }}</td>
                                                <td>{{ $keycont->key->padlock_no }}</td>
                                                <td>{{ $keycont->key->hook_no }}</td>
                                                <td>{{ $keycont->user->name }}</td>
                                                <td>{{ $keycont->status }}</td>
                                                <td class="table-action">
                                                    <a href="javascript: void(0);" class="action-ico text-success mx-1 "
                                                        data-toggle="modal" wire:click="editData({{ $keycont->id }})"
                                                        data-target="#addnew"><i class="fa fa-edit"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="btn-group float-end">
                                        {{ $key_requests->links('vendor.livewire.bootstrap') }}
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                </div>
            </div>
        </div>
    </div>
    
    <div wire:ignore.self class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('New Key') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <form  wire:submit.prevent="findKey">
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="purpose" class="form-label">Type<small class="text-danger">*</small></label>
                                <select class="form-control select2" id="description" wire:model.lazy="description">
                                    <option value="" selected>Select</option>
                                    <option value="non_amr">Non -AMR Key Request</option>
                                    <option value="cluster">Clustered Key Request</option>
                                </select>
                                @error('purpose')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                                <div class="mb-3 col-md-12">
                                    
                                    <label for="find_key" class="form-label required">Search parameter<small class="text-danger">*</small></label>
                                    <div class="input-group">
                                        <div class="form-group">
                                            <select class="form-control select2" id="parameter" wire:model.defer="parameter">
                                                <option value="" selected>Select</option>
                                                @if ($description =='non_amr')                                                    
                                                    <option value="meter_number">Meter No</option>
                                                    <option value="account_no">Account No</option>
                                                @else                                                    
                                                    <option value="box_no">Box No</option>
                                                @endif
                                                <option value="padlock_no">Padlock No</option>
                                                <option value="hook_no">Hook No</option>
                                            </select>
                                            @error('purpose')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="find_key" required class="form-control" wire:model.defer="find_key">
                                                @error('find_key')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>                                   
                                </div> 
                        </div>
                    </div>                

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                </form>
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
