<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body printableArea">
                    <table width="100%">
                        <tr>
                            <td><img src="{{url('images/nsit-logo.png')}}" style="width: 150px" alt="homepage" class="light-logo" /></td>
                            <td class="text-center"> <h3> &nbsp;<b class="text-danger">UMEMEME UGANDA LTD</b></h3>
                            <h4>{{$audit->purpose}}<br>
                                CUSTOMER DETAILS</h4>
                            </td>
                            <td> <span class="pull-right"> {!! QrCode::size(120)->generate('Meter No.#'.$audit->id) !!}</span></td>
                        </tr>
                    </table>                       
                                    
                    
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>                                   
                                    <h3><b class="text-success h6">Submitted by:</b>{{$audit->user?->title}} &nbsp;<b class="text-danger">{{$audit->user?->name.' '.$audit->user?->other_name }}</b></h3>
                                    <h3><b class="text-success h6">Status:</b>{{$audit->status}}</h3>  
                                </address>
                            </div>
                            <div class="pull-right text-right">
                                <address>                                                                                              
                                    <p class=""><b class="text-success h6">Reg Date :</b> <i class="fa fa-calendar"></i> {{$audit->created_at}}</p>
                                    <p><b class="text-success h6">Print Date :</b> <i class="fa fa-calendar"></i> {{date('Y-M-D H:i:s')}}</p>
                                </address>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive m-t-2" style="clear: both;">
                                <table class="table table-hover" width="100%">
                                 
                                    <tbody>
                                        <tr>
                                            <td><b class="text-success h6">Customer Name:</b> {{$audit->customer}}</td>
                                            <td><b class="text-success h6">Contact:</b> {{$audit->customer_contact}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Meter No:</b> {{$audit->meter_number}}</td>
                                            <td><b class="text-success h6">Meter Type:</b> {{$audit->meterType?->name}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Work request:</b> {{$audit->purpose}}@if ($audit->purpose =='Complaint')
                                                (Customer Ref{{$audit->customer_ref_no}})
                                            @endif </td>
                                            <td><b class="text-success h6">Umeme District</b> {{$audit->district?->name}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Address:</b> {{$audit->location}}</td>
                                            <td><b class="text-success h6">Zone</b> {{$audit->zone?->name}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Feeder:</b> {{$audit->feeder?->name}}</td>
                                            <td><b class="text-success h6">Business Type</b> {{$audit->business_type}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Status:</b> {{$audit->status}}</td>
                                            <td><b class="text-success h6">Anomaly</b> {{$audit->anomaly}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Supply Tyep:</b> {{$audit->supply_type}}</td>
                                            <td><b class="text-success h6">Clamp on Reading</b> {{$audit->clamp_on_reading}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">CIU Reading:</b> {{$audit->ciu_reading??'N/A'}}</td>
                                            <td><b class="text-success h6">Average Consamption</b> {{$audit->average_consamption??'N/A'}}</td>                                                       
                                        </tr>

                                        <tr>
                                            <td><b class="text-success h6">Total Consumption:</b> {{$audit->total_consumption??'N/A'}}</td>
                                            <td><b class="text-success h6">Test Interpretation</b> {{$audit->test_interpretation??'N/A'}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Action Taken:</b> {{$audit->action_taken}}</td>
                                            <td><b class="text-success h6">Reason</b> {{$audit->reseon_left_on??'N/A'}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td colspan="2"><b class="text-success h6">Remarks</b> {{$audit->remarks}}</td>                                                   
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($audit->status !='Pending' )
                            <div class="col-md-6">
                                <table class="table table-hover" width="100%">
                                 
                                    <tbody>
                                        <tr>
                                            <td><b class="text-success h6">Received by:</b> {{$audit->receivedBy?->name??'N/A'}}</td>
                                            <td><b class="text-success h6">Comment:</b> {{$audit->receiver_comment}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Service order No:</b> {{$audit->service_oder_no}}</td> 
                                            <td><b class="text-success h6">Taken to lab by:</b> {{$audit->taken_by??'N/A'}}</td>                                                      
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-hover" width="100%">
                                 
                                    <tbody>
                                        <tr>
                                            <td><b class="text-success h6">Result:</b> {{$audit->result??'N/A'}}</td>
                                            <td><b class="text-success h6">New Meter No:</b> {{$audit->new_meter_no??'N/A'}}</td>                                                       
                                        </tr>
                                        <tr>
                                            <td><b class="text-success h6">Issued to:</b> {{$audit->issuedTo?->name??'Not yet issued'}}</td> 
                                            <td><b class="text-success h6">Energy recovery:</b> {{$audit->energy_recovery??'N/A'}} Amount {{$audit->amount_paid??'N/A'}}</td>                                                      
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
           
                        <div class="col-md-12">
                          
                            <div class="clearfix"></div>
                            <hr>
                            <div class="text-left">
                                @if ($audit->anomaly_image !=null)
                                <a href="javascript:void()" wire:click='downloadAnomalyimage' class="btn btn-info" ><i class="fa fa-download"></i> Anomaly Image</a>
                                @endif
                                @if ($audit->form_image !=null)
                                <a href="javascript:void()" wire:click='downloadAnomalyimage' class="btn btn-info" ><i class="fa fa-download"></i> Form Image</a>
                                @endif
                                @if ($audit->police_letter_image !=null)
                                <a href="javascript:void()"  wire:click='downloadPoliceimage' class="btn btn-info" ><i class="fa fa-download"></i> Police Letter Image</a>
                                @endif
                                @if ($audit->box_image !=null)
                                <a href="javascript:void()" wire:click='downloadBoximage' class="btn btn-info" ><i class="fa fa-download"></i> Box Image</a>
                                @endif
                                @if ($audit->house_image !=null)
                                <a href="javascript:void()" wire:click="downloadHouseimage"  class="btn btn-primary" ><i class="fa fa-download"></i> House Image</a>
                                @endif
                               </div>
                            <div class="text-right">
                                @if ($audit->status =='Pending')
                                <a href="javascript:void()"  data-toggle="modal" 
                                    data-target="#receiveMeter" class="btn btn-info" >Receive Meter </a>
                                @endif
                                @if ($audit->status =='Received')
                                <a href="javascript:void()"  data-toggle="modal" 
                                    data-target="#addMeterResults" class="btn btn-info" >Update Meter Results</a>
                                @endif
                                @if ($audit->result !=null && $audit->issued_to==null)
                                <a href="javascript:void()"  data-toggle="modal" 
                                    data-target="#issueMeter" class="btn btn-info" >Issue Meter</a>
                                @endif
                                @if ($audit->status =='Issued' && $audit->issued_to==auth()->user()->id)
                                <a href="javascript:void()" wire:click="receiveIssuedMeter"  class="btn btn-primary" >Received Issued Meter</a>
                                @endif
                                
                                <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="addMeterResults" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Results') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <form   wire:submit.prevent="addMeterResults" >
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="countryName" class="form-label">Added by By</label>
                                <input type="text" id="countryName" class="form-control" name="name" required readonly value="{{auth()->user()->name}}">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                <label for="result" class="form-label">Result</label>
                              <select name="result" required class="form-control form-control" wire:model.lazy='result' id="result">
                                <option value="">Select...</option>
                                @if ($audit->anomaly=='Stolen Meter')                                    
                                    <option value="Stolen Meter">Stolen Meter</option>
                                @else                                
                                    <option value="Passed">Passed</option>
                                    <option value="Tampered">Tampered</option>
                                    <option value="Faulty">Faulty</option>
                                @endif
                              </select>
                                @error('result')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($result =='Faulty')
                                <div class="mb-3 col-md-12">
                                    <label for="result" class="form-label">Result</label>
                                    <select name="status" required class="form-control form-control" wire:model.lazy='status' id="status">
                                        <option value="Scheduled">Scheduled For repalacement</option>
                                        <option value="Result Added">Result Added</option>
                                    </select>
                                        @error('status')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                </div>
                                @if ($status =='Scheduled')
                                    <div class="mb-3 col-md-12">
                                        <label for="issued_to" class="form-label required">Issued to</label>
                                        <input type="text" id="issued_to" class="form-control" name="new_meter_no" required wire:model.lazy="issued_to">
                                        @error('issued_to')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="new_meter_no" class="form-label required">New Meter No</label>
                                        <input type="text" id="new_meter_no" class="form-control" name="new_meter_no" required wire:model.lazy="new_meter_no">
                                        @error('new_meter_no')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            @endif
                            @if ($result == 'Stolen Meter')
                            <div class="mb-3 col-md-12">
                                <label for="issued_to" class="form-label required">Meter Charge</label>
                                <input type="number" step="any" id="meter_charge" class="form-control" name="meter_charge" required wire:model.lazy="meter_charge">
                                @error('meter_charge')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                            @if ($result =='Tampered' || $result == 'Stolen Meter')
                                <div class="mb-3 col-md-12">
                                    <label for="issued_to" class="form-label required">Energy recovery Units(kWh)</label>
                                    <input type="number" step="any" id="energy_recovery" class="form-control" name="energy_recovery" required wire:model.lazy="energy_recovery">
                                    @error('energy_recovery')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="amount_paid" class="form-label required">Ammount Paid</label>
                                    <input type="number" step="any" id="amount_paid" class="form-control" name="amount_paid" required wire:model.lazy="amount_paid">
                                    @error('amount_paid')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
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
    <div wire:ignore.self class="modal fade" id="receiveMeter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Receive meter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <form   wire:submit.prevent="receiveMeter" >
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="countryName" class="form-label">Received By</label>
                                <input type="text" id="countryName" class="form-control" name="name" required readonly value="{{auth()->user()->name}}">
                                @error('name')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-12">
                                    <label for="receiver_action" class="form-label">Action Taken</label>
                                    <select name="receiver_action" required class="form-control form-control" wire:model.lazy='receiver_action' id="receiver_action">
                                        <option value="">Select...</option>                                
                                        @if ($audit->anomaly =='Meter Ok')                                    
                                            <option value="Scheduled">Scheduled For repalacement</option>
                                        @elseif($audit->anomaly =='Tampered')
                                            <option value="Tampered">Energy Recovery</option>
                                        @else
                                            <option value="Taken To Lab">Taken To Lab</option>
                                            <option value="None">None</option>                                    
                                        @endif
                                    </select>
                                    @error('receiver_action')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                            </div>
                                @if ($receiver_action =='Scheduledd')
                                    <div class="mb-3 col-md-12">
                                        <label for="result" class="form-label">Result</label>
                                        <select name="status" required class="form-control" wire:model='status_result' id="status_result">
                                            <option value="">select</option>
                                            <option value="Issued">Issued</option>
                                            <option value="Not Issued">Not Issued</option>
                                        </select>
                                            @error('status_result')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    @if ($status_result =='Issued')
                                        <div class="mb-3 col-md-12">
                                            <label for="issued_to" class="form-label required">Issued to</label>
                                            <select name="issued_to" id="issued_to" class="form-control" wire:model="issued_to">
                                                <option value="">Select</option>
                                                @foreach ($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('issued_to')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-12">
                                            <label for="new_meter_no" class="form-label required">New Meter No</label>
                                            <input type="text" id="new_meter_no" class="form-control" name="new_meter_no" required wire:model.defer="new_meter_no">
                                            @error('new_meter_no')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                @elseif($receiver_action =='Tampered')
                                    <div class="mb-3 col-md-12">
                                        <label for="issued_to" class="form-label required">Energy recovery Units(kWh)</label>
                                        <input type="number" step="any" id="energy_recovery" class="form-control" name="energy_recovery" required wire:model.lazy="energy_recovery">
                                        @error('energy_recovery')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="result" class="form-label">Result</label>
                                        <select name="status" required class="form-control form-control" wire:model.lazy='status' id="status">
                                            <option value="">select</option>
                                            <option value="Received Paid">Paid</option>
                                            <option value="Received Not Paid">Not Paid</option>
                                        </select>
                                            @error('status')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    @if ($status =='Received Paid')
                                        <div class="mb-3 col-md-12">
                                            <label for="amount_paid" class="form-label required">Ammount Paid</label>
                                            <input type="number" step="any" id="amount_paid" class="form-control" name="amount_paid" required wire:model.lazy="amount_paid">
                                            @error('amount_paid')
                                                <div class="text-danger text-small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                @endif
                            @if ($receiver_action =='Taken To Lab')
                                <div class="mb-3 col-md-12">
                                    <label for="taken_by" class="form-label required">Taken By</label>
                                    <input type="text" name="taken_by" class="form-control" id="taken_by" required wire:model='taken_by'>
                                    @error('taken_by')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="service_oder_no" class="form-label required">Service Order No</label>
                                    <input type="text" id="service_oder_no" class="form-control" name="service_oder_no" required wire:model.lazy="service_oder_no">
                                    @error('service_oder_no')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                            
                            <div class="mb-3 col-md-12">
                                <label for="receiver_comment" class="form-label required">Comments</label>
                                <textarea id="receiver_comment" class="form-control" name="service_oder_no" required wire:model.lazy="receiver_comment"></textarea>
                                @error('receiver_comment')
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
    <div wire:ignore.self class="modal fade" id="issueMeter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Receive meter') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                
                <form   wire:submit.prevent="issueMeter" >
                    <div class="modal-body">
                       
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="issued_to" class="form-label required">Issued to</label>
                                <select name="issued_to" class="form-control" id="issued_to" wire:model.defer="issued_to">
                                    <option value="">Select</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('issued_to')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>                        
                            
                            <div class="mb-3 col-md-12">
                                <label for="date" class="form-label required">New meter No</label>
                                <input type="text" name="new_meter_no" id="new_meter_no" wire:model.defer='new_meter_no'  class="form-control">
                                @error('new_meter_no')
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
                $('#addMeterResults').modal('hide');
                $('#receiveMeter').modal('hide');
                $('#issueMeter').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
