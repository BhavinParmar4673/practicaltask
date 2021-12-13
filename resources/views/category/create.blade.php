@extends('layouts.app')

@section('css')
<style type="text/css">

</style>
@endsection


@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-9">
            @if(Session::has('message'))
            <div class="alert alert-success">
                {{ Session::get('message')}}
            </div>
            @endif
            <form method="post" action="{{route('user.addfriend')}}">
            @csrf
                     <button class="btn btn-primary my-4 addfrirend">Add Friend</button>
            </form>
            {{-- <form method="post" action="{{route('category.store')}}" enctype="multipart/form-data">
                @csrf


                        <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" aria-describedby="emailHelp" placeholder="Enter Title">
                        @error('title')
                                <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                        <label for="exampleInputPassword1">Content</label>
                        <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" placeholder="write a content">

                        </textarea>
                        @error('title')
                                <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <input id="upload" type="file" name="image" class="d-none" />
                            <button id="upload_link" class="btn btn-success">Upload Category Image</button>
                            {{-- @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror --}}
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
            </form> --}}
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#upload:hidden").trigger('click');
        });

        // $(document).on('click','#addfrirend',function(){
        //     e.preventDefault();
        //     alert('ff')
        //     let url = $(this).data('url');
        //     $.ajax({
        //         type:"post",
        //         url : url,
        //         success:function(data){
        //             alert(data.success);
        //         }
        //     })
        // })
    });
</script>
@endpush
