<?php
namespace Tests\Feature;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class StoreTest extends TestCase
{
 use RefreshDatabase;
 public function test_store_page_loads(): void { Package::create(['name'=>'80 Robux','robux_amount'=>80,'price'=>0.94,'is_active'=>true]); $this->get('/')->assertOk()->assertSee('Roblox Robux Top-Up')->assertSee('80'); }
 public function test_order_is_created_pending(): void { $p=Package::create(['name'=>'80 Robux','robux_amount'=>80,'price'=>0.94,'is_active'=>true]); $r=$this->postJson('/api/orders',['roblox_username'=>'demo_user','package_id'=>$p->id]); $r->assertCreated()->assertJsonPath('payment_status','pending'); $this->assertDatabaseHas('orders',['roblox_username'=>'demo_user','payment_status'=>'pending']); }
 public function test_invalid_username_is_rejected(): void { $p=Package::create(['name'=>'80 Robux','robux_amount'=>80,'price'=>0.94,'is_active'=>true]); $this->postJson('/api/orders',['roblox_username'=>'bad username!','package_id'=>$p->id])->assertUnprocessable(); }
}
