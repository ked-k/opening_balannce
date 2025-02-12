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
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Unit</th>
                                        <th>Trx No.</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Currency</th>
                                        <th>Amount</th>
                                        <th>Amount (UGX)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transaction->requestable->project_code ?? '' }}</td>
                                            <td>{{ $transaction->trx_ref ?? '' }}</td>
                                            <td>{{ $transaction->trx_date ?? 'N/A' }}</td>
                                            <td>{{ $transaction->trx_type }}</td>
                                            <td>{{ $transaction->currency->code ?? 'UGX' }}</td>
                                            <td>@money_format($transaction->total_amount)</td>
                                            <td>@money_format($transaction->total_amount * $transaction->rate)</td>
                                            <td class="table-action">
                                                <div class="d-flex justify-content-between">
                                                    <a href="{{ URL('finance-main_transaction_view', $transaction->id) }}"
                                                        class="btn btn-sm btn-outline-secondary m-1">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-outline-success m-1"
                                                        data-toggle="modal" data-target="#addnew"
                                                        wire:click="editData({{ $transaction->id }})"
                                                        title="{{ __('public.edit') }}">
                                                        <i class="fa fa-edit fs-18"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger m-1"
                                                        wire:click="$set('delete_id','{{ $transaction->id }}')"
                                                        title="{{ __('public.delete Transaction') }}">
                                                        <i class="fa fa-trash fs-18"></i></button>
                                                </div>
                                                @if ($transaction->id == $delete_id)
                                                    <a class="text-warning m-1"
                                                        wire:click="deleteTransaction({{ $transaction->id }})"
                                                        title="{{ __('public.delete transaction') }}">
                                                        <i class="fa fa-check fs-18"></i></a>
                                                    <a class="text-info m-1" wire:click="$set('delete_id','')">
                                                        <i class="fa fa-close fs-18"></i></a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div>
                </div>
            </div>
        </div>
        <div wire:ignore.self class="modal fade" id="addnew" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('New Transaction') }}</h5>
                        <button type="button" class="close" wire:click="close()" data-dismiss="modal"
                            aria-hidden="true">×</button>
                    </div>
                    @include('livewire.finance.transactions-form')
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
