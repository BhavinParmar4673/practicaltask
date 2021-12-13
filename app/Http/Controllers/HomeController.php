<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Userinfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(2);

        return view('home',['users'=>$users]); //method 1
        // return view('home')->with('users',$users)->with('data',$users); method 2
        // return view('home',compact('data','users')); method 3
    }

    public function edit($id){
        $user = User::findorFail($id);
        $userinfo = Userinfo::where('user_id',$id)->get();
        return view('user.edit',['user'=>$user,'userinfo'=>$userinfo]);
    }

    public function update(Request $request,$id){

        $user = User::findorFail($id);

        $rules = [
            'name' => [ 'string', 'max:255'],
            'email' => [ 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'profile' => ['mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'phone.*.mobile-number' =>['required']
        ];

        $message = [
            'phone.*.mobile-number.required' => 'Phone no Is required.'
        ];

        $this->validate($request, $rules, $message);


        $phones = $request->phone;

        if ($request->hasFile('profile')) {
            $image =$request->file('profile');
            $user->deleteimage();
            $path =$image->store('image');
            $user->path = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        $oldmobile = collect($phones)->whereNotNull('mobile_id')->pluck('id');
        $newmobile = collect($phones)->whereNull('mobile_id')->pluck('id');
        if($oldmobile->count() >0 || $newmobile->count() >0){
            $deletemobile = Userinfo::whereNotIn('id',$oldmobile)->where('user_id',$id)->delete();
        }

        foreach($phones as $key => $value){
            $phones = [
                'mobile' => $value['mobile-number']
            ];
            $Userinfo =  Userinfo::updateOrCreate(['id'=>$value['mobile_id'],'user_id' => $id],$phones);
        }

        return redirect()->route('home')->with('message','Profile Updated Successfully');
    }

    public function imageremove($id){
        $user = User::findorFail($id);
        if($user->path){
            $user->deleteimage();
            $user->path = null;
        }
        $user->save();
        return response()->json(['status'=>1,'img'=>$user->path_src],200);

    }
}
