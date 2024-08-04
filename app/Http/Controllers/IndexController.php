<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use App\Models\riwayat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function login(Request $request)
    {
        $form = [
            'nim' => $request->nim,
            'password' => $request->password
        ];
        if (Auth::attempt($form)) {
            $cookie = cookie('nim', $request->nim, 100000);
            return Response(redirect("/"))->cookie($cookie);
        } else {
            return redirect("login");
        }

    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('welcome');
        } else {
            return redirect('/login');
        }
    }

    public function jadwal()
    {
        if (Auth::check()) {
            return view("jadwal", ["riwayats" => riwayat::all()]);
        } else {
            return redirect('/login');
        }
    }

    public function absen()
    {
        if (Auth::check()) {
            return view('absen');
        } else {
            return redirect('/login');
        }
    }

    public function profil()
    {
        if (Auth::check()) {
            $nim = request()->cookie('nim');
            $data = mahasiswa::where("NIM", "like", $nim, "or")->first();
            return view('profil', ['user'=>$data]);
            // dd($data);
        } else {
            return redirect('/login');
        }
    }
}
