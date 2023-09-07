<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Mail\ItemMail;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::withTrashed()->get();
        //$items = DB::table('items')->join('users','items.user_id', '=', 'users.id')->select('items.*','users.name')->get();
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $item = new Item();
        $users = User::get();
        return view('item.create', compact('item','users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $item = new Item();
        $item->title = $request->title;
        $item->details = $request->details;
        $item->user_id = $request->user_id;

        if ($image = $request->file('image')) {
            $destinationPath = 'uploads/';
            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $postImage);
            $item->image = "$postImage";
        }

        $item->save();

        Mail::to($item->user->email)->send(new ItemMail($item));

        return redirect()->route('item')->with('info', 'Maklumat alat berjaya disimpan. Satu emel telah dihantar kepada ' . $item->user->email);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::find($id);

        return view('item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::find($id);
        $users = User::get();
        return view('item.edit', compact('item', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        $item = Item::find($id);
        $item->title = $request->title;
        $item->details = $request->details;
        $item->user_id = $request->user_id;

        if ($image = $request->file('image')) {
            File::delete('uploads/' . $item->image);
            $destinationPath = 'uploads/';
            $postImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $postImage);
            $item->image = "$postImage";
        }

        $item->save();

        return redirect()->route('item')->with('info', 'Rekod alat berjaya dikemaskini');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);

        File::delete('uploads/' . $item->image);

        $item->delete();

        return redirect()->route('item')->with('warning','Rekod alat berjaya dihapuskan');
    }

    public function restore(string $id)
    {
        $item = Item::withTrashed()->find($id);

        //File::delete('uploads/' . $item->image);

        $item->restore();

        return redirect()->route('item')->with('success','Rekod alat berjaya dihidupkan semula');
    }
}
