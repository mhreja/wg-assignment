<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MyDatatableController extends Controller
{
    public function index(){
        return view('mydatatable.index');
    }


    public function newgetusers(Request $request){        
        $columns = array( 
            0 =>'id', 
            1 =>'name',
            2=> 'email',
            3=> 'created_at',
            4=> 'id',
        );
    
        $totalData = User::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $users =  User::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
            ->get();

            $totalFiltered = User::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($users))
        {
            foreach ($users as $user)
            {
                // $show =  route('users.show',$user->id);
                // $edit =  route('users.edit',$user->id);

                $nestedData['id'] = $user->id;
                $nestedData['name'] = $user->name;
                $nestedData['email'] = $user->email;
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($user->created_at));
                $nestedData['options'] = "<a href='' class='btn btn-info' ><i class='fa fa-edit'></i></a><a href='' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                $data[] = $nestedData;
            }
        }
            
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data); 
    }
}
