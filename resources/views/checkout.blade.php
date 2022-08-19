@extends('layout.main')

@section('content')

    <form action="{{url('checkout')}}" method="post">
        @csrf

        <div class="row my-5">

            <div class="col-md-6">
                @include('layout.back')
                <h3 class="mb-4">Your reservation</h3>
                <img class="w-100"
                     src="https://cdn.shopify.com/s/files/1/0654/0958/1314/products/JOLT_Frontal2.png?v=1659693413&width=600"
                     alt="">
                <h3 class="mt-3">JOLT BRUTE</h3>

                <h6>The real EYE-TURNER of electric bikes!</h6>
                <span>plan: {{$data['name']}}</span>
            </div>
            <div class="col-md-6 p-5">


                <div class="card">
                    <div class="card-body">
                        <h6>Reservation summary</h6>

                        <div class="d-flex justify-content-between mt-4 ">
                            <p class="font-weight-bold">JOLT COMMUTE</p>
                            <span class="font-weight-bold">x1</span>
                            <p> £{{$data['price']}}</p>

                        </div>
                        @if($data['addone']!=0)
                            <div class="d-flex justify-content-between mt-4 ">
                                <p class="font-weight-bold">Theft Replacement </p>
                                <span class="font-weight-bold">x1</span>
                                <p> £{{$data['addone']}}</p>


                            </div>
                        @endif

                            @if($data['record']->accesories)
                                @foreach($data['record']->accesories as $acc)

                                    <div class="d-flex justify-content-between mt-4 ">
                                        <p class="font-weight-bold">{{accesories($acc)['name']}}</p>
                                        <span class="font-weight-bold">x1</span>
                                        <p> £{{accesories($acc)['price']}}</p>


                                    </div>
                                @endforeach


                        @endif
                        <hr>

                        <div class="d-flex justify-content-between">
                            <p class="font-weight-bold">Total</p>
                            <p class="font-weight-bold"> £{{$data['price'] + $data['addone'] + accesories_total($data['record']->accesories)}}</p>

                        </div>
                    </div>

                </div>


            </div>


        </div>

        <div class="col-12 text-right">
            <button class="btn btn-dark my-4" type="submit">Continue to your details</button>
        </div>
    </form>

@endsection

@section('js')

@endsection
