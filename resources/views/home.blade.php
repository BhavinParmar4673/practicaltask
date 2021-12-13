@extends('layouts.app')

@section('css')
<style type="text/css">
img.path{
    height: 100px;
    width: 100px;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $user)
                  <tr>
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->email}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                        @if($user->path == null)
                            <img src="{{$user->path_src}}" class="img-fluid path" alt="no image"/>
                        @else
                        <div class="imageremove">
                            <img src="{{$user->path_src}}" class="img-fluid path" alt="no image"/>
                            <a href="javascript:void(0)" class="btn btn-danger button ml-4" data-url="{{ route('profile.image',$user->id) }}">Remove</a>
                        </div>
                        @endif
                    </td>

                    <th scope="col"><a href="{{ route('profile.edit',$user->id) }}" class="btn btn-info">Edit</th>
                  </tr>
                  @empty
                   <p>No Record Found</p>
                  @endforelse
                </tbody>
              </table>
        </div>
    </div>
    {{ $users->links() }}
</div>


@endsection



@push('scripts')
<script type="text/javascript">

    $(document).ready(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $('.button').click(function(){

        let elem = $(this);
        let url = $(this).attr('data-url');

        $.ajax({
        type:'POST',
        url: url,
        success: (data) => {
            if(data.status == 1){
                elem.closest('div').find('img').attr('src',data.img);
                elem.remove();
            }
        },
        error: function(data){
           console.log(data);
         }
       });

      });
    });

</script>
@endpush

