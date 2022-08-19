@extends('layout.main')

@section('content')

    <style>
        .plans {
            border: 1px #cccaca solid;
            border-radius: 10px;
            padding: 20px;
            height: 220px;
            cursor: pointer;
        }

        .apply {
            position: absolute;
            right: 0;
            margin-right: 5px;
            top: 2px;
            font-size: 15px;
        }

        .active {
            border: 2px solid black;
        }
    </style>

    <form action="{{url('subscription')}}" method="post">
        @csrf

        <div class="row my-5">

            <div class="col-md-6">

                <img class="w-100"
                     src="https://cdn.shopify.com/s/files/1/0654/0958/1314/products/JOLT_Frontal2.png?v=1659693413&width=600"
                     alt="">
            </div>
            <div class="col-md-6 p-5">

                <h3>JOLT BRUTE</h3>

                <h6>The real EYE-TURNER of electric bikes!</h6>
                <p>
                    Allow yourself to see more, more often with no limitations. Let the JOLT BRUTE tackle those hills
                    and reach speeds up to 45km/h in no time at all. With 1000 wattage of power located in the rear
                    wheel with front suspension most would not suspect the true power and potential of the JOLT BRUTE.
                    If you are looking for performance and comfort, look no further.
                </p>
            </div>


        </div>

        <div class="row my-4">

            <div class="col-md-4 ">
                <div class="col-12 plans active subscription" pack="1">
                    <i class="fa fa-check-circle apply" aria-hidden="true"></i>
                    <p>1 Month - £129</p>
                    <p class="font-weight-bold">£129 per month.</p>
                    <p>JOLT bike for 1 month? This is the plan for you. When your plan expires renew or cancel.</p>
                </div>

            </div>
            <div class="col-md-4 ">
                <div class="col-12 plans subscription" pack="2">
                    <i class="fa fa-check-circle hide apply" aria-hidden="true"></i>
                    <p>3 Months - £99</p>
                    <p>£99 per month - £120 savings</p>
                    <p>Save more by locking into a 3 month contract. Pay monthly at a discounted rate.</p>
                </div>

            </div>

            <div class="col-md-4 ">
                <div class="col-12 plans subscription" pack="3">
                    <i class="fa fa-check-circle hide apply" aria-hidden="true"></i>
                    <p>6 Months - £79</p>
                    <p>£79 per month - £300 savings</p>
                    <p>Save even more with a 6 month rental. Pay monthly at a more discounted rate.</p>
                </div>

            </div>

            <input type="hidden" value="1" id="package" name="package">
            <input type="hidden" value="0" id="addone" name="addone">

        </div>


        <div class="row my-4">

            <div class="col-12">

                <h3>Select a level of loss cover</h3>
                <p>With bike theft on the rise in many urban areas, we strongly advise you protect yourself with loss
                    cover.
                    75% of jolt riders have some level of cover. Select one tier of loss cover to protect yourself
                    against
                    theft and loss of accessories.

                </p>
            </div>

            <div class="col-md-4 ">
                <div class="col-12 plans addone">
                    <i class="fa fa-check-circle hide apply" aria-hidden="true"></i>
                    <p>Theft Replacement Protection</p>
                    <p class="font-weight-bold"> £50 Per Month</p>
                    <p>Personal liability limited to £300 if bike locked according to jolt guidelines.</p>
                </div>

            </div>


        </div>

        <div class="accessories">

        </div>


        @endsection

        @section('content2')
            <div class="container-fluid bg-light p-5">
                <div class="container">
                    <div class="row my-4 ">

                        <div class="col-12 ">

                            <h3>Suggested accessories</h3>

                        </div>

                        <div class="col-md-4 ">
                            <div class="col-12 mt-4 p-0">
                                <div class="card p-3 item-added">
                                    <div class="col-12 text-center text-success success hide">
                                        <p><i class="fa fa-check-circle " aria-hidden="true"></i>
                                            Item added to reservation

                                        </p>
                                    </div>
                                    <img class="card-img-top"
                                         src="https://cdn.sanity.io/images/hdjyi1x3/production/d2b67ea85f2af1092d843da880b001d9e88a04d8-750x520.png"
                                         alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">Rear Rack</h5>
                                        <p class="card-text font-weight-bold">£2 per Month
                                        </p>

                                        <div class="col-12 p-0">
                                            <button class="bnt btn-outline-dark w-100 p-2 add_res" accesories="1" stat="0" type="button"
                                                    style="border-radius: 10px">
                                                Add to reservation
                                            </button>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>


                </div>


            </div>

            <div class="container">
                <div class="col-12 text-right">
                    <button class="btn btn-dark my-4" type="submit">Continue to reservation summary</button>
                </div>
            </div>

        @endsection
    </form>

        @section('js')
            <script>
                $(document).ready(function () {

                    $('.subscription').click(function () {

                        $('#package').val($(this).attr('pack'));

                        $('.subscription').removeClass('active');
                        $(this).addClass('active');

                        $('.subscription').find('.fa-check-circle').hide();

                        $(this).find('.fa-check-circle').show();

                    });
                    $('.addone').click(function () {


                        if ($(this).hasClass('active')) {

                            $('.addone').removeClass('active');
                            $('#addone').val(0);
                            $(this).find('.fa-check-circle').hide();

                        } else {
                            $('.addone').removeClass('active');
                            $(this).addClass('active');
                            $('#addone').val(1);
                            $(this).find('.fa-check-circle').show();
                        }


                    });

                    $('.add_res').click(function () {
                        var id=$(this).attr('accesories');
                        if($(this).attr('stat')==0)
                        {
                            $(this).attr('stat',1);
                            $(this).html('Remove');
                            $('.accessories').append(`<input type="hidden" name="accesories[]" class="acces_${id}" value="${id}">`);

                        }
                        else{
                            $(this).attr('stat',0);
                            $(this).html('Add to reservation');
                           $('.acces_'+id).remove();
                        }




                        $(this).closest('.item-added').find('.success').toggle();




                    });
                });
            </script>
@endsection
