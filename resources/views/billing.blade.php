@extends('layout.main')

@section('content')

    <form action="{{url('billing')}}" id="formvalidate" method="post">
        @csrf



        <div class="card mt-5 ">

            <div class="card-body">
                @include('layout.back')
                <h3>Billing</h3>

                <div class="col-12 my-3">
                    <lable>First Name</lable>
                    <input type="text" name="first_name" required  class="form-control" value="" >
                </div>
                <div class="col-12 my-3">
                    <lable>Last Name</lable>
                    <input type="text" name="last_name"  required class="form-control" value="" >
                </div>

                <div class="col-12 my-3">
                    <lable>Phone</lable>
                    <input type="number" name="phone_number"  required class="form-control" value="" >
                </div>

                @if(!$user)
                    <div class="col-12 my-3">
                        <lable>Password</lable>
                        <input type="password" name="password"  required class="form-control" value="" >
                    </div>
                @endif


                <div class="col-12 d-flex p-0">
                    <div class="col-8 my-3">
                        <lable>Street address</lable>
                        <input type="text" name="street_address"  required class="form-control" value="" >
                    </div>
                    <div class="col-4 my-3">
                        <lable>Apt/Suite</lable>
                        <input type="text" name="apt"   class="form-control" value="" >
                    </div>
                </div>

                <div class="col-12 my-3">
                    <lable>City</lable>
                    <input type="text" name="city"  readonly required class="form-control" value="London" >
                </div>

                <div class="col-12 my-3">
                    <lable>Country</lable>
                    <input type="text" name="country"  readonly required class="form-control" value="United Kingdom" >
                </div>

                <div class="col-12 d-flex p-0">
                    <div class="col-10 my-3">
                        <lable>Province/State</lable>
                        <input type="text" name="province"  required class="form-control" value="" >
                    </div>
                    <div class="col-2 my-3">
                        <lable>Postal/ZIP code</lable>
                        <input type="text" name="code" required   class="form-control" value="" >
                    </div>
                </div>



                <div class="col-12 text-right">
                    <button class="btn btn-dark my-4" type="submit">Continue to Payment</button>
                </div>


            </div>
        </div>

@endsection

@section('js')

@endsection
