
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

                       <h5 class="mt-4">London</h5>

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
