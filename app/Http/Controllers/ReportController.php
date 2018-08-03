<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;

class ReportController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $report = Report::orderBy('id', 'desc')->first();
        if($report->status == 'accepted'){
            return $report;
        }
        else {
            return [];
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $report = Report::orderBy('id', 'desc')->first();
        return $report;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate new report inputs
        $validatedData = $request->validate([
			'long_from' => 'required|string',
			'long_to' => 'required|string',
			'lat_from' => 'required|string',
			'lat_to' => 'required|string',
            'description' => 'required|string|max:5000',
		]);

        // add new report
        $report = new Report;
        $report->long_from = $request->long_from;
        $report->long_to = $request->long_to;
        $report->lat_from = $request->lat_from;
        $report->lat_to = $request->lat_to;
        $report->status = 'none';
        $report->description = $request->description;

        $report->save();

        return $report->id;
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
    public function edit(Request $request)
    {
        //
    }
    
    public function data(Request $request)
    {
        $report = Report::orderBy('id', 'desc')->first();
        if($request->status == 'rejected'){
            $report->status = 'rejected';
        }
        else if($request->status == 'accepted'){
            $report->status = 'accepted';
        }
        else
        {
            $report->status = 'none';
        }
        $report->save();
        return $report;
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
}
