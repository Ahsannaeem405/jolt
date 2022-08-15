@extends('layout.main')

@section('content')




    <form action="{{url('checkout')}}" method="post">
        @csrf

    <div class="row my-5">

        <div class="col-md-6">

            <h3 class="mb-4">Your reservation</h3>
            <img class="w-100"
                 src="https://cdn.shopify.com/s/files/1/0654/0958/1314/products/JOLT_Frontal2.png?v=1659693413&width=600"
                 alt="">
            <h3>JOLT BRUTE</h3>

            <h6>The real EYE-TURNER of electric bikes!</h6>
            <span>plan: {{$data['name']}}</span>
        </div>
        <div class="col-md-6 p-5">


            <div class="card">
                <div class="card-body">
                    <h6>Reservation summary</h6>

                    <div class="d-flex justify-content-between mt-2">
                        <p class="font-weight-bold">Price</p>
                        <p class="font-weight-bold">£{{$data['total']}}</p>

                    </div>
                    <hr>

                    <div class="d-flex justify-content-between">
                        <p class="font-weight-bold">Total</p>
                        <p class="font-weight-bold">£{{$data['total']}}</p>

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
