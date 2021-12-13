<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.index');
    }

    public function datatable(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'content',
            3 => 'path',
            4 => 'user_id',
            5 => 'action'
        );

        $totalData = Category::count();


        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];

        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $categoryCollection = Category::with('user')
            ->whereHas('user', function ($query) use ($search) {
                return  $query->where('name', 'like', '%' . $search . '%');
            });

        $totalFiltered = $categoryCollection->count();

        $postCollection = $categoryCollection->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = [];

        foreach ($postCollection as $key => $item) {
            $row['id'] = $item->id;
            $row['title'] = $item->title;
            $row['content'] = '<b>' . $item->content . '</b>';
            $row['name'] = '<b>' . $item->user->name . '</b>';
            $row['image'] = '<img src="' . $item->path_src . '" class="img-responsive w-25 h-25">';
            $row['action'] = 'yes';
            // $row['action'] = '<button id="edit-item" type="button" data-url="' . route('admin.posts.show', $item->id) . '" class="edit btn btn-primary btn-sm" data-toggle="ajaxModel" data-target="ajaxModel">View</button>';
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return response()->json($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            // 'image' => 'required|mimes:jpg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ]);
        $path = $request->image->store('categoryimage');
        $category = Category::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'image' => $path
        ]);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //sent a friend request
    public function sentrequest(Request $request)
    {

        $sender     = auth()->user();
        $recipient  = User::find(3);

        $sender->befriend($recipient);

        return redirect()->back()->with('message', 'user Send a Friend Request');
    }

    public function profile()
    {
        $user = auth()->user();
        $sender = User::find(1);
        $sender1 = DB::table('friendships')->where('recipient_id', $user->id)->pluck('sender_id');
        return view('profile', ['user' => $user]);
    }

    public function acceptrequest(Request $request)
    {
        $user = auth()->user();
        $sender1 = DB::table('friendships')->where('recipient_id', $user->id)->pluck('sender_id');
        $sender = User::find($sender1[0]);
        $user->acceptFriendRequest($sender);
        return redirect()->back()->with('message', 'user accept a Friend Request');
    }
}