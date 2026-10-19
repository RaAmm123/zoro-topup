<?php
namespace Database\Seeders;
use App\Models\Coupon; use App\Models\Package; use App\Models\User; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
 public function run(): void {
  foreach ([['80 Robux',80,0.94,6],['500 Robux',500,4.55,9],['1,000 Robux',1000,9.10,9],['2,000 Robux',2000,18.20,9],['5,000 Robux',5000,45.50,9],['10,000 Robux',10000,91.00,9]] as $i=>$p) Package::updateOrCreate(['robux_amount'=>$p[1]],['name'=>$p[0],'price'=>$p[2],'discount_percent'=>$p[3],'is_active'=>true,'sort_order'=>$i]);
  Coupon::firstOrCreate(['code'=>'WELCOME5'],['discount_type'=>'percentage','discount_value'=>5,'max_uses'=>100,'used_count'=>0,'is_active'=>true]);
  if (env('SEED_ADMIN_EMAIL') && env('SEED_ADMIN_PASSWORD')) User::firstOrCreate(['email'=>env('SEED_ADMIN_EMAIL')],['name'=>'Store Admin','password'=>Hash::make(env('SEED_ADMIN_PASSWORD')),'is_admin'=>true]);
 }
}
