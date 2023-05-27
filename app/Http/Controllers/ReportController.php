<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getReports()
    {
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ReportResource::collection(Report::all())
        ]);
    }
    
    public function getUserReports(Request $request)
    {
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ReportResource::collection(Report::where('user_id', '=', $request->user_id)->get())
        ]);
    }

    public function getReport(Request $request)
    {
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => new ReportResource(Report::findOrFail($request->report_id)->first())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
            'user_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Laporan gagal dikirim, terdapat kesalahan pada data Anda.',
                'data' => ''
            ]);
        }

        $pictureName = null;

        // $id = 1;

        // if (DB::table('reports')->latest('created_at')->first() != null) {
        //     $id = DB::table('reports')->latest('created_at')->first()->id + 1;
        // }

        if ($request->hasFile('picture')) {
            $pic = $request->file('picture');
            $pictureName = date('mdYHis') . uniqid() . "." . $pic->getClientOriginalExtension();
            $dest = public_path() . "/images/report";
            $pic->move($dest, $pictureName);
        }

        Report::create([
            'title' => $request->title,
            'location' => $request->location,
            'time' => $request->time,
            'description' => $request->description,
            'picture' => $request->picture,
            'user_id' => $request->user_id
        ]);

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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|numeric',
            'title' => 'required',
            'location' => 'required',
            'description' => 'required',
            'time' => 'required|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Laporan gagal diperbarui, terdapat kesalahan pada data Anda.',
                'data' => ''
            ]);
        }

        $report = Report::findOrFail($request->report_id)->first();

        $pictureName = null;

        if ($request->hasFile('picture')) {
            $pic = $request->file('picture');
            $pictureName = date('mdYHis') . uniqid() . "." . $pic->getClientOriginalExtension();
            $dest = public_path() . "/images/report";
            $pic->move($dest, $pictureName);
            
            if ($report->picture != null) {
                if (file_exists('images/report/' . $report->picture)) {
                    unlink('images/report/' . $report->picture);
                }
            }
        }

        if ($pictureName == null) {
            $report->update([
                'title' => $request->title,
                'location' => $request->location,
                'description' => $request->report,
                'time' => $request->time
            ]);
        } else {
            $report->update([
                'title' => $request->title,
                'location' => $request->location,
                'time' => $request->time,
                'description' => $request->report,
                'picture' => $pictureName
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Memproses Report
     */
    public function processReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Status laporan gagal diperbarui, terdapat kesalahan pada data Anda.',
                'data' => ''
            ]);
        }

        $report = Report::findOrFail($request->report_id)->first();

        if ($request->status == 'Menunggu Konfirmasi' || $request->status == 'Diproses' || $request->status == 'Selesai') {
            $report->update([
                'status' => $request->status
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Status laporan gagal diperbarui, terdapat kesalahan pada data Anda.',
                'data' => ''
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
