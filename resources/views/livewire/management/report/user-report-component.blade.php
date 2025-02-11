<div>
    @section('title', 'Field Audits')
    {{-- @include('livewire.layouts.partials.inc.create-resource') --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent='filterAudits' >
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label for="return_type" class="form-label">Return<small class="text-danger">*</small></label>
                                <select class="form-control select2" id="return_type" wire:model="return_type">
                                    <option value="" selected>Select</option>
                                    <option value="list">List</option>
                                    <option value="count">Number</option>
                                </select>
                                @error('return_type')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3 col-md-2">
                                <label for="anomaly" class="form-label">Anomaly<small class="text-danger">*</small></label>
                                <select class="form-control select2" id="anomaly" wire:model.defer="anomaly">
                                    <option value="All" selected>All</option>
                                    <option value="Meter Bypass">Meter Bypass</option>
                                    <option value="Tampered Meter">Tampered Meter</option>
                                    <option value="Faulty Meter">Faulty Meter</option>
                                    <option value="Stolen Meter">Stolen Meter</option>
                                    <option value="Abandoned Meter">Abandoned Meter</option>
                                    <option value="Meter Ok">Meter Ok</option>
                                </select>
                                @error('anomaly')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3 col-md-2">
                                <label for="other_name" class="form-label">Meter Type<small class="text-danger">*</small></label>
                            <select name="meter_type_id" id="meter_type_id"  class="form-control" wire:model.defer='meter_type_id'>
                                <option value="0">All</option>
                                @forelse ($meter_types as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                            </select>
                                @error('meter_type_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <div class="mb-3 col-md-2">
                                <label for="other_name" class="form-label">District<small class="text-danger">*</small></label>
                            <select name="district_id" id="district_id"  class="form-control" wire:model.defer='district_id'>
                                <option value="0">All</option>
                                @forelse ($districts as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                            </select>
                                @error('district_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="zone_id" class="form-label">Zone<small class="text-danger">*</small></label>
                            <select name="zone_id" id="zone_id"  class="form-control" wire:model.defer='zone_id'>
                                <option value="0">All</option>
                                @forelse ($zones as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                            </select>
                                @error('zone_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="other_name" class="form-label">Feeder<small class="text-danger">*</small></label>
                            <select name="feeder_id" id="feeder_id"  class="form-control" wire:model.defer='feeder_id'>
                                <option value="0">All</option>
                                @forelse ($feeders as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                            </select>
                                @error('feeder_id')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        
                        
                            <div class="col-md-2 mb-2">
                                <label for="simpleinput" class="form-label">From</label>
                                <input type="date" id="from" max="{{ date('Y-m-d') }}" name="from"  wire:model='from_date' class="form-control">
                            </div>
                            <div class="col-md-2  mb-2">
                                <label for="example-email" class="form-label">To</label>
                                <input type="date" id="to" wire:model='to_date' name="to" class="form-control">
                            </div>
                            <div class="mb-3 col">
                                <label for="other_name" class="form-label">User<small class="text-danger">*</small></label>
                            <select name="created_by" id="created_by"  class="form-control" wire:model.defer='created_by'>
                                <option value="0">All</option>
                                @forelse ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @empty
                                <option value="">List Empty</option>
                                @endforelse
                            </select>
                                @error('created_by')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($return_type =='count')
                                <div class="mb-3 col-md-2">
                                    <label for="group_by" class="form-label">Group By<small class="text-danger">*</small></label>
                                    <select class="form-control select2" id="group_by" required wire:model.defer="group_by">
                                        <option selected value="">Select</option>
                                        <option value='User'>User</option>
                                        <option value='Feeder'>Feeder</option>
                                        <option value='Meter'>Meter type</option>
                                        <option value='District'>District</option>
                                        <option value='Zone'>Zone</option>
                                        <option value='Anormaly'>Anormaly</option>
                                    </select>
                                    @error('group_by')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif                            
                            <div class="col-md-2">
                                <x-button class="btn-sm btn-success mt-4">{{ __('Generate') }}</x-button>
                            </div>
                        
                        
                            {{-- =============================DYNAMIC FORM FIELDS======================= --}}
                        
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div class="card">
                <div class="card-body"> 
                    @if (!$audits->isEmpty())
                    <button class="btn btn-outline-success" onclick="fnExcelReport();" >Export Data</button>
                        @if ($return_type =='count')
                        <div class="tab-content"> 
                            <div class="table-responsive">
                                <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>{{$group_by}} Name</th>
                                            <th>Dates</th>
                                            <th> No of collections</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($audits as $key => $audit)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    @if ($group_by =='User'){{ $audit->user->name??'-' }}@endif
                                                    @if ($group_by =='District'){{ $audit->district->name??'-' }}@endif
                                                    @if ($group_by =='Zone'){{ $audit->zone->name??'-' }}@endif
                                                    @if ($group_by =='Meter'){{ $audit->meterType->name??'-' }}@endif
                                                    @if ($group_by =='Meter'){{ $audit->meterType->name??'-' }}@endif
                                                    @if ($group_by =='Feeder'){{ $audit->feeder->name??'-' }}@endif
                                                    @if ($group_by =='Anormaly'){{ $audit->anomaly??'-' }}@endif
                                                </td>
                                                <td>{{ $audit->display_date }}</td>
                                                <td>{{ $audit->number_count ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end preview-->
                        </div> <!-- end tab-content-->
                        @else
                            <div class="tab-content"> 
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
                                                <th>Created at</th>
                                                <th>Created by</th>
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
                                                    <td>{{ date('d-m-Y', strtotime($audit->created_at)) }}</td>
                                                    <td>{{ $audit->user->name??'-' }}</td>
                                                    <td class="table-action">
                                                        
                                                        <a target="_blank" href="{{URL::SignedRoute('preview.audit', $audit->id)}}" title="view more detils" class="action-ico text-success mx-1 " ><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->
                            </div> <!-- end tab-content-->
                        @endif
                        @else
                        <h5 class="text-success text-center">User the filter to generate reports</h5>
                    @endif  

                </div> <!-- end card body-->
            </div>
        </div>
    </div>
    @push('scripts')


    <script type="text/javascript">
        function fnExcelReport() {
            var table = document.getElementById('datableButton'); // Get the table element
    
            var wb = XLSX.utils.table_to_book(table, { sheet: 'Sheet 1' });
            var wbout = XLSX.write(wb, { bookType: 'xlsx', bookSST: true, type: 'binary' });
    
            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i < s.length; i++) view[i] = s.charCodeAt(i) & 0xff;
                return buf;
            }
    
            var blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
            var downloadLink = document.createElement('a');
            downloadLink.href = URL.createObjectURL(blob);
            downloadLink.download = 'Mak BRC Payroll.xlsx';
            downloadLink.click();
        }
    </script>
    @endpush
</div>
