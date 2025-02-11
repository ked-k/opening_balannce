<div>
    @section('title', 'Field Audits')
    @include('livewire.layouts.partials.inc.create-resource')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">                
                    @include('livewire.management.inc.new_audit')
                    <div class="tab-content" @if ($createNew) hidden @endif>                        
                        <x-table-utilities>
                            <div class="d-flex align-items-center ml-4 col-md-3">
                                <label for="orderBy" class="form-label text-nowrap mr-2 mb-0">OrderBy</label>
                                <select wire:model="orderBy" class="form-control">
                                    <option value="meter_number">Meter number</option>
                                    <option value="id">Latest</option>
                                </select>
                            </div>
                        </x-table-utilities>
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>Meter No.</th>
                                        <th>Zone</th>
                                        <th>Location</th>
                                        <th>Anomaly</th>
                                        <th>Status</th>
                                        <th>Created by</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audits as $key => $audit)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $audit->customer??'-' }}</td>
                                            <td>{{ $audit->customer_contact }}</td>
                                            <td>{{ $audit->meter_number ?? 'N/A' }}</td>
                                            <td>{{ $audit->zone->name ?? 'N/A' }}</td>
                                            <td>{{ $audit->location ?? 'N/A' }}</td>
                                            <td>{{ $audit->anomaly ?? 'N/A' }}</td>
                                            <td>{{ $audit->status ?? 'N/A' }}</td>
                                            <td>{{ $audit->user->name??'-' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($audit->created_at)) }}</td>
                                            <td class="table-action">
                                                <a href="javascript: void(0);" class="action-ico text-success mx-1 "
                                                data-toggle="modal" wire:click="editData({{ $audit->id }})"
                                                data-target="#addnew"><i class="fa fa-edit"></i></a>
                                                <a href="{{URL::SignedRoute('preview.audit', $audit->id)}}" title="view more detils" class="action-ico text-success mx-1 " ><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $audits->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div>
        </div>
    </div>

</div>
