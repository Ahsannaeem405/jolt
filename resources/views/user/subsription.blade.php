@extends('layout.main')
@section('content')
    <style>
        .plans {
            border: 1px #cccaca solid;
            border-radius: 10px;
            padding: 20px;
            height: auto;

        }

        .active {
            border: 2px solid black;
        }
    </style>
    <div class="row my-5 ">

        @foreach($subscriptions as $subscription)

            <div class="col-lg-4 my-3  m-auto" style="margin-bottom: 20px!important;">
                <div class="col-12 plans subscription" pack="3">
                    <p>Plan: {{$subscription->getDetailpack()['name']}}</p>
                    <p>Status: @if($subscription->stop==1)
                                   <span class="text-danger">DEACTIVATE</span>
                        @else
                            <span class="text-success">ACTIVATE</span>
                        @endif
                    </p>
                    <p>
                        Payment date: {{$subscription->payment_date}}
                    </p>
                    <p>
                        @if($subscription->status==0)
                            <span class="text-danger">Something weng wrong with your payment please <a href="{{url('paynow/'.encrypt($subscription->id))}}">click here</a> to pay now. </span>
                            @endif
                    </p>

                    <p class="text-center">
                        @if($subscription->stop==1)
                            <a href="{{url('subscription/'.encrypt('0').'/'.encrypt($subscription->id))}}">  <button class="btn btn-success">Activate</button></a>
                        @else
                            <a href="{{url('subscription/'.encrypt('1').'/'.encrypt($subscription->id))}}"><button class="btn btn-danger">Deactivate</button></a>
                        @endif
                    </p>




                </div>
            </div>
        @endforeach
    </div>



@endsection

@section('js')

@endsection
