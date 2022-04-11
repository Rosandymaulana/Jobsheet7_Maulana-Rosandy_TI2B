<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request('search')) {
            $paginate = Mahasiswa::where(
                'nim',
                'like',
                '%' . request('search') . '%'
            )
                ->orwhere('nim', 'like', '%' . request('search') . '%')
                ->orwhere('nama', 'like', '%' . request('search') . '%')
                ->orwhere('kelas', 'like', '%' . request('search') . '%')
                ->orwhere('jurusan', 'like', '%' . request('search') . '%')
                ->orwhere('Email', 'like', '%' . request('search') . '%')
                ->orwhere('alamat', 'like', '%' . request('search') . '%')
                ->orwhere('Tanggal_lahir', 'like', '%' . request('search') . '%')
                ->orwhere('jurusan', 'like', '%' . request('search') . '%')->paginate(3);
            return view('mahasiswa.index', ['paginate' => $paginate]);
        } else {
            $mahasiswa = Mahasiswa::all(); // Mengambil semua isi tabel
            $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
            return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email'  => 'required',
            'Alamat'  => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        Mahasiswa::create($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        $Mahasiswa = Mahasiswa::where('nim', $Nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        $Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();;
        return view('mahasiswa.edit', compact('Mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email'  => 'required',
            'Alamat'  => 'required',
            'Tanggal_lahir' => 'required',
        ]);

        Mahasiswa::where('nim', $Nim)
            ->update([
                'nim' => $request->Nim,
                'nama' => $request->Nama,
                'kelas' => $request->Kelas,
                'jurusan' => $request->Jurusan,
                'Email'  => $request->Email,
                'Alamat'  => $request->Alamat,
                'Tanggal_lahir' => $request->Tanggal_lahir,
            ]);

        // Mahasiswa::find($Nim)->update($request->all());

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        Mahasiswa::where('nim', $Nim)->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Dihapus');
    }
}
