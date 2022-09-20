<?php

namespace App\Http\Controllers;
use App\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Mail;

class ClusterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $user_id = Auth::id();
        $data= DB::table('clusters')
                    ->selectRaw('clusters.id as id,clusters.name as name,clusters.section as section, users.name as user_name')
                    ->leftJoin('users', 'clusters.user_id', '=', 'users.id')
                    ->leftJoin('clusters_users','clusters.id','=','clusters_users.cluster_id')
                    ->where('clusters_users.invited_user',$user_id)
                    ->get();
  
        return view('cluster.index',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('cluster.create');
    }
    /*****
     * function render a join page
     */
    public function JoinNow(){
        return view('cluster.join');
    }
    /**
     * Show the information of individual cluster.
     */
    public function show($cluster){
        // $user_id = Auth::id();
        $view_data = [];
        $view_data[0]= DB::table('clusters')
                    ->selectRaw('clusters.id as id,clusters.name as name,clusters.section as section, users.name as user_name, clusters.unique_id as share_id')
                    ->leftJoin('users', 'clusters.user_id', '=', 'users.id')
                    ->where('clusters.id',$cluster)
                    ->get();
        $view_data[1] = DB::table('content_clusters')
                    ->selectRaw('content_clusters.id as id,content_clusters.message as message,content_clusters.content as content, content_clusters.created_at as create_time,users.name as sender_name, users.id as sender_id')
                    ->leftJoin('clusters','content_clusters.cluster_id','=','clusters.id')
                    ->leftJoin('users','content_clusters.sender_id','=','users.id')
                    ->where('clusters.id',$cluster)
                    ->get();
        $view_data[2] = DB::table('users')
                    ->selectRaw('users.id as id,users.name as name,users.email as email')
                    ->leftJoin('clusters_users','clusters_users.invited_user','=','users.id')
                    ->where('clusters_users.cluster_id',$cluster)
                    ->get();
        //  return $view_data;
        return view('cluster.view',['data'=>$view_data]);
    }


    /**Store the data within database tables
     * 
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cname' => ['required','string','max:255'],
            'section' => ['string', 'max:255'],
            'creator' =>['exists:users,id']
        ]);
        $uniq_id = substr($validatedData['cname'],0,1);
        $nwcluster = Cluster::create([
            'name' => $validatedData['cname'],
            'section' => $validatedData['section'],
            'user_id' => $validatedData['creator'],
            'unique_id'=> $uniq_id.$validatedData['creator'].time()
        ]);
        if($nwcluster){
            $newrecord = DB::table('clusters_users')
                        ->insert([
                            'cluster_id' => $nwcluster->id,
                            'invited_user' => $nwcluster->user_id
                        ]);
        }
           
        return redirect('/cluster');
    }


    /***********
     * below function is used to store file in laravel public folder and messages in the database
     */
    public function ajaxMessageSend(Request $request)
    {
            $validatedData = $request->validate([
                'message' => ['required'],
                'input_file' => ['required'],
                'sender' => ['exists:users,id'],
                'cluster_id' => ['exists:clusters,id']
            ]);
            
            $fileName = $validatedData['input_file']->getClientOriginalName().'_'.$validatedData['cluster_id'].'_'.$validatedData['sender'].'.'.$validatedData['input_file']->getClientOriginalExtension();
            $validatedData['input_file']->move(public_path('/uploadedFile'), $fileName);
            $insertdata = DB::table('content_clusters')
                            ->insert([
                                'message' => $validatedData['message'], 
                                'cluster_id' => $validatedData['cluster_id'],
                                'sender_id' => $validatedData['sender'],
                                'content' => $fileName
                                ]);

            return redirect('/cluster/'.$validatedData['cluster_id']);          
    }


    /***********
     * below function is used to handaled ajax request to download file content from the application
     */
    public function downloadFileContent($fname){
        
            $filepath = public_path()."/uploadedFile/".$fname;
            return Response()->download($filepath);
        
    }


    /*******
     *  removefile funtion delete the content from the laravel public folder and also from the database
     */
    public function removeFile($file_id){
        $file_name= DB::table('content_clusters')
                    ->select('content_clusters.content as content')
                    ->where('id',$file_id)
                    ->get();

        $file_path = public_path()."/uploadedFile/".$file_name[0]->content;
            unlink($file_path);

        $c_id = DB::table('content_clusters')
                    ->select('content_clusters.cluster_id as cluster_id')
                    ->where('id',$file_id)
                    ->get();

        $deleted_file = DB::table('content_clusters')
                    ->where('id',$file_id)
                    ->delete();
        return redirect('/cluster/'.$c_id[0]->cluster_id); 
    }


    /*********
     * joinClusterNow function take the form data and add a new user to cluster_user table
     */
    public function joinClusterNow(Request $request){
        $validatedData = $request->validate([
            'cluster_code' => ['required','string','max:255'],
            'new_user' =>['exists:users,id']
        ]);
        $cluster_id = DB::table('clusters')
                        ->select('clusters.id as cluster_id')
                        ->where('clusters.unique_id',$validatedData['cluster_code'])
                        ->get();
        $insertedData = DB::table('clusters_users')
                        ->insert([
                            'cluster_id' => $cluster_id[0]->cluster_id,
                            'invited_user' => $validatedData['new_user']
                        ]);
        return redirect('/cluster');
    }
    public function showToDoList(){
        $user_id = Auth::id();
        $data=DB::table('to_do_table')
                ->selectRaw('content_clusters.id as id,content_clusters.message as message,content_clusters.content as content, content_clusters.created_at as create_time,users.name as sender_name, users.id as sender_id')
                ->leftJoin('content_clusters','content_clusters.id','=','to_do_table.item_id')
                ->leftJoin('users','content_clusters.sender_id','=','users.id')
                ->where('to_do_table.user_id',$user_id)
                ->get();
        // return $data;
        return view('cluster.todo',['data' => $data]);
    }
    /*********
     * addFileInToDoList function will add the selected file in to-do list
     */
    public function addFileInToDoList($file_id){
        $user_id = Auth::id();
        $insertdata = DB::table('to_do_table')
                            ->insert([
                                'user_id' => $user_id, 
                                'item_id' => $file_id
                            ]);
        if($insertdata){
            echo json_encode(['code' => 200]);
        }else{
            echo json_encode(['code' => 400]);
        }
        
    }

    /*******
     * removeFromToDo function will remove the item from the to-do list as per user request
     */
    public function removeFromToDo($file_id){
        $deleted_file = DB::table('to_do_table')
                    ->where('to_do_table.item_id',$file_id)
                    ->delete();
        return redirect('/cluster/to_do_list');
    }
    
    /********
     * below function will be used to send invite mail
     */
    public function inviteMail(Request $request) {
        $input = $request->all();
        // return $input;
        $name = $input['userName'];
        $email = $input['userEmail'];
        $cluster = $input['cluster_id'];
        // dd($email);
        $codeData= DB::table('clusters')
                    ->select('clusters.unique_id as inviteCode')
                    ->where('clusters.id',$cluster)
                    ->get();
                    
        $data = array('name'=>$name,'inviteCode'=>$codeData[0]->inviteCode); 
        Mail::send('cluster.mail', $data, function($message) use ($email, $name) {
           $message->to($email, $name)->subject
              ('Invite Mail');
           $message->from('etshareapplication@gmail.com','ETShare');
        });
        echo json_encode(['Code' => 200]);

     }
 /*******
     * removeFromToDo function will remove the item from the to-do list as per user request
     */
    public function leaveCluster($cluster_id){
        $user = Auth::id();
        $deleted_record = DB::table('clusters_users')
                    ->where('clusters_users.cluster_id',$cluster_id)
                    ->where('clusters_users.invited_user',$user)
                    ->delete();
        return redirect('/cluster');
    }

}
