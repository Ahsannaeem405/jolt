@if($data['type']=='user')
    We have successfully received your payment. Your subscription period starts now. We are hoping you will enjoy it.

@endif

@if($data['type']=='admin')
    You have received a new payment of £{{$data['rec']->getDetailpack()['price']}} from {{$data['rec']->first_name.' '.$data['rec']->last_name}}. His delivery date is due today. He had chosen {{$data['rec']->getDetailpack()['name']}} plan.

@endif
