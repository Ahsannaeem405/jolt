@extends('layout.main')

@section('content')

    <form action="{{url('pick')}}" method="post">
        @csrf

        <div class="card mt-5 ">

            <div class="card-body">
                <h3>Get your e-bike</h3>


                <div data-role="page" id="datepickerPage ">
                    <div id="dateDepart" class="datepicker p-3"></div>
                </div>

                <div class="col-12 text-right">
                    <button class="btn btn-dark my-4" type="submit">Continue to billing detail</button>
                </div>


            </div>
        </div>


        @endsection

        @section('js')
            <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
            <script>


                initDatePickers();


                function initDatePickers() {

                    // $("#dateDepart").datepicker({
                    //     minDate: 0,
                    //
                    //     onChangeMonthYear: function (year, month, inst) {
                    //
                    //     },
                    //     onSelect: function (selectedDate, inst) {
                    //
                    //
                    //     },
                    // });

                    availableDates = ['04-25-2015', '08-16-2022', '08-15-2022'];
                    $('#dateDepart').datepicker({
                        dateFormat: 'mm-dd-yy',
                        minDate: 0,
                        beforeShowDay: function (d) {
                            var dmy = (d.getMonth() + 1)
                            if (d.getMonth() < 9)
                                dmy = "0" + dmy;
                            dmy += "-";

                            if (d.getDate() < 10) dmy += "0";
                            dmy += d.getDate() + "-" + d.getFullYear();

                            console.log(dmy + ' : ' + ($.inArray(dmy, availableDates)));

                            if ($.inArray(dmy, availableDates) != -1) {
                                return [true, "", "Available"];
                            } else {
                                return [false, "", "unAvailable"];
                            }
                        },

                        onSelect: function (selectedDate, inst) {


                        },
                        todayBtn: "linked",

                        autoclose: true,
                        todayHighlight: true
                    });
                }
            </script>

@endsection
