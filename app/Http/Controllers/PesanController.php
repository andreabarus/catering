<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pesanan;
use App\Models\User;
use Auth;

use App\Models\PesananDetail;
use Carbon\Carbon;

class PesanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();

        return view('pesan',compact('produk'));
    }

    public function pesan(Request $request, $id)
    {
        $produk = Produk::where('id', $id)->first();
        $tanggal = Carbon::now();

        if ($request->jumlah_pesan > $produk->stok)
        {
            return redirect('pesan/'.$id);
        }

        $cek_pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        if (empty($cek_pesanan)) {
            $pesanan = new Pesanan;
            $pesanan->user_id = Auth::user()->id;
            $pesanan->tanggal = $tanggal;
            $pesanan->status = 0;
            $pesanan->jumlah_harga = 0;
            $pesanan->code = mt_rand(100, 999);
            $pesanan->save();
        }
          // simpan ke database pesanan_detail
          $pesanan_baru = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();

          //cek pesanan detail
          $cek_pesanan_detail = PesananDetail::where('produk_id', $produk->id)->where('pesanan_id', $pesanan_baru->id)->first();
          if (empty($cek_pesanan_detail)) 
          {
              $pesanan_detail = new PesananDetail;
              $pesanan_detail->produk_id =$produk->id;
              $pesanan_detail->pesanan_id =$pesanan_baru->id;
              $pesanan_detail->jumlah =$request->jumlah_pesan;
              $pesanan_detail->jumlah_harga =$produk->harga * $request->jumlah_pesan;
              $pesanan_detail->save();
          }else{
              $pesanan_detail = PesananDetail::where('pesanan_id', $pesanan_baru->id)->first();
              $pesanan_detail->jumlah = $pesanan_detail->jumlah+$request->jumlah_pesan;
  
              //harga sekarang
              $harga_pesanan_detail_baru = $produk->harga * $request->jumlah_pesan;
              $pesanan_detail->jumlah_harga = $pesanan_detail->jumlah_harga + $harga_pesanan_detail_baru;
              $pesanan_detail->update();
          }
  
          //jumlah total
          $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
          $pesanan->jumlah_harga = $pesanan->jumlah_harga+$produk->harga * $request->jumlah_pesan;
          $pesanan->update();
  
          return redirect ('check-out');
      
    }
    public function check_out()
    {
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
 	    $pesanan_details = [];
        if(!empty($pesanan))
        {
            $pesanan_details = PesananDetail::where('pesanan_id', $pesanan->id)->get();

        }  
        // dd($pesanan_detail)
        
        return view('check-out', compact('pesanan', 'pesanan_details'));
    }

    public function delete($id) 
    {
        $pesanan_detail = PesananDetail::where('id', $id)->first(); 
        $pesanan = Pesanan::where('id', $pesanan_detail->pesanan_id)->first();
        $pesanan->jumlah_harga = $pesanan->jumlah_harga-$pesanan_detail->jumlah_harga;
        $pesanan->update();

        $pesanan_detail->delete();

        return redirect ('check-out');
    }

    public function konfirmasi()
    {

        $user = User::where('id',Auth::user()->id)->first();

        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status',0)->first();
        $pesanan_id = $pesanan->id;
        $pesanan->status = 1;
        $pesanan->update();
        $pesanan_details = PesananDetail::where('pesanan_id', $pesanan_id)->get();
        foreach ($pesanan_details as $pesanan_detail) {
            $produk = Produk::where('id', $pesanan_detail->produk_id)->first();
            $produk->stok = $produk->stok-$pesanan_detail->jumlah;
            $produk->update();
        }

        return redirect('home');
    }

}
