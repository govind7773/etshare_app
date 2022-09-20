@extends('layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{asset('css/clusters/index.css')}}">
@endsection
@section('content')
<div class="loadling"></div>
<div class="container border-2 border-dark border bg-dark shadow-sm ">
    <div class="row justify-content-center d-flex flex-column">
        <h1 class="my-4 fw-bold border-bottom border-white text-white" style="text-shadow: 6px 5px black;">List of Cluster's</h1>
        @foreach($data as $cluster)
        <div class="cluster_body cards  my-2 mx-auto rounded">
            <div class="card-body py-1">
            <a href="/cluster/{{$cluster->id}}" class="text-decoration-none">
            <div class="cluster-head h3">{{$cluster->name}}</div>
            <p class="d-inline fst-italic text-white">{{$cluster->section}}</p>
            <p class="d-inline float-right fst-italic text-white">Admin- {{$cluster->user_name}}</p>
            </a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
@section('pageJs')
<script src="{{asset('js/clusters/index.js')}}"></script>
@endsection