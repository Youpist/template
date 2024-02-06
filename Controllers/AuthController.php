<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function regist()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]
        );
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == 'customer') {
                return redirect()->route('siswa.index');
            } elseif (Auth::user()->role == 'kantin') {
                return redirect()->route('kantin.index');
            } elseif (Auth::user()->role == 'bank') {
                return redirect()->route('bank.index');
            }
        } else {
            return back()->with('error', 'Email atau password salah');
        }
    }
    function register(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:6'
            ],
        );

        $inforegister = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'customer',
        ];


        $userRegist = User::create($inforegister);
        $rek = '18' . auth()->id() . now()->format('YmdHis');
        $wallet = Wallet::create([
            'id_user' => $userRegist->id,
            'rekening' => $rek,
            'saldo' => 0,
            'status' => 'aktif',
        ]);
        // membuat inforegister


        // data yang dimasukan di register dikirim ke email yang terdaftar

        return redirect()->route('login')->with('success', 'Berhasil register');
    }
    function logout()
    {
        Auth::logout();
        return redirect('');
    }
}
