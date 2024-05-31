<?php

namespace App\Http\Controllers;

use App\Models\detail_barang;
use App\Models\detail_transaksi;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function konfirmasi_pesanan(Request $request)
    {
        $title=' Data Pesanan Belum terkonfirmasi';
        $keyword = $request->search;
        // $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = transaksi::with('pelanggan')
        ->where('status_konfirmasi', 'belum_terkonfirmasi') // atau '0', tergantung nilai yang digunakan di database
        ->where(function ($query) use ($keyword) {
            $query->where('tanggal_sewa', 'like', '%' . $keyword . '%')
                ->orWhere('tanggal_akhir', 'like', '%' . $keyword . '%')
                ->orWhere('durasi', 'like', '%' . $keyword . '%')
                ->orWhere('bayar', 'like', '%' . $keyword . '%')
                ->orWhere('kurang_bayar', 'like', '%' . $keyword . '%')
                ->orWhere('total_harga', 'like', '%' . $keyword . '%')
                ->orWhere('tanggal_kembali', 'like', '%' . $keyword . '%')
                ->orWhereHas('pelanggan', function ($query) use ($keyword) {
                    $query->where('nama', 'like', '%' . $keyword . '%');
                });
        })
        ->paginate($limit);
    
    

        $offset = ($data->currentPage() - 1) * $data->perPage();
        // dd($data);
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('transaksi.konfirmasi_pesanan', compact('data', 'offset','title'));
        
        
    }


    public function update_konfirmasi(Request $request) {

        $validator = Validator::make($request->all(), [
            'status_konfirmasi' => 'required|in:sudah_terkonfirmasi,tidak_terkonfirmasi',
        ], [
            'status_konfirmasi.required' => 'Status konfirmasi wajib diisi.',
            'status_konfirmasi.in' => 'Status konfirmasi tidak valid.',
        ]);
    
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            Alert::error($messages)->flash();
            return back()->withErrors($validator)->withInput();
        }
        $transaksi=transaksi::findOrFail($request->id);
        $detail_transaksi=detail_transaksi::where('id_transkasi',$request->id)->get();
        if ($request->status_konfirmasi == "tidak_terkonfirmasi") {
            foreach ($detail_transaksi as $item) {
                $detail_barang=detail_barang::with('barang')->where('id',$item->id_detailbarang)->first();
                $detail_barangg=detail_barang::find($item->id_detailbarang);
                $stok=$detail_barang->stok;
                
                // dump($stok);
                $pengurangan=$stok+$item->qty;
                // dump($pengurangan);
            $detail_barangg->stok=$pengurangan;
            $detail_barangg->save();
    
                
            }
        }
       

        $transaksi->status_konfirmasi=$request->status_konfirmasi;
        $transaksi->save();
        Alert::success('Data Berhasil Dikonfirmasix')->flash();
        return back();

    }

    public function detail_konfirmasi_pesanan($id){
        $title='Detail Konfirmasi Pesanan';
        $data=detail_transaksi::with('detail_barang')->where('id_transkasi',$id)->get();

        return view('transaksi.detail_konfirmasi_pesanan',compact('data','title'));
        
        
    }
    public function detail_konfirmasi_barang($id){
        $title='Detail Konfirmasi Pesanan';
        $data=detail_transaksi::with('detail_barang')->where('id_transkasi',$id)->get();

        return view('transaksi.detail_konfirmasi_barang',compact('data','title'));
        
        
    }



    public function pembayaran_pesanan(Request $request){
        $title=' Data Pesanan Belum terkonfirmasi';
        $keyword = $request->search;
        // $jenis_barang = JenisBarang::all();
        $limit = $request->limit ?? 30;
        $data = transaksi::with('pelanggan')
        ->where('status_konfirmasi', 'sudah_terkonfirmasi') // atau '0', tergantung nilai yang digunakan di database
        ->where('status_pengembalian', 'belum') // atau '0', tergantung nilai yang digunakan di database
        ->where(function ($query) use ($keyword) {
            $query->where('tanggal_sewa', 'like', '%' . $keyword . '%')
                ->orWhere('tanggal_akhir', 'like', '%' . $keyword . '%')
                ->orWhere('durasi', 'like', '%' . $keyword . '%')
                ->orWhere('bayar', 'like', '%' . $keyword . '%')
                ->orWhere('kurang_bayar', 'like', '%' . $keyword . '%')
                ->orWhere('total_harga', 'like', '%' . $keyword . '%')
                ->orWhere('tanggal_kembali', 'like', '%' . $keyword . '%')
                ->orWhereHas('pelanggan', function ($query) use ($keyword) {
                    $query->where('nama', 'like', '%' . $keyword . '%');
                });
        })
        ->paginate($limit);
    
    

        $offset = ($data->currentPage() - 1) * $data->perPage();
        // dd($data);
        // return view('Kategoribarang.index', compact('data', 'offset'));
        return view('transaksi.pembayaran_pesanan', compact('data', 'offset','title'));
    }

}
