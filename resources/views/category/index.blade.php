@extends('layouts.app')

@section('css')
<style type="text/css">

</style>
@endsection



@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <table id="example" class="table table-bordered" style="width:100%" data-url="{{route('category.datatable')}}">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>User Name</th>
                        <th>Category Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url" :$('#example').attr('data-url'),
                "type": "POST",
                "datatype": "JSON"
            },
            "order": [
                [0,"desc"]
            ],
            "columns":[
                {
                    "data":"id"
                },
                {
                    "data":"title"
                },
                {
                    "data":"content"
                },
                {
                    "data":"name"
                },
                {
                    "data":"image"
                },
                {
                    "data":"action"
                }
        ]
        });
    });
</script>


@endpush




