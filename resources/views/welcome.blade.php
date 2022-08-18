
@extends('layout.main')

@section('content')


<!-- Modal -->
<div class="modal fade" id="selectcity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body">
               <div class="row">
                   <div class="col-12 text-center">
                       <h4>Please Select City</h4>

                       <div class="col-12 text-center my-3">
                       <h5 class="mt-4 p-2 w-25 m-auto" style="border: 1px solid #575353;border-radius: 5px">London</h5>
                       </div>
                       <form action="{{'language'}}" method="post">
                           @csrf
                           <button class="btn btn-primary mt-2 mb-3">Select</button>
                       </form>

                   </div>
               </div>
            </div>

        </div>
    </div>
</div>


@endsection


@section('js')
    <script>
        $(document).ready(function(){
            $('#selectcity').modal('show')
        });

        $('#selectcity').modal({
            backdrop: 'static',
            keyboard: false
        });
    </script>
@endsection
