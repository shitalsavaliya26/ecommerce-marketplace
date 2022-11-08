 <div class="col-12 mt-2  table-responsive" id="deposithistory">
    <table class="table history-table">
        <thead>
            <tr>
                <th scope="col">{{trans('label.amount')}}</th> 
                <th scope="col">{{trans('label.date')}}</th>
                <th scope="col">{{trans('label.type')}}</th>
            </tr>
        </thead>
        <tbody>
            @if(count($transactionhistory) > 0)
            @foreach($transactionhistory as $transaction)
            <tr>
                <td>RM {{ number_format($transaction->amount,2) }}</td>
                <td>{{ date('d/m/Y h:i:s',strtotime($transaction->created_at)) }}</td>                                                        
                <td>
                    @if($transaction->transaction_for == 'payment')
                    <span class="m-badge m-badge--warning m-badge--wide">{{trans('label.order_place')}}</span>
                    @else
                    <span class="m-badge m-badge--success m-badge--wide">{{trans('label.deposit')}}</span>
                    @endif

                                                            <!-- @if($transaction->status == 'pending')
                                                                <span class="m-badge m-badge--brand m-badge--wide">{{trans('label.pending')}}</span>
                                                            @elseif($transaction->status == 'accept')
                                                                <span class="m-badge m-badge--success m-badge--wide">{{trans('label.accepted')}}</span>
                                                            @elseif($transaction->status == 'reject')
                                                                <span class="m-badge m-badge--danger m-badge--wide">{{trans('label.rejected')}}</span>
                                                                @endif -->
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="7">
                                                                {{trans('label.no_withdraw_history_found')}}.
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                @if(count($transactionhistory) > 0)
                                                <div class="col-12">
                                                    {{ $transactionhistory->render('vendor.default_paginate') }}
                                                </div>
                                                @endif
                                            </div>