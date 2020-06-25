<?php

namespace App\Http\Controllers;

use App\Items;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Items::where([['status', true]])->get();
        return view('items.list', compact('items'));
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
            'item' => 'required|string|max:250',
            'unit_amount' => 'required|numeric',
            'ratios' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'string|max:2000',
            'unit_measure' => 'string|max:100',
        ]);
        $item = Items::insert([
            'item' => $request->item,
            'unit_amount' => $request->unit_amount,
            'ratio_produced' => $request->ratios,
            'price' => ($request->price),
            'description' => $request->description,
            'unit_measure' => $request->unit_measure,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($item) {
            session()->flash("success", "Success, Item added");
        } else {
            session()->flash("warning", "Failed, Item not added");
        }
        return redirect()->route('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function show(Items $items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Items $items)
    {
        $item = Items::where('id', $request->id)->first();
        if (!$item) {
            session()->flash("warning", "Failed, Selected item not exist");
            return redirect()->back();
        }
        $this->validate($request, [
            'item' => 'required|string|max:250',
            'unit_amount' => 'required|numeric',
            'ratios' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'string|max:2000',
            'unit_measure' => 'string|max:100',
        ]);
        $item = $item->update([
            'item' => $request->item,
            'unit_amount' => $request->unit_amount,
            'ratio_produced' => $request->ratios,
            'price' => ($request->price),
            'description' => $request->description,
            'unit_measure' => $request->unit_measure,
            'updated_at' => now(),
        ]);

        if ($item) {
            session()->flash("success", "Success, Item updated");
        } else {
            session()->flash("warning", "Failed, Item not updated");
        }
        return redirect()->route('items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Items  $items
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Items::where('id', $request->id)->first();
        if (!$item) {
            session()->flash("warning", "Failed, Selected item not exist");
            return redirect()->back();
        }
        $item = $item->update([
            'status' => false,
            'updated_at' => now(),
        ]);

        if ($item) {
            session()->flash("success", "Success, Item removed");
        } else {
            session()->flash("warning", "Failed, Item not removed");
        }
        return redirect()->route('items');
    }
}
