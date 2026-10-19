<?php
namespace App\Http\Controllers;
use App\Models\Package;
use Illuminate\Http\Request;
class AdminPackageController extends Controller
{
    public function index(){ $packages=Package::orderBy('sort_order')->paginate(20); return view('admin.packages.index',compact('packages')); }
    public function create(){ return view('admin.packages.form',['package'=>new Package]); }
    public function store(Request $request){ $data=$this->validated($request); Package::create($data); return redirect()->route('admin.packages.index')->with('success','Package created.'); }
    public function edit(Package $package){ return view('admin.packages.form',compact('package')); }
    public function update(Request $request,Package $package){ $package->update($this->validated($request)); return redirect()->route('admin.packages.index')->with('success','Package updated.'); }
    public function destroy(Package $package){ if($package->orders()->exists()) return back()->withErrors(['package'=>'Package has orders and cannot be deleted. Deactivate it instead.']); $package->delete(); return back()->with('success','Package deleted.'); }
    private function validated(Request $request): array { return $request->validate(['name'=>'required|string|max:100','robux_amount'=>'required|integer|min:1','price'=>'required|numeric|min:0|max:999999','discount_percent'=>'nullable|integer|min:0|max:100','description'=>'nullable|string|max:255','is_active'=>'nullable|boolean','sort_order'=>'nullable|integer|min:0']); }
}
