@if($data['type']=='user')
    <h2>Hello there,</h2>
    You have successfully reactivated your {{$data['rec']->getDetailpack()['name']}} Subscription. We hope you will enjoy our services. If you have any feedback don't hesitate to contact us.

@endif

@if($data['type']=='admin')
    <h2>Hello Admin,</h2>
    This e-mail is to inform you that the user {{$data['rec']->first_name.' '.$data['rec']->last_name}} has just reactivated the subscription plan {{$data['rec']->getDetailpack()['name']}}.
@endif
