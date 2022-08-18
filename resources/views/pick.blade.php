@extends('layout.main')

@section('content')
    <style>
        .ui-datepicker td span, .ui-datepicker td a{
            text-align: center!important;
        }
        .ui-state-default {

            border-radius: 5px !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ui-datepicker {
            width: 28em;
            padding: .2em .2em 0;
            display: none;
        }

        .ui-datepicker table {
            width: 100%;
            font-size: 1.5em;
            border-collapse: collapse;
            margin: 0 0 .8em;
        }
    </style>
    <form action="{{url('pick')}}" method="post">
        @csrf

        <input type="hidden" value="" id="pick" name="pick">

        <div class="card mt-5 ">

            <div class="card-body">
                <h3 class="pl-3">Get your e-bike</h3>


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

                    availableDates = [];

                    var mon = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                    for (i = 2; i <= 4; i++) {
                        var date = new Date();
                        date.setDate(date.getDate() + i);

                        var push = mon[date.getMonth()] + '-' + date.getDate() + '-' + date.getFullYear();
                        availableDates.push(push);
                    }

                    console.log(availableDates);


                    //availableDates = ['04-25-2015', '08-16-2022', '08-15-2022'];
                    $('#dateDepart').datepicker({
                        dateFormat: 'mm-dd-yy',
                        setDate: mon[0],
                        endDate: '',
                        minDate: 0,
                        beforeShowDay: function (d) {
                            var dmy = (d.getMonth() + 1)
                            if (d.getMonth() < 9)
                                dmy = "0" + dmy;
                            dmy += "-";

                            if (d.getDate() < 10) dmy += "0";
                            dmy += d.getDate() + "-" + d.getFullYear();

                            //  console.log(dmy + ' : ' + ($.inArray(dmy, availableDates)));

                            if ($.inArray(dmy, availableDates) != -1) {
                                return [true, "", "Available"];
                            } else {
                                return [false, "", "unAvailable"];
                            }
                        },

                        onSelect: function (selectedDate, inst) {

                            $('#pick').val(selectedDate);
                        },
                        todayBtn: "linked",

                        autoclose: true,
                        todayHighlight: true
                    });
                }
            </script>

@endsection
