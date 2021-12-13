@extends('layouts.app')
<style type="text/css">
    img.path{
        height: 100px;
    }
    </style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update',$user->id) }}" enctype="multipart/form-data" class="repeater">
                        @method('PUT')
                        @csrf
                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                        @endif


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name}}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('File') }}</label>

                            <div class="col-md-4">
                                <input type="file" class="form-control-file" id="profile" name="profile">
                            </div>

                            <div class="col-md-4">
                                <img src="{{$user->path_src}}" class="img-fluid path" id="preview">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone no') }}</label>

                            <div class="col-md-6">
                                <div data-repeater-list="phone">
                                    @if(count($userinfo) > 0)
                                        @foreach ($userinfo as $info)
                                                <div data-repeater-item>
                                                <input type="text" name="mobile-number" class="form-control" value="{{ $info->mobile }}" @error('phone.*') is-invalid @enderror/>
                                                @error('phone.*')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                                <input type="hidden" name="mobile_id" value="{{ $item->id }}">
                                                <input data-repeater-delete type="button" class="btn btn-danger my-2" value="Delete"/>
                                                </div>
                                        @endforeach
                                    @endif
                                </div>
                                <input data-repeater-create type="button" class="btn btn-info my-2" value="Add"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">

    $(document).ready(function (e) {
        $('#profile').change(function(){
          let reader = new FileReader();
          reader.onload = (e) => {
            $('#preview').attr('src', e.target.result);
          }
          reader.readAsDataURL(this.files[0]);
      });

      //jquery repeater
      $('.repeater').repeater();
    });

</script>
@endpush
