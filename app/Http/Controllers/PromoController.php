<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Apply a promo code to the cart session.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = strtoupper($request->code);
        $promo = PromoCode::where('code', $code)->first();

        if (!$promo) {
            return redirect()->back()->with('error', 'Kode promo tidak valid!');
        }

        if (!$promo->isValid()) {
            return redirect()->back()->with('error', 'Kode promo ini sudah kadaluarsa atau kuota habis!');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['total'];
        }

        if ($subtotal < $promo->min_purchase) {
            return redirect()->back()->with('error', 'Minimal pembelian untuk menggunakan kode ini adalah Rp ' . number_format($promo->min_purchase, 0, ',', '.'));
        }

        // Save promo details to session
        session()->put('promo', [
            'id' => $promo->id,
            'code' => $promo->code,
            'discount_type' => $promo->discount_type,
            'discount_value' => $promo->discount_value,
            'max_discount' => $promo->max_discount,
            'min_purchase' => $promo->min_purchase,
        ]);

        return redirect()->back()->with('success', 'Kode promo berhasil digunakan!');
    }

    /**
     * Remove the active promo code from session.
     */
    public function remove()
    {
        session()->forget('promo');
        return redirect()->back()->with('success', 'Kode promo dihapus!');
    }
}
