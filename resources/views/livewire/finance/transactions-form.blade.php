<form wire:submit.prevent="storeTransaction">
    @include('layouts.messages')
    <div class="modal-body">
        <div class="row">

            <div class="mb-3 col-3">
                <label for="is_supplier" class="form-label">Transaction Type</label>
                <select id="is_supplier" class="form-control" name="trx_type" required wire:model="trx_type">
                    <option value="">Select</option>
                    <option value="Expense">Expense</option>
                    <option value="Income">Income</option>
                </select>
                @error('trx_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-3">
                <label for="project_id" class="form-label required">Project</label>
                <select id="project_id" class="form-control" name="project_id" required wire:model="project_id">
                    <option value="">Select</option>
                    @foreach ($projects as $ledger)
                        <option value="{{ $ledger->id }}">{{ $ledger->project_code }}</option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-3">
                <label for="expense_type_id" class="form-label">{{ $trx_type }} Type</label>
                <select id="expense_type_id" class="form-control" name="expense_type_id"
                    @if ($project_id != 0) required @endif wire:model="expense_type_id">
                    <option value="">Select</option>
                    @foreach ($expenseTypes as $expenseType)
                        <option value="{{ $expenseType->id }}">{{ $expenseType->name }}</option>
                    @endforeach
                </select>
                @error('expense_type_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-3">
                <label for="coa_id" class="form-label required">Trx Ref.</label>
                <input type="text" name="trx_ref" id="" class="form-control" required
                    wire:model.defer="trx_ref">
                @error('trx_ref')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label required">{{ __('Currency') }}</label>
                <select class="form-control" id="currency_id" wire:model.lazy="currency_id">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-7">
                <label for="total_amount" class="form-label required">Amount</label>
                <div class="input-group">
                    <input type="text" id="total_amount" oninput="formatAmount(this)" class="form-control"
                        name="total_amount" required wire:model="total_amount">
                    <span class="input-group-text">@ {{ $rate }}</span>
                    <input id="amount_local" readonly class="form-control" name="amount_local" required
                        wire:model="amount_local" step="any" type="number">
                </div>
                @error('total_amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-3">
                <label for="trx_date" class="form-label required">Trx Date</label>
                <div class="input-group">
                    <input type="date" id="trx_date" class="form-control" name="trx_date" required
                        wire:model="trx_date">
                </div>
                @error('trx_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-5">
                <label for="trx_date" class="form-label required">Client</label>
                <div class="input-group">
                    <textarea type="text" id="client" class="form-control" name="client" required wire:model="client"></textarea>
                </div>
                @error('client')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-7">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" class="form-control" name="description" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a wire:click='close()' data-dismiss="modal" aria-hidden="true"
            class="btn btn-danger mr-1">{{ __('Close') }}</a>
        <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
    </div>
</form>
