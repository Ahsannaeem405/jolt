@extends('layout.main')

@section('content')



    <form action="{{url('detail')}}" method="post" id="formvalidate">
        @csrf


        <div class="card mt-5">

            <div class="card-body">
                <h3>Your details</h3>
                <div class="row my-5">
                    <div class="col-md-6 my-3">
                        <lable>First Name</lable>
                        <input type="text" name="f_name" required class="form-control" placeholder="First name">
                    </div>
                    <div class="col-md-6 my-3">
                        <lable>Last Name</lable>
                        <input type="text" name="l_name" required class="form-control" placeholder="Last name">
                    </div>

                    <div class="col-md-6 my-3">
                        <lable>Email address</lable>
                        <input type="email" name="email" required class="form-control" placeholder="Email address">
                    </div>

                    <div class="col-md-6 my-3">
                        <lable>Mobile number</lable>
                        <input type="number" name="number" required class="form-control" placeholder="Mobile number">
                    </div>

                    <div class="col-md-12 my-3">
                        <lable>Address</lable>
                        <input type="text"  name="address" required class="form-control" placeholder="Address">
                    </div>

                    <div class="col-md-12 my-3 d-flex justify-content-end">
                        <input type="checkbox" class="mr-2" required name="term">
                        <p class="m-0">I agree to the Terms & conditions </p>
                    </div>
                </div>

            </div>

            <div class="col-12 text-right">
                <button class="btn btn-dark my-4" type="submit">Continue to pick up detail</button>
            </div>
        </div>









@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('.subscription').click(function () {

                $('#package').val($(this).attr('pack'));

                $('.subscription').removeClass('active');
                $(this).addClass('active');

            });
            $('.addone').click(function () {



                if($(this).hasClass('active')){

                    $('.addone').removeClass('active');
                    $('#addone').val(0);

                }
                else {
                    $('.addone').removeClass('active');
                    $(this).addClass('active');
                    $('#addone').val(1);
                }



            });
        });
    </script>
@endsection
