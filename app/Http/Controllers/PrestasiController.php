<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriPrestasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PrestasiController extends Controller
{
    //
    public function index(Request $req)
	{
        $data = Prestasi::where(function($q) use ($req){
            $q->where('prestasi_judul', 'like', '%'.$req->cari.'%');
        })->paginate(10);
        $data->appends([$req->cari]);
        return view('pages.prestasi.index', [
            'data' => $data,
            'i' => ($req->input('page', 1) - 1) * 10,
            'cari' => $req->cari,
        ]);
    }

	public function tambah(Request $req)
	{
        return view('pages.prestasi.form', [
            'back' => Str::contains(url()->previous(), ['prestasi/tambah', 'prestasi/edit'])? '/prestasi': url()->previous(),
            'aksi' => 'Tambah',
            'kategori' => ['Nasional', 'Provinsi', 'Kabupaten/Kota']
        ]);
    }

	public function simpan(Request $req)
	{
        $req->validate([
            'prestasi_judul' => 'required'
        ]);

        try{
            $file = $req->file('prestasi_gambar');

            $ext = $file->getClientOriginalExtension();
            $nama_file = time().Str::random().".".$ext;
            $file->move(public_path('uploads/prestasi'), $nama_file);

            $data = new Prestasi();
            $data->prestasi_judul = $req->get('prestasi_judul');
            $data->prestasi_kategori = $req->get('prestasi_kategori');
            $data->prestasi_gambar = '/uploads/prestasi/'.$nama_file;
            $data->save();
            return redirect($req->get('redirect')? $req->get('redirect'): 'prestasi');
		}catch(\Exception $e){
            return redirect()->back()->withInput()->withErrors('Gagal Menyimpan Data. '.$e->getMessage());
        }
    }

	public function hapus(Request $req)
	{
		try{
            $data = Prestasi::findOrFail($req->get('id'));
            File::delete(public_path($data->prestasi_gambar));
            $data->delete();
		}catch(\Exception $e){
            return redirect()->back()->withInput()->withErrors('Gagal Menghapus Data. '.$e->getMessage());
		}
	}
}