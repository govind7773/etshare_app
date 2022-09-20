@extends('layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{asset('css/clusters/create.css')}}">
<link rel="stylesheet" href="{{asset('css/clusters/view.css')}}">
@endsection
@section('content')
<div class="loading"></div>
<div class="container ">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <div class="card create_card">
                    <div class="card-header font-large-1 border-bottom"><h1 class="text-center">Join Cluster Now</h1></div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="/cluster/joinClusterNow" id="joinForm">
                            @csrf
                            <div class="form-group row">
                                <label for="cluster_code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Cluster code') }}</label>
                                <div class="col-md-6">
                                    <input id="cluster_code" type="text" placeholder="enter code here .."
                                           class=" form-control " name="cluster_code" required>
                                    <small id="codeHelp" class="form-text text-muted"> Paste The Cluster code here
                                    </small>
                                    @error('cname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input readonly id="new_user" type="text" value="{{auth()->id()}}" class="hidden"
                                   name="new_user" hidden>
                            <div class="form-group row m-auto justify-content-center ">
                                    <button type="submit" class="btn btn01 text-white border border-primary float-right col-auto">
                                        {{ __('Join Now') }}
                                    </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
@section('pageJs')
<script src="{{asset('js/clusters/join.js')}}"></script>
@endsection