<?php
namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\Package;
use Illuminate\Http\Request;
class StoreController extends Controller
{
    public function index() {
        $packages = Package::where('is_active', true)->orderBy('sort_order')->orderBy('robux_amount')->get();
        return view('store', compact('packages'));
    }
    public function packages() {
        return response()->json(Package::where('is_active', true)->orderBy('sort_order')->orderBy('robux_amount')->get(['id','name','robux_amount','price','discount_percent','description']));
    }
    public function validateCoupon(Request $request) {
        $data = $request->validate(['code'=>'required|string|max:50','package_id'=>'required|integer|exists:packages,id']);
        $package = Package::where('is_active', true)->findOrFail($data['package_id']);
        $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($data['code']))])->first();
        if (!$coupon || !$coupon->isValid()) return response()->json(['message'=>'Coupon is invalid, expired, or fully used.'], 422);
        $discount = $coupon->discountFor((float)$package->price);
        return response()->json(['code'=>$coupon->code,'discount_amount'=>number_format($discount,2,'.',''),'total'=>number_format(max(0,(float)$package->price-$discount),2,'.','')]);
    }
}
