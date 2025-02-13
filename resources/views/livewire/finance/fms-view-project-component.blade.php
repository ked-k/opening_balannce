<div>
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
                                @foreach ($transaction_types as $type)
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
                <div class="card-body">
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
                                                <td> {{ $transaction->trx_no }}</td>
                                                <td>{{ $transaction->trx_ref }}</td>
                                                <td> <small>{{ $transaction->trx_date }}</small></td>
                                                <td>
                                                    <small
                                                        class="mb-0 text-muted">{{ Str::words($transaction->description, 5, '.') }}<a
                                                            href="javascript:void(0)"
                                                            wire:click='viewVoucher({{ $transaction->id }})'
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewTransactionModal">...viewmore
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
            </div><!--end card-->
            {{-- @include('livewire.finance.ledger.inc.viewTransaction') --}}
            {{-- @include('livewire.finance.ledger.inc.repostransaction') --}}
        </div><!--end col-->
    </div><!--end row-->
</div>
