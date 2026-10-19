<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class AdminController extends Controller
{
    public function loginForm() { return view('admin.login'); }
    public function login(Request $request) {
        $data=$request->validate(['email'=>'required|email','password'=>'required|string']);
        if (!Auth::attempt($data) || !Auth::user()->is_admin) { Auth::logout(); return back()->withErrors(['email'=>'Invalid admin credentials.']); }
        $request->session()->regenerate();
        return redirect()->route('admin.index');
    }
    public function logout(Request $request) { Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('admin.login'); }
    public function index() {
        $stats=['sales'=>Order::where('payment_status','paid')->sum('total_price'),'pending'=>Order::where('order_status','pending')->count(),'processing'=>Order::where('order_status','processing')->count(),'completed'=>Order::where('order_status','completed')->count()];
        $orders=Order::with('package')->latest()->paginate(20);
        return view('admin.index',compact('stats','orders'));
    }
    public function updateOrder(Request $request, Order $order) {
        $data=$request->validate(['order_status'=>['required',Rule::in(['pending','processing','completed','cancelled','refunded'])],'payment_status'=>['required',Rule::in(['pending','paid','failed','refunded'])],'admin_note'=>'nullable|string|max:1000']);
        // Deliberately separate order and payment status. Only set payment_status=paid after checking the provider's verified transaction.
        if ($data['payment_status']==='paid' && $order->payment_status!=='paid') return back()->withErrors(['payment_status'=>'Verify the payment transaction before marking an order paid.']);
        $order->update($data);
        return back()->with('success','Order updated.');
    }
}
