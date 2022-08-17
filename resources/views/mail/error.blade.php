@if($data['type']=='user')
  <h2>Hello there,</h2>
    We were unable to charge your card for the {{$data['rec']->getDetailpack()['name']}} Subscription. You have the option to change your card or retry.
@endif

@if($data['type']=='admin')
    <h2>Hello Admin,</h2>
    This e-mail is to inform you that the payment from the user {{$data['rec']->first_name.' '.$data['rec']->last_name}} was not successful. He will need to change his card or retry.
@endif
