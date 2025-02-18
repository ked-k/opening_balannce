   <div class="tab-content tabcontent-border">
       <div class="card-body tab-pane active" id="home" role="tabpanel">
           <h2 class="mb-4">Combined Transactions</h2>

           @if (empty($combinedTransactions))
               <div class="alert alert-warning">No transactions found.</div>
           @else
               <div class="table-responsive project-invoice">
                   <table class="table table-bordered mb-0 table-sm" style="font-size: 14px">
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
                               <th>Actual</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $mrunningBalance = 0;
                               $mincomes = 0;
                               $mexpenses = 0;
                           @endphp

                           @foreach ($combinedTransactions as $mtrx)
                               @php
                                   // Determine debit and credit amounts
                                   $mdebit = $mtrx['trx_type'] == 'Income' ? $mtrx['amount_local'] : 0;
                                   $mcredit = $mtrx['trx_type'] == 'Expense' ? $mtrx['amount_local'] : 0;

                                   // Update running balance
                                   $mrunningBalance = $mrunningBalance + $mdebit - $mcredit;
                                   $mincomes = $mdebit + $mincomes;
                                   $mexpenses = $mcredit + $mexpenses;
                               @endphp

                               <tr>
                                   <td>{{ $mtrx['trx_date'] }}</td>
                                   <td><small>{{ $mtrx['trx_no'] }}</small></td>
                                   <td><small>{{ $mtrx['trx_ref'] }}</small></td>
                                   <td> <small>{{ $mtrx['description'] }}</small></td>
                                   <td><small>{{ $mtrx['client'] }}</small></td>
                                   <td>
                                       @if ($mtrx['trx_type'] == 'Income')
                                           {{ $mdebit > 0 ? number_format($mdebit, 2) : '' }}
                                       @endif
                                   </td>
                                   <td>
                                       @if ($mtrx['trx_type'] == 'Expense')
                                           {{ $mcredit > 0 ? number_format($mcredit, 2) : '' }}
                                       @endif
                                   </td>
                                   <td>{{ number_format($mrunningBalance, 2) }}</td>
                                   <td>
                                       {{ $mtrx['total_amount'] }}
                                   </td>
                               </tr>
                           @endforeach
                           <tr>
                               <td class="" colspan="5">Total</td>
                               <td>{{ number_format($mincomes, 2) }}</td>
                               <td>{{ number_format($mexpenses, 2) }}</td>
                               <td>{{ number_format($mincomes - $mexpenses, 2) }}</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
           @endif
       </div>
   </div>
