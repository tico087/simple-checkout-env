<table class="table datatable p-3" style="background: white; border-radius:10px;">
    <thead>
        <tr>
            <th>{{__('POS ID')}}</th>
            <th>{{ __('Date') }}</th>
       
            <th>{{ __('Sub Total') }}</th>
            <th>{{ __('Discount') }}</th>
            <th>{{ __('Total') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($posPayments as $posPayment)
            <tr>
                <td class="Id">
                    <a href="{{ route('pos.show', \Crypt::encrypt($posPayment->id)) }}" class="btn btn-outline-primary">
                        {{ Auth::user()->posNumberFormat($posPayment->id) }}
                    </a>
                </td>
                <td>{{ Auth::user()->dateFormat($posPayment->created_at) }}</td>
               
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->amount) : 0 }}</td>
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount) : 0 }}</td>
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount_amount) : 0 }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
            </tr>
        @endforelse
    </tbody>
</table>
