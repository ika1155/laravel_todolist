<?php

namespace App\Http\Controllers;

use App\Models\Todo_item;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

class Todo_itemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
		$keyword = $request->input('keyword');

		$users = User::all();

		if (!empty($keyword)){
			//https://www.ritolab.com/posts/93
			//https://laraweb.net/practice/4756/
			$query = Todo_item::query();

			$query->Join('users', 'todo_items.user_id','=', 'users.id');
			$query->where('item_name', 'LIKE', "%{$keyword}%")
			->orWhere('users.name', 'LIKE', "%{$keyword}%");

			/* $sql = $query->toSql();
			dd($sql); */

			$todo_items = $query->orderBy('finished_date', 'asc')
								->orderBy('expire_date','asc')
								->get();
		}
		else{
			$todo_items = Todo_item::orderBy('finished_date', 'asc')
									->orderBy('expire_date','asc')
									->get();
		}
		
		return view('todo_item.index', compact('todo_items', 'users', 'keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$users = User::all();
		return view('todo_item.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$inputs=$request->validate([
			'item_name'=>'required|max:255',
			'user_id'=>'required|numeric|exists:App\Models\User,id',
			'expire_date'=>'required|date',
		]);

		$todo_item = new Todo_item();

		$todo_item->item_name=$request->item_name;
		$todo_item->user_id = $request->user_id;
		$todo_item->expire_date=$request->expire_date;
		$todo_item->registration_date=date('Y-m-d');
		if ($request->done){
			$todo_item->finished_date=date('Y-m-d');
		}
		
		$todo_item->save();
		return redirect()->route('todo_item.index')->with('message','作業登録を完了しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo_item  $todo_item
     * @return \Illuminate\Http\Response
     */
    public function show(Todo_item $todo_item)
    {
        //s
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo_item  $todo_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo_item $todo_item)
    {
        //
		$users = User::all();
		return view('todo_item.edit', compact('todo_item', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo_item  $todo_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo_item $todo_item)
    {
        //index(完了のみ)からとedit(編集)からで処理分け

		if ($request->from == 'edit'){
			$inputs = $request->validate([
				'item_name'=>'required|max:255',
				'user_id'=>'required|numeric|exists:App\Models\User,id',
				'expire_date'=>'required|date',
			]);

			$todo_item->item_name=$request->item_name;
			$todo_item->user_id = $request->user_id;
			$todo_item->expire_date=$request->expire_date;

			if ($request->done == "done"){
				$todo_item->finished_date=date('Y-m-d');
			}else{
				$todo_item->finished_date = NULL;
			}

			session()->flash('message', '作業内容を修正しました');

		} elseif ($request->from == 'index'){

			if ($request->done == "done"){
				if ($todo_item->finished_date == NULL){
					$todo_item->finished_date =date('Y-m-d');
					session()->flash('message', '作業を完了しました');
				}else{
					session()->flash('message', '完了済みの作業です');
				}
			}

		}

		$todo_item->save();
		return redirect()->route('todo_item.index')/* ->with('message','修正登録を完了しました') */;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo_item  $todo_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo_item $todo_item)
    {
        //
		$todo_item->delete();
		return redirect()->route('todo_item.index')->with('message','投稿を削除しました。');
    }
}
