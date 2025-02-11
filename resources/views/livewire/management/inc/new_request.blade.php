<form
@if ($mode=='add') wire:submit.prevent="storeData"
@else
wire:submit.prevent="updateData" @endif
@if (!$createNew) hidden @endif>
<div class="row">
    <div class="mb-3 col-md-2">
        <label for="purpose" class="form-label">Purpose<small class="text-danger">*</small></label>
        <select class="form-control select2" id="purpose" wire:model.lazy="purpose">
            <option value="" selected>Select</option>
            <option value="Audit">Audit</option>
            <option value="Complaint">Complaint</option>
        </select>
        @error('purpose')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
    @if ($purpose =='Complaint')
        <div class="mb-3 col-md-3">
            <label for="customer_ref_no" class="form-label required">Customer Ref<small class="text-danger">*</small></label>
            <input type="text" style="text-transform: uppercase" id="customer_ref_no" required class="form-control" wire:model.lazy="customer_ref_no">
                @error('customer_ref_no')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div> 
    @endif
    
    <div class="mb-3 col-md-2">
        <label for="anomaly" class="form-label">Anomaly<small class="text-danger">*</small></label>
        <select class="form-control select2" id="anomaly" wire:model.lazy="anomaly">
            <option value="" selected>Select</option>
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
    <div class="mb-3 col-md-3">
        <label for="customer" class="form-label">Customer name</label>
        <input type="text" style="text-transform: uppercase" id="customer"
            class="form-control" wire:model.lazy="customer">
            @error('customer')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>                           

    <div class="mb-3 col-md-2">
        <label for="customer_contact" class="form-label">Contact<small class="text-danger">*</small></label>
        <input type="text" id="customer_contact" class="form-control" wire:model.defer="customer_contact">
        @error('customer_contact')
            <div class="text-danger text-small">{{ __($message) }}</div>
        @enderror
    </div>

    <div class="mb-3 col">
        <label for="meter_number" class="form-label">Meter No<small class="text-danger">*</small></label>
        <input type="text" id="meter_number" class="form-control"
            wire:model.defer="meter_number">
        @error('meter_number')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 col-md-3">
        <label for="other_name" class="form-label">Meter Type<small class="text-danger">*</small></label>
       <select name="meter_type_id" id="meter_type_id"  class="form-control" wire:model.lazy='meter_type_id'>
        <option value="">Select</option>
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

    <div class="mb-3 col-md-3">
        <label for="other_name" class="form-label">District<small class="text-danger">*</small></label>
       <select name="district_id" id="district_id"  class="form-control" wire:model.lazy='district_id'>
        <option value="">Select</option>
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
    <div class="mb-3 col-md-3">
        <label for="zone_id" class="form-label">Zone<small class="text-danger">*</small></label>
       <select name="zone_id" id="zone_id"  class="form-control" wire:model.lazy='zone_id'>
        <option value="">Select</option>
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
    <div class="mb-3 col-md-3">
        <label for="other_name" class="form-label">Feeder<small class="text-danger">*</small></label>
       <select name="feeder_id" id="feeder_id"  class="form-control" wire:model.lazy='feeder_id'>
        <option value="">Select</option>
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

    <div class="mb-3 col-md-3">
        <label for="business_type" class="form-label">Business Type<small class="text-danger">*</small></label>
        <input type="text" id="business_type" class="form-control" wire:model.lazy="business_type">
        @error('business_type')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-md-3">
        <label for="business_type" class="form-label">Location<small class="text-danger">*</small></label>
        <input type="text" id="location" class="form-control" wire:model.lazy="location">
        @error('location')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 col-md-3">
        <label for="supply_type" class="form-label">Supply<small class="text-danger">*</small></label>
        <select class="form-control select2" id="supply_type" wire:model.lazy="supply_type">
            <option selected value="">Select</option>
            <option value='On Supply'>On Supply</option>
            <option value='Off Supply'>Off Supply</option>
        </select>
        @error('supply_type')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3 col-3">
        <label for="clamp_on_reading" class="form-label">Camp On Reading<small class="text-danger">*</small></label>
        <input type="text" id="clamp_on_reading" name="clamp_on_reading" class="form-control" wire:model.lazy="clamp_on_reading">
        @error('clamp_on_reading')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
    </div>
    @if ($anomaly =='Faulty Meter' || $anomaly =='Tampered Meter' || $anomaly == 'Meter Ok')
        <div class="mb-3 col-4">
            <label for="ciu_reading" class="form-label">CIU Reading<small class="text-danger">*</small></label>
            <input type="text" id="ciu_reading" name="ciu_reading" class="form-control" required wire:model.lazy="ciu_reading">
            @error('ciu_reading')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-4">
            <label for="average_consamption" class="form-label">Average daily consamption<small class="text-danger">*</small></label>
            <input type="text" id="average_consamption" name="average_consamption" class="form-control" required wire:model.lazy="average_consamption">
            @error('average_consamption')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-4">
            <label for="total_consumption" class="form-label">Total consumption<small class="text-danger">*</small></label>
            <input type="text" id="total_consumption" name="total_consumption" class="form-control" required wire:model.lazy="total_consumption">
            @error('total_consumption')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3 col-md-4">
            <label for="test_interpretation" class="form-label">Trip Test<small class="text-danger">*</small></label>
            <select class="form-control select2" id="test_interpretation" required wire:model.lazy="test_interpretation">
                <option selected value="">Select</option>
                <option value='Passes'>Passed</option>
                <option value='Failed'>Failed</option>
            </select>
            @error('test_interpretation')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
    @endif
        @if ($anomaly =='Stolen Meter')
            <div class="mb-3 col-3">
                <label>Police Letter<small class="text-danger">*</small></label>
                <select name="police_letter" required class="form-control form-control" wire:model.differ='police_letter' id="police_letter">
                    <option value="">Select...</option>
                    <option selected value="1">Available</option>
                    <option value="0">Not Available</option>
                </select>
                    @error('police_letter')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
            </div>
            @if ($police_letter)
                <div class="mb-3 col-3">
                    <label for="police_letter_image" class="form-label">Police Photo<small class="text-danger">*</small></label>
                    <input type="file" id="police_letter_image" required class="form-control" wire:model="police_letter_image">
                    <div class="text-success text-small" wire:loading wire:target="police_letter_image">Uploading.....</div>
                    @error('police_letter_image')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @else
                <div class="mb-3 col-3">
                    <label for="police_letter_image"  class="form-label">Reason<small class="text-danger">*</small></label>
                    <input type="text" id="police_letter_image_{{$iteration}}" required class="form-control" wire:model="police_letter_image">
                    @error('police_letter_image')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>                
            @endif
          
            <div class="mb-3 col-3">
                <label for="box_image" class="form-label">Box Photo</label>
                <input type="file" id="box_image_{{$iteration}}" class="form-control" wire:model="box_image">
                <div class="text-success text-small" wire:loading wire:target="box_image">Uploading.....</div>
                @error('box_image')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-3">
                <label for="house_image" class="form-label">House Photo</label>
                <input type="file" id="house_image_{{$iteration}}" class="form-control" wire:model="house_image">
                <div class="text-success text-small" wire:loading wire:target="house_image">Uploading....</div>
                @error('house_image')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        @elseif($anomaly =='Meter Ok')
        <div class="mb-3 col-3">
            <label for="box_image" class="form-label">Box Photo</label>
            <input type="file" id="box_image_{{$iteration}}" class="form-control" wire:model="box_image">
            <div class="text-success text-small" wire:loading wire:target="box_image">Uploading.....</div>
            @error('box_image')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
        @else
            <div class="mb-3 col-md-2">
                <label for="anomaly_image" class="form-label">Anomaly Photo <small class="text-danger">*</small></label>
                <input type="file" id="anomaly_image_{{$iteration}}" class="form-control" required wire:model="anomaly_image">
                <div class="text-success text-small" wire:loading wire:target="anomaly_image">Uploading anomaly_image</div>
                @error('anomaly_image')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>     
            <div class="mb-3 col-md-2">
                <label for="form_image_" class="form-label">Form Photo <small class="text-danger">*</small></label>
                <input type="file" id="form_image_{{$iteration}}" class="form-control" required wire:model="form_image_">
                <div class="text-success text-small" wire:loading wire:target="form_image_">Uploading form_image_</div>
                @error('form_image_')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>           
        @endif
        @if($anomaly != 'Meter Ok')
            <div class="mb-3 col-md-4">
                <label for="action_taken" class="form-label">Action<small class="text-danger">*</small></label>
                <select class="form-control select2" id="action_taken" required wire:model.lazy="action_taken">
                    <option selected value="">Select</option>
                    <option value='Disconnected and Material Recovered'>Disconnected and Material Recovered</option>
                    <option value='Disconnected and Material left on site'>Disconnected and Material left on site</option>
                    @if ($anomaly !='Stolen Meter')
                        <option value='Disconnected Meter and Material Recovered'>Disconnected Meter and Material Recovered</option>
                        <option value='Disconnected Meter and Material Recovered left on site'>Disconnected Meter and Material Recovered left on site</option>
                    @endif
                    <option value="Left On supply">Left On supply</option>
                </select>
                @error('action_taken')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            @if($action_taken =='Left On supply')
                <div class="col-md-4">
                    <label for="">Reason Why left on supply <small class="text-danger">*</small></label>
                    <textarea name="reseon_left_on" id="reseon_left_on" required wire:model.differ='reseon_left_on' class="form-control"></textarea>
                </div>
                @error('reseon_left_on')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            @endif
        @endif
        <div class="col">
            <label for="">Comments<small class="text-danger">*</small></label>
            <textarea name="remarks" id="remarks" wire:model.differ='remarks' class="form-control"></textarea>
            @error('remarks')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

    {{-- =============================DYNAMIC FORM FIELDS======================= --}}

</div>
<div class="modal-footer">
    @if ($mode=='add')
        <x-button class="btn-sm btn-success">{{ __('Save') }}</x-button>
    @else
        <x-button class=" btn-sm btn-success">{{ __('Update') }}</x-button>
    @endif
    @if ($createNew)                      
     <button type="button" wire:click="cancel()" class="btn btn-sm btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
    @endif
</div>
<hr>
</form>