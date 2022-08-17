@if($data['type']=='user')
    <h2>Hello there,</h2>
    You have successfully deactivated your {{$data['rec']->getDetailpack()['name']}} Subscription with us. We hope you enjoyed our service. If you have any feedback don't hesitate to contact us.
@endif

@if($data['type']=='admin')
    Hello Admin,
    This e-mail is to inform you that the user {{$data['rec']->first_name.' '.$data['rec']->last_name}} has just deactivated the subscription plan.
@endif

