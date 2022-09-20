@extends('layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{asset('css/clusters/view.css')}}">
@endsection
@section('content')

<div class="container ">
    <div class="row justify-content-center d-flex flex-column">
        <div class=" text-white py-2 rounded">
            <div class=" fw-bold h1 d-inline text-white" id="cluster_name_heading" style="text-shadow: 6px 5px black;
">To-Do List</div>
            
        </div>
        @foreach($data as $d)
        <div class="message_heading text-white py-4 my-2 rounded px-2">
            <div class="my-0 ">
            <p class="d-inline border p-1 rounded" >{{$d->sender_name}}</p>
            <p class="d-inline float-right my-0" style="color: #cbd1d1;">{{$d->create_time}}</p>
            </div>
            <div class="my-2">
            <p class="d-inline fst-italic" style="color: #cbd1d1;">{{$d->message}}</p>
            <p class="d-inline float-right fst-italic">
                <a href="/cluster/removeFromToDo/{{$d->id}}" id="addToDo" class="text-decoration-none text-danger"> remove
                    <span class="h3 mx-2"><i class="fa fa-window-close" aria-hidden="true"></i></span></a>
                <a href="/cluster/downloadFileContent/{{$d->content}}" id="downloadFile" class="text-decoration-none">Attachment  
                    <span class="h3 mx-2"><i class="fas fa-file-download"></i> </span></a>
                
            </p>    
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
@section('pageJs')
@endsection