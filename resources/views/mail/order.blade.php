@if($data['type']=='user')
    <h2>Welcome to ridejolt.co.uk</h2>
    <p>You have successfully subscribed to our package. You will get the delivery of your bike
        on {{$data['rec']->payment_date}} and your card will be charged for the subscription.Your subscription will
        start from date and will be valid till
        end {{\Carbon\Carbon::createFromFormat('Y-m-d',$data['rec']->payment_date)->addMonth($data['rec']->getDetailpack()['months'])->format('Y-m-d')}}
        .</p>

@endif

@if($data['type']=='admin')
    <p>You have got the new request for the delivery of bike on {{$data['rec']->payment_date}}.The customer has
        subscribed to {{$data['rec']->getDetailpack()['name']}} plan.</p>
@endif
