<?php

namespace App\Http\Controllers;

use App\Items;
use App\Report;
use App\ReportItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::where('status', true)->get();
        // $new_list = [];
        // foreach ($reports as $report) {
        //     $items = ReportItem::where('reportID', $report->id)->get();
        //     $expected = 0;
        //     foreach ($items as $item) {
        //         $expected += ($item->price * $item->ratios);
        //     }
        //     $report['expected'] = $expected;
        //     array_push($new_list, $report);
        // }
        // $reports = $new_list;
        return view('reports.list', compact('reports'));
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
            'date' => 'required|before:tomorrow|date',
        ]);
        $report = Report::insertGetId([
            'date' => $request->date,
            'actual_amount' => $request->amount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        if ($report > 0) {
            return redirect()->route('report-items', compact('report'));
        } else {
            session()->flash("warning", "Failed, report not added");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $report = Report::where('id', $request->report)->first();
        if (!$report) {
            session()->flash("warning", "Failed, report not exist");
            return redirect()->back();
        }
        $report_items = DB::table('report_items')->where('reportID', $report->id)
            ->join('items', 'items.id', 'report_items.itemID')
            ->select('report_items.id', 'itemID', 'items.item', 'report_items.quantity', 'report_items.price', 'report_items.portions')
            ->get();
        $items = Items::where('status', true)->get();

        return view('reports.add_item', compact('report', 'report_items', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $report = Report::where('id', $request->id)->first();
        if (!$report) {
            session()->flash("warning", "Failed, Selected report not exist");
            return redirect()->back();
        }
        $report = $report->update([
            'status' => false,
            'updated_at' => now(),
        ]);

        if ($report) {
            session()->flash("success", "Success, Report removed");
        } else {
            session()->flash("warning", "Failed, Report not removed");
        }
        return redirect()->route('reports');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(Request $request)
    {
        $item = ReportItem::where('id', $request->id)->first();
        if (!$item) {
            session()->flash("warning", "Failed, Selected item not exist");
            return redirect()->back();
        }

        if ($item->delete()) {
            session()->flash("success", "Success, Item removed");
        } else {
            session()->flash("warning", "Failed, Item not removed");
        }
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function storeItem(Request $request)
    {
        $item = Items::where('id', $request->item)->first();

        if (!$item) {
            session()->flash("warning", "Failed, Selected item not exist");
            return redirect()->back();
        }

        $this->validate($request, [
            'report_id' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);
        $portions = ($request->quantity / $item->unit_amount) * $item->price;

        $item = DB::table('report_items')->insert([
            'reportID' => $request->report_id,
            'itemID' => $item->id,
            'portions' => $portions,
            'quantity' => $request->quantity,
            'price' => $item->price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($item) {
            session()->flash("success", "Success, Item added");
        } else {
            session()->flash("warning", "Failed, Item not added");
        }
        return redirect()->back();
    }
    /**
     * Print the specified resource.
     *
     * @param  \App\Proforma  $report
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        $report = Report::where('reports.id', $request->id)->first();
        if ($report) {
            $name = "Report-of-" . $report->date . ".pdf";
            $items = ReportItem::where('reportID', $report->id)->join('items', 'items.id', 'report_items.itemID')
                ->select('report_items.id', 'itemID', 'items.item', 'report_items.quantity', 'items.description', 'report_items.price', 'report_items.portions')
                ->get();
            // return view('reports.report', compact('report', 'items'));
            $pdf = PDF::loadView('reports.report', compact('report', 'items'));
            return $pdf->download(str_replace(" ", "_", $name));
        }
    }
}
