<?php
namespace App\Http\Controllers;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class OrderController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'roblox_username'=>'required|string|min:3|max:20|regex:/^[A-Za-z0-9_]+$/',
            'package_id'=>'required|integer|exists:packages,id',
            'promo_code'=>'nullable|string|max:50',
            'customer_contact'=>'nullable|string|max:120',
        ]);
        $order = DB::transaction(function () use ($data) {
            $package = Package::where('is_active', true)->lockForUpdate()->findOrFail($data['package_id']);
            $coupon = null; $discount = 0;
            if (!empty($data['promo_code'])) {
                $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper(trim($data['promo_code']))])->lockForUpdate()->first();
                if (!$coupon || !$coupon->isValid()) throw ValidationException::withMessages(['promo_code'=>'Coupon is invalid, expired, or fully used.']);
                $discount = $coupon->discountFor((float)$package->price);
                $coupon->increment('used_count');
            }
            $subtotal = (float)$package->price;
            $order = Order::create([
                'roblox_username'=>$data['roblox_username'], 'package_id'=>$package->id,
                'coupon_id'=>$coupon?->id, 'subtotal'=>$subtotal, 'discount_amount'=>$discount,
                'payment_fee'=>0, 'total_price'=>max(0, $subtotal-$discount),
                'payment_status'=>'pending', 'order_status'=>'pending',
                'customer_contact'=>$data['customer_contact'] ?? null,
            ]);
            Payment::create(['order_id'=>$order->id,'provider'=>'manual_setup_required','amount'=>$order->total_price,'currency'=>'USD','status'=>'pending']);
            return $order;
        });
        // No payment provider is configured by default. This order remains pending until a real provider is integrated.
        if ($request->expectsJson()) return response()->json(['order_number'=>$order->order_number,'status'=>$order->order_status,'payment_status'=>$order->payment_status,'message'=>'Order created. Payment is not configured yet.'], 201);
        return redirect()->route('orders.show', $order->order_number)->with('success','Order created. Follow the displayed instructions; online payment is not configured yet.');
    }
    public function show(string $order_number) {
        $order = Order::with('package')->where('order_number',$order_number)->firstOrFail();
        return view('orders.show', compact('order'));
    }
    public function status(string $order_number) {
        $order = Order::with('package')->where('order_number',$order_number)->firstOrFail();
        return response()->json(['order_number'=>$order->order_number,'package'=>$order->package->name,'robux_amount'=>$order->package->robux_amount,'total_price'=>$order->total_price,'payment_status'=>$order->payment_status,'order_status'=>$order->order_status,'created_at'=>$order->created_at]);
    }
}
