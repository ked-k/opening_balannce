<div>
    @include('livewire.layouts.partials.inc.create-resource')

    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="card">
                <div class="card-body invoice-head">
                    <div class="row">
                        <div class="col-md-12 d-print-flex">
                            {{-- @include('livewire.partials.brc-header') --}}
                        </div>
                        <div class="col-md-12">
                            <h5>Account Name: {{ $ledger_account->name }} as of @if ($from_date && $to_date)
                                    {{ $from_date . ' -' . $to_date }}
                                @else
                                    {{ date('D-M-Y') }}
                                @endif
                            </h5>

                        </div>
                    </div>

                    <div class="row d-print-none">
                        <div class="mb-3 col-md-3">
                            <label for="from_date" class="form-label">Transaction</label>
                            <select class="form-control" name="transaction_type" id="transaction_type"
                                wire:model='transaction_type'>
                                <option value="0">All</option>
                                @foreach ($expenseTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label for="from_date" class="form-label">From Date</label>
                            <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                        </div>

                        <div class="mb-3 col-md-2">
                            <label for="to_date" class="form-label">To Date</label>
                            <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                        </div>
                        <div class="mt-4 col-md-2 mt-2">
                            <button class="btn btn-outline-success btn-sm"
                                wire:click="exportToExcel">{{ __('Export') }}</button>
                            <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                        </div>
                    </div><!--end row-->
                    @php
                        $income = $transactions->where('trx_type', 'Income')->sum('amount_local');
                        $expense = $transactions->where('trx_type', 'Expense')->sum('amount_local');
                    @endphp
                </div><!--end card-body-->
                <div wire:loading>
                    <div class="spinner-border spinner-border-custom-3 border-success" role="status"></div>
                    <div class="loader">Loading...</div>
                </div>
                <div class="card-header">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"
                                aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down">Home</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"
                                aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                    class="hidden-xs-down">Merp Transactions</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="modal" data-target="#addnew"
                                href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i
                                        class="ti-user"></i></span> <span class="hidden-xs-down">New
                                    Transaction</span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="modal" data-target="#importModal"
                                href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i
                                        class="ti-user"></i></span> <span class="hidden-xs-down">Import
                                    Transaction</span></a> </li>
                    </ul>
                    </ul>
                </div>
                <div class="tab-content tabcontent-border">
                    <div class="card-body tab-pane active" id="home" role="tabpanel">
                        <table class="table table-bordered mb-0 table-sm">
                            <thead class="thead-light">
                                <tr class="text-end">
                                    <th>TOTAL INCOME</th>
                                    <th>TOTAL EXPENSES</th>
                                    <th>CURRENT BALANCE</th>
                                    <th>MERP VALUE</th>
                                    <th>MERP VALUE + LEDGER BALANCE</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border-0 font-14 text-dark text-end">@money_format($income)</td>
                                    <td class="border-0 font-14 text-dark text-end">@money_format($expense)</td>
                                    @php
                                        $ledgerBalance = $income - $expense;
                                    @endphp
                                    <td class="border-0 font-14 text-dark text-end">@money_format($ledgerBalance)</td>
                                    <td class="border-0 font-14 text-dark text-end">@money_format($merpBalance)</td>
                                    <td class="border-0 font-14 text-dark text-end">@money_format($ledgerBalance + $merpBalance)</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive project-invoice">
                                    <table class="table table-bordered mb-0 table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>TRX No.</th>
                                                <th>Reference</th>
                                                <th>Date</th>
                                                <th>Memo</th>
                                                <th>Debit</th>
                                                <th>Credit</th>
                                                <th>Balance</th>
                                            </tr><!--end tr-->
                                        </thead>
                                        <tbody>
                                            @php
                                                $balance = $previous_balance; // Start with the previous balance if date ranges are applied
                                            @endphp

                                            @if ($from_date && $to_date)
                                                <!-- Check if date range is applied -->
                                                <tr>
                                                    <td colspan="6" class="text-end"><strong>Previous Balance Carried
                                                            Forward:</strong></td>
                                                    <td class="text-end">@money_format($balance)</td>
                                                </tr>
                                            @endif

                                            @foreach ($transactions as $transaction)
                                                @php
                                                    // Adjust balance based on transaction type
                                                    if ($transaction->trx_type == 'Income') {
                                                        $balance += $transaction->amount_local;
                                                    } elseif ($transaction->trx_type == 'Expense') {
                                                        $balance -= $transaction->amount_local;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td> {{ $transaction->trx_no }}
                                                        <div class="d-flex justify-content-between">

                                                            @if (!$transaction->verified)
                                                                <a class="text-danger m-1"
                                                                    wire:click="$set('delete_id','{{ $transaction->id }}')"
                                                                    title="{{ __('delete Transaction') }}">
                                                                    <i class="fa fa-trash fs-18"></i></a>
                                                                <a class="text-success m-1"
                                                                    wire:click="markAsVerified({{ $transaction->id }},1)"
                                                                    title="{{ __('Verify Transaction') }}">
                                                                    <i class="fa fa-handshake-o fs-18"></i></a>
                                                            @else
                                                                <a class="text-info m-1"
                                                                    wire:click="markAsVerified({{ $transaction->id }},0)"
                                                                    title="{{ __('Un verify Transaction') }}">
                                                                    <i class="fa fa-ban fs-18"></i></a>
                                                            @endif
                                                        </div>
                                                        @if ($transaction->id == $delete_id)
                                                            <a class="text-warning m-1"
                                                                wire:click="deleteTransaction({{ $transaction->id }})"
                                                                title="{{ __('confirm delete transaction') }}">
                                                                <i class="fa fa-check fs-18"></i></a>
                                                            <a class="text-info m-1"
                                                                wire:click="$set('delete_id','')">
                                                                <i class="fa fa-close fs-18"></i></a>
                                                        @endif

                                                    </td>
                                                    <td>{{ $transaction->trx_ref }}</td>
                                                    <td> <small>{{ $transaction->trx_date }}</small></td>
                                                    <td>
                                                        <small
                                                            class="mb-0 text-muted">{{ Str::words($transaction->description, 5, '.') }}<a
                                                                href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#addnew"
                                                                wire:click="editData({{ $transaction->id }})">...viewmore
                                                            </a></small>
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($transaction->trx_type == 'Income')
                                                            @money_format($transaction->amount_local ?? 0) <br>
                                                            <small class="text-info">@money_format($transaction->total_amount ?? 0) <span
                                                                    class="text-warning">({{ $transaction->rate ?? 0 }})</span></small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">
                                                        @if ($transaction->trx_type == 'Expense')
                                                            @money_format($transaction->amount_local ?? 0) <br>
                                                            <small class="text-info">@money_format($transaction->total_amount ?? 0) <span
                                                                    class="text-warning">({{ $transaction->rate ?? 0 }})</span></small>
                                                        @endif
                                                    </td>
                                                    <td class="text-end">@money_format($balance ?? 0)</td>
                                                </tr><!--end tr-->
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="border-0">

                                                </td>
                                                <td class="border-0 font-14 text-dark"><b>
                                                        Total</b>(UGX)</td>
                                                <td class="border-0 font-14 text-dark text-end">@money_format($income)</td>
                                                <td class="border-0 font-14 text-dark text-end">@money_format($expense)</td>
                                                <td class="border-0 font-14 text-dark text-end">@money_format($income - $expense)</td>
                                            </tr><!--end tr-->

                                        </tbody>
                                    </table><!--end table-->
                                </div> <!--end /div-->
                            </div> <!--end col-->
                        </div><!--end row-->

                        <hr>
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-12 col-xl-4 ms-auto align-self-center">
                                <div class="text-center"><small class="font-12">This Document was electronically
                                        generated.</small></div>
                            </div><!--end col-->
                            <div class="col-lg-12 col-xl-4">
                                <div class="float-end d-print-none mt-2 mt-md-0">
                                    <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>

                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body-->
                    <div class="card-body tab-pane p-20" id="profile" role="tabpanel">
                        <div>
                            <h2 class="mb-4">Merp Transactions</h2>

                            @if (empty($merpTransactions))
                                <div class="alert alert-warning">No transactions found.</div>
                            @else
                                <div class="table-responsive project-invoice">
                                    <table class="table table-bordered mb-0 table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Date</th>
                                                <th>TRX No</th>
                                                <th>Reference</th>
                                                <th>Description</th>
                                                <th>Client</th>
                                                <th>Income</th>
                                                <th>Expense</th>
                                                <th>Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $runningBalance = 0;
                                            @endphp

                                            @foreach ($merpTransactions as $trx)
                                                @php
                                                    // Determine debit and credit amounts
                                                    $debit = $trx['trx_type'] == 'Income' ? $trx['amount_local'] : 0;
                                                    $credit = $trx['trx_type'] == 'Expense' ? $trx['amount_local'] : 0;

                                                    // Update running balance
                                                    $runningBalance = $runningBalance + $debit - $credit;
                                                @endphp

                                                <tr>
                                                    <td>{{ $trx['trx_date'] }}
                                                        @if (!$transaction->verified)
                                                            <a class="text-success m-1"
                                                                wire:click="markAsVerified({{ $trx['id'] }},1)"
                                                                title="{{ __('Verify Transaction') }}">
                                                                <i class="fa fa-handshake-o fs-18"></i></a>
                                                        @else
                                                            <a class="text-info m-1"
                                                                wire:click="markAsVerified({{ $trx['id'] }},0)"
                                                                title="{{ __('Un verify Transaction') }}">
                                                                <i class="fa fa-ban fs-18"></i></a>
                                                        @endif
                                                    </td>
                                                    <td>{{ $trx['trx_no'] }}</td>
                                                    <td>{{ $trx['trx_ref'] }}</td>
                                                    <td> <small>{{ $trx['description'] }}</small></td>
                                                    <td><small>{{ $trx['client'] }}</small></td>
                                                    <td>
                                                        @if ($trx['trx_type'] == 'Income')
                                                            {{ $debit > 0 ? number_format($debit, 2) : '' }}
                                                            <small class="text-info">@money_format($trx['total_amount'] ?? 0) <span
                                                                    class="text-warning">({{ $trx['rate'] ?? 0 }})</span></small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($trx['trx_type'] == 'Expense')
                                                            {{ $credit > 0 ? number_format($credit, 2) : '' }}
                                                            <small class="text-info">@money_format($trx['total_amount'] ?? 0) <span
                                                                    class="text-warning">({{ $trx['rate'] ?? 0 }})</span></small>
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($runningBalance, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div><!--end card-->
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
        <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Choose a file</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                    </div>
                    <form wire:submit.prevent="importData">
                        <div class="modal-body">
                            @include('layouts.messages')
                            <div class="mb-3">
                                <label for="entry_type" class="form-label required">Item File</label>
                                <input type="file" wire:model.lazy="import_file" class="form-control" required
                                    name="import_file" id="import_file_{{ $iteration }}">
                                <div class="text-success text-small" wire:loading wire:target="import_file">Uploading
                                    file...</div>
                                @error('import_file')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                data-dismiss="modal">{{ __('close') }}</button>
                            <button type="submit" class="btn btn-success">{{ __('upload') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- @include('livewire.finance.ledger.inc.viewTransaction') --}}
        {{-- @include('livewire.finance.ledger.inc.repostransaction') --}}
    </div><!--end col-->
</div><!--end row-->
</div>
