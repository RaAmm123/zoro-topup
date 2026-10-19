<?php
namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AdminCouponController extends Controller
{
    public function index(){ $coupons=Coupon::latest()->paginate(20); return view('admin.coupons.index',compact('coupons')); }
    public function create(){ return view('admin.coupons.form',['coupon'=>new Coupon]); }
    public function store(Request $request){ Coupon::create($this->validated($request)); return redirect()->route('admin.coupons.index')->with('success','Coupon created.'); }
    public function edit(Coupon $coupon){ return view('admin.coupons.form',compact('coupon')); }
    public function update(Request $request,Coupon $coupon){ $coupon->update($this->validated($request,$coupon)); return redirect()->route('admin.coupons.index')->with('success','Coupon updated.'); }
    public function destroy(Coupon $coupon){ $coupon->delete(); return back()->with('success','Coupon deleted.'); }
    private function validated(Request $request, ?Coupon $coupon=null): array {
        return $request->validate(['code'=>['required','string','max:50',Rule::unique('coupons','code')->ignore($coupon?->id)],'discount_type'=>['required',Rule::in(['percentage','fixed'])],'discount_value'=>'required|numeric|min:0.01|max:100000','max_uses'=>'nullable|integer|min:1','expires_at'=>'nullable|date','is_active'=>'nullable|boolean']);
    }
}
