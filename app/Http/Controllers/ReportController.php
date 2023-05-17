<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'location' => 'required',
            'time' => 'required|date_format:Y-m-d H:i:s',
            'description' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,jpg,png',
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Laporan gagal dikirim, terdapat kesalahan pada data Anda.',
                'data' => ''
            ]);
        }

        if ($request->hasFile('picture')) {
            Report::create([
                'title' => $request->title,
                'location' => $request->location,
                'time' => $request->time,
                'description' => $request->description,
                'picture' => $request->file('picture')->store('public/report'),
                'user_id' => $request->user_id
            ]);
        } else {
            Report::create([
                'title' => $request->title,
                'location' => $request->location,
                'time' => $request->time,
                'description' => $request->description,
                'user_id' => $request->user_id
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
