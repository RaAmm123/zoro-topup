<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Order extends Model
{
    protected $fillable = ['order_number','user_id','roblox_username','package_id','coupon_id','subtotal','discount_amount','payment_fee','total_price','payment_status','order_status','customer_contact','admin_note'];
    protected function casts(): array { return ['subtotal'=>'decimal:2','discount_amount'=>'decimal:2','payment_fee'=>'decimal:2','total_price'=>'decimal:2']; }
    protected static function booted(): void {
        static::creating(function (Order $order) {
            $order->order_number ??= 'DT-' . now()->format('ymd') . '-' . strtoupper(Str::random(7));
        });
    }
    public function package() { return $this->belongsTo(Package::class); }
    public function coupon() { return $this->belongsTo(Coupon::class); }
    public function payments() { return $this->hasMany(Payment::class); }
}
