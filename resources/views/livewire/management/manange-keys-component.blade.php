<div>
    @section('title', 'Non AMR Keys')
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
                                    <option type="created_at">Date</option>
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
                                            <th>{{ __('Feeder') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Hook No') }}</th>
                                            <th>{{ __('Padlock No') }}</th>
                                            <th>{{ __('Cunstomer') }}</th>
                                            <th>{{ __('Meter Number') }}</th>
                                            <th>{{ __('Account Number') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($keys as $key => $keycont)
                                            <tr @if ($keycont->status != 'Available') class="text-warning" @endif>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $keycont->feeder }}</td>
                                                <td>{{ $keycont->location }}</td>
                                                <td>{{ $keycont->hook_no }}</td>
                                                <td>{{ $keycont->padlock_no }}</td>
                                                <td>{{ $keycont->customer }}</td>
                                                <td>{{ $keycont->meter_number }}</td>
                                                <td>{{ $keycont->account_no }}</td>
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
                                        {{ $keys->links('vendor.livewire.bootstrap') }}
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('New District') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <form @if ($mode == 'edit') wire:submit.prevent="updateData" @else  wire:submit.prevent="storeData" @endif>
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="other_name" class="form-label">Feeder<small class="text-danger">*</small></label>
                               <select name="feeder_id" id="feeder"  class="form-control" wire:model.lazy='feeder'>
                                <option value="">Select</option>
                                @forelse ($feeders as $item)
                                    <option value="{{$item->name}}">{{$item->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                               </select>
                                @error('feeder')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="location" class="form-label">location</label>
                                <input type="text" id="location" class="form-control" name="location" required wire:model.defer="location">
                                @error('location')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="meter_number" class="form-label">Meter_number</label>
                                <input type="text" id="meter_number" class="form-control" name="meter_number" required wire:model.lazy="meter_number">
                                @error('meter_number')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="account_no" class="form-label">Acc_number</label>
                                <input type="text" id="account_no" class="form-control" name="account_no" required wire:model.lazy="account_no">
                                @error('account_no')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="customer" class="form-label">customer</label>
                                <input type="text" id="customer" class="form-control" name="customer" required wire:model.defer="customer">
                                @error('customer')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="hook_no" class="form-label">Hook number</label>
                                <input type="text" id="meter_number" class="form-control" name="hook_no" required wire:model.defer="hook_no">
                                @error('hook_no')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>    
                            <div class="mb-3 col-md-6">
                                <label for="hook_no" class="form-label">Padlock number</label>
                                <input type="text" id="padlock_no" class="form-control" name="padlock_no" required wire:model.lazy="padlock_no">
                                @error('padlock_no')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
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
