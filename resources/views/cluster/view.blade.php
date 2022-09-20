@extends('layouts.app')
@section('pageCss')
<link rel="stylesheet" href="{{asset('css/clusters/view.css')}}">
@endsection
@section('content')
<div id="loading"></div>

<!-- share cluster code modal -->
<div class="modal fade" id="share_cluster" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Copy & Share the Below code to other members</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <h3 class="text-center">{{$data[0][0]->share_id}}</h3>
                    </div>
                    <h5 class="text-center">OR</h5>
                    <div>
                        <form id="inviteUser" action="">
                            @csrf
                            <input type="text" class="form-control" name="userName" id="userName" placeholder="Enter User Name here.." required>      
                            <input class="form-control" type="text"  name="userEmail" id="userEmail"  required placeholder="Enter Email Address..">
                            <input readonly id="cluster_id" type="text" value="{{$data[0][0]->id}}" class="hidden" name="cluster_id" hidden>
                            <button type="submit" id="" class="btn btn01 text-white border border-success float-right col-auto mx-1">{{'Invite Now'}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- view cluster members modal -->
<div class="modal fade" id="view_members" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cluster member's :</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 h5">Name</div>
                        <div class="col-8 h5">Email</div>
                        @foreach($data[2] as $member)
                        <div class="col-4 h5">{{$member->name}}</div>
                        <div class="col-8 h5">{{$member->email}}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="container ">
    <div class="row justify-content-center d-flex flex-column">
        <div class="cluster_heading text-white py-2 rounded">
            <div class=" fw-bold h1 d-inline text-primary" id="cluster_name_heading">{{$data[0][0]->name}}</div>
            <div class="dropdown nav navbar-nav navbar-right d-inline float-right">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        
                        <span class="d-none d-sm-inline mx-1"><i class="fa-solid fa-ellipsis-vertical fs-5"></i></span>
                    </a>         
                    <ul class="dropdown-menu dropdown-menu-dark  shadow text-white bg-dark" aria-labelledby="dropdownUser1">
                        <li> <a class="dropdown-item text-white bg-dark" href="/cluster/leaveCluster/{{$data[0][0]->id}}">
                                        {{ __('leave cluster') }}
                                    </a>
                        </li>         
                    </ul>
                </div>
            <div class="  fw-bold h4 d-inline text-white float-right fst-italic mx-2" id="creater_name">{{$data[0][0]->user_name}}</div> 
            <div class="des text-white">
                <h5 class="d-inline fst-italic ">{{$data[0][0]->section}}</h5>
  
            <a href="#" class="btn btn01 btn-raised float-right ml-1 text-white border border-success" data-toggle="modal" data-target="#view_members">View Members</a>
            <a href="#" class="btn btn03 btn-raised float-right ml-1 text-white border border-primary" data-toggle="modal" data-target="#share_cluster">Share</a>
            </div>
        </div>
        <div class="py-3 shadow-lg rounded" id="input_box">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
            <form id="message_form" action="/cluster/ajaxMessageSend" method="POST" enctype="multipart/form-data">
                @csrf    
                <input type="text" class="form-control" name="message" id="message" placeholder="Enter text here.." required>     
                <div class="row mx-1">    
                    <input class="form-control col-4 mx-1" type="file"  name="input_file" id="input_file" multiple required>
                    <input readonly id="sender" type="text" value="{{auth()->id()}}" class="hidden" name="sender" hidden>
                    <input readonly id="cluster_id" type="text" value="{{$data[0][0]->id}}" class="hidden" name="cluster_id" hidden>
                    <button type="submit" id="send_message" class="btn btn01 text-white border border-success float-right col-auto mx-1">{{'Send'}}</button>
                </div>
            </form>
        </div>
        <?php $i = 0; ?>
        @foreach($data[1] as $d)
        <div class="message_heading text-white py-4 my-2 rounded px-2">
            <div class="my-0 ">
            <p class="d-inline border p-1 rounded" >{{$d->sender_name}}</p>
            <p class="d-inline float-right my-0" style="color: #cbd1d1;">{{$d->create_time}}</p>
            </div>
            <div class="my-2">
            <p class="d-inline fst-italic message_text" style="color: #cbd1d1;" >{{$d->message}}</p>
            <p class="d-inline float-right fst-italic">
                <button class="to_do_btn btn"  onclick="myFunction({{$d->id}})"><i class="fa-solid fa-list-check fs-5"></i></button>

                <a href="/cluster/downloadFileContent/{{$d->content}}" id="downloadFile" class="text-decoration-none">Attachment  
                    <span class="h3 mx-2"><i class="fas fa-file-download"></i> </span></a>
                @if(Auth::user()->id == $d->sender_id)
                <a href="/cluster/removeFile/{{$d->id}}" class="text-decoration-none delete_content">
                    <span class="h3 mx-2"> <i class="fa-solid fa-trash-can"></i></span></a>
                @endif
            </p>    
            </div>
        </div>
        <?php $i++; ?>
        @endforeach
       
    </div>
</div>
@endsection
@section('pageJs')
<script src="{{asset('js/clusters/view.js')}}"></script>
@endsection