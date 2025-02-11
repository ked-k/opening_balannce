<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">@yield('title')</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">@yield('title')</a></li>
            <li class="breadcrumb-item active"><a type="button" class="btn mr-2 btn-sm btn-outline-success me-2" wire:click="refresh()"><i class="fa fa-refresh"></i></a></li>
            <li> <a class="btn btn-sm @if (!$createNew) btn-success @else btn-outline-danger @endif " data-toggle="modal" data-target="#addnew"
                wire:click="$set('createNew',{{ !$createNew }})"
                data-toggle="modal" data-target="#addnew" ><i class="fa fa-plus"></i>{{__('New')}}</a></li>
        </ol>
    </div>  
    <div>
        <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
    </div>
</div>
