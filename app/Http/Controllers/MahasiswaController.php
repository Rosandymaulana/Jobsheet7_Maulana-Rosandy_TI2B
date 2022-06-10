<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\fileExists;

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
            $mahasiswa = Mahasiswa::with('kelas')->get(); // Mengambil semua isi tabel
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
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas' => $kelas]);
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

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->Jurusan = $request->get('Jurusan');
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Alamat = $request->get('Alamat');
        $mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');

        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        }

        $mahasiswa->image = $image_name;

        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambah data baru dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
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
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemnukan berdasarkan NIM Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
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

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->image = $request->get('image');
        $mahasiswa->Jurusan = $request->get('Jurusan');
        if ($mahasiswa->image && fileExists(storage_path('app/public' . $mahasiswa->image))) {
            Storage::delete('public/' . $mahasiswa->image);
        }
        $mahasiswa->Email = $request->get('Email');
        $mahasiswa->Alamat = $request->get('Alamat');
        $mahasiswa->Tanggal_lahir = $request->get('Tanggal_lahir');

        $image_name = $request->file('image')->store('images', 'public');
        $mahasiswa->image = $image_name;

        // Mahasiswa::find($Nim)->update($request->all());

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk mengupdate data baru dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
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

    public function nilai($nim)
    {
        $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
        $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs->id_mahasiswa))->get();
        // $matkul = Mahasiswa_Matakuliah::where('matakuliah_id', ($mhs -> id_mahasiswa))->first();
        return view('mahasiswa.nilai', ['mahasiswa' => $mhs, 'matakuliah' => $matkul]);
    }

    public function downloadpdf($nim)
    {
        $mhs = Mahasiswa::with('kelas')->where("nim", $nim)->first();
        $matkul = Mahasiswa_Matakuliah::with("matakuliah")->where("mahasiswa_id", ($mhs->id_mahasiswa))->get();
        // $matkul = Mahasiswa_Matakuliah::where('matakuliah_id', ($mhs -> id_mahasiswa))->first();
        $pdf = PDF::loadview('mahasiswa.cetak', ['mahasiswa' => $mhs, 'matakuliah' => $matkul])->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream();
    }
}
