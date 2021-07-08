<?php

namespace App\Http\Controllers;

use App\Models\CustomerTop;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerTopController extends Controller
{
    protected $image_url;

    function __construct()
    {
        $this->image_url = Storage::url('topic_image/');
    }

    public function index()
    {
        $topics = CustomerTop::latest()->paginate(10);
        return view('top.index', [
            'topics' => $topics,
            'per_page' => 10,
            'image_url' => $this->image_url
        ]);
    }

    public function create()
    {
        return view('top.form', [
            'topic' => NULL,
            'image_url' => $this->image_url
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        Notice::find($request->input('del_no'))->forceDelete();
        return redirect("/notice");
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
    public function edit($no=NULL)
    {
        //$no = $request->input('edit_no');

        $notice_model = new Notice();
        $shop_model = new Shop();

        $shops = $shop_model->get_shops();
        $image_url = Storage::url('notice_image/');

        if (isset($no))
            $notice = $notice_model->get_notice($no);
        else
            $notice = NULL;
        return view('notice_edit', [
            'notice' => $notice,
            'shops' => $shops,
            'image_url' => $image_url
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ( $request->input('no') != '')
            $topic = CustomerTop::find($request->input('no'));
        else
        {
            $topic = new CustomerTop;
        }

        $topic->title = $request->input('title');
        $topic->content = $request->input('content');
        if ($request->file('thumbnail') != NULL)
        {
            $topic->image = time().'_'.$request->file( 'thumbnail')->getClientOriginalName();
            $topic->image_link = asset(Storage::url('topic_image/').$topic->image);
            $request->file('thumbnail')->storeAs('public/notice_image/',$topic->image);
        }
        $topic->save();

        return redirect("/topic");
    }
}
