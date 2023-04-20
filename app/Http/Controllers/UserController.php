<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => User::where('role', '=', 'User')
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
            'username' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'date_of_birth' => 'required|before:date',
            'ktp' => 'required|numeric',
            'phone' => 'required|numeric',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal membuat akun, terdapat kesalahan pada data Anda.'
            ]);
        }

        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'ktp' => $request->ktp,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }
    
    /**
     * User Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal masuk ke akun, terdapat kolom yang belum Anda isi.',
                'data' => ''
            ]);
        }

        $user = User::where("username", "=", $request->username)->first();

        $token = $user->createToken($request->username, ['user'])->plainTextToken;

        if (!(User::where("username", "=", $request->username)->exists())) {
            return response()->json([
                'status' => 500,
                'message' => 'Akun tidak terdaftar.',
                'data' => ''
            ]);
        } else if ($user->status == '0') {
            return response()->json([
                'status' => 500,
                'message' => 'Akun Anda terblokir.',
                'data' => ''
            ]);
        } else {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil masuk ke akun.',
                    'user' => [
                        'token' => $token,
                        'user_id' => $user->id,
                        'role' => $user->role
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Password tidak sesuai.',
                    'data' => ''
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => User::findOrFail($request->user_id)->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_of_birth' => 'required|before:date',
            'ktp' => 'required|numeric',
            'phone' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Gagal membuat akun, terdapat kesalahan pada data Anda.'
            ]);
        }

        $user = User::findOrFail($request->user_id)->first();

        if ($user == null) {
            return response()->json([
                'status' => 500,
                'message' => 'Akun Anda tidak ditemukan.',
                'data' => ''
            ]);
        }

        $user->update([
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'ktp' => $request->ktp,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }
    
    /**
     * Change users status
     */
    public function changeUserStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'status' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'Gagal mengubah status User, terdapat kekurangan data.'
            ]);
        }

        $user = User::findOrFail($request->user_id)->first();

        if ($user == null) {
            return response()->json([
                'status' => 500,
                'message' => 'User tidak ditemukan.',
                'data' => ''
            ]);
        }
        
        $user->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => ''
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
