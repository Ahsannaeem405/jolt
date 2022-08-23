@extends('layout.main')

@section('content')



<form action="{{url('detail')}}" method="post" id="formvalidate">
    @csrf


    <div class="card mt-5">

        <div class="card-body">
            @include('layout.back')
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
                <div class="row  d-flex">
                    <div class="col-md-8">
                    <input type="email" id="email" name="email" required class="form-control" placeholder="Email address">
                    </div>
                    <div class="col-md-4 ">
                    <button type="button" id="otp_btn" class="btn btn-dark ">Send otp</button>
                    </div>
                    </div>
                </div>
                <div class="col-md-6 my-3">
                    <lable>Verification code</lable>
                    <input type="number" name="verification_code" required class="form-control" placeholder="Verification code">
                </div>

                <div class="col-md-6 my-3">
                    <lable>Mobile number</lable>
                    <input type="number" name="number" required class="form-control" placeholder="Mobile number">
                </div>

                <div class="col-md-12 my-3">
                    <lable>Address</lable>
                    <input id="placeInput" type="text" name="address" required class="form-control" placeholder="Address">
                </div>

                <div class="col-md-12 my-3 d-flex justify-content-end">
                    <input type="checkbox" class="mr-2" required name="term">
                    <p class="m-0">I agree to the Terms & conditions </p>
                </div>
            </div>

        </div>

        <div class="col-12 text-right">
            <button id="submit_btn" class="btn btn-dark my-4 " type="submit" disabled>Continue to pick up detail</button>
        </div>
    </div>




    @endsection

    @section('js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8LG6Js3S4yieiAfNJbIk3IW0S-aNDTOw&libraries=places&callback=initAutocomplete" async></script>
    <script>

        //auto complete api//
        let autocomplete;
/* ------------------------- Initialize Autocomplete ------------------------ */
function initAutocomplete() {
    const input = document.getElementById("placeInput");
    const options = {
        componentRestrictions: { country: "US" }
    }
    autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.addListener("place_changed", onPlaceChange)
}

/* --------------------------- Handle Place Change -------------------------- */
function onPlaceChange() {
    const place = autocomplete.getPlace();
    console.log(place.formatted_address)
    console.log(place.geometry.location.lat())
    console.log(place.geometry.location.lng())
}

        $(document).ready(function() {

            $("#otp_btn").click(function(e) {
                e.preventDefault();
                var email = $("#email").val();
                var test =   $.ajax({
                
                    type: "POST",
                    url: "sentotp",
                    data:{"email":email},

                    beforeSend: function() {
if (email == ""){
    swal("Error!", "Email field is Empty", "error");
         return false
}          
          $("#otp_btn").attr("disabled", true);
          
    },
                    success: function(result) {
                        swal("Done!", "OTP Send Successfully", "success");
                        console.log(email);
                    },

                    error: function(result) {
                        swal("Error!", "Failed to Send OTP", "error");
                    },
                    complete: function() {
                        $("#otp_btn").attr("disabled", false);
                        $("#submit_btn").attr("disabled", false);
    },
                });
            });

            $('.subscription').click(function() {

                $('#package').val($(this).attr('pack'));

                $('.subscription').removeClass('active');
                $(this).addClass('active');

            });
            $('.addone').click(function() {



                if ($(this).hasClass('active')) {

                    $('.addone').removeClass('active');
                    $('#addone').val(0);

                } else {
                    $('.addone').removeClass('active');
                    $(this).addClass('active');
                    $('#addone').val(1);
                }



            });
        });
    </script>
    @endsection