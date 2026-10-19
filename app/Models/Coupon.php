<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Coupon extends Model
{
    protected $fillable = ['code','discount_type','discount_value','max_uses','used_count','expires_at','is_active'];
    protected function casts(): array { return ['discount_value'=>'decimal:2','expires_at'=>'datetime','is_active'=>'boolean']; }
    public function isValid(): bool {
        return $this->is_active
            && (!$this->expires_at || $this->expires_at->isFuture())
            && (!$this->max_uses || $this->used_count < $this->max_uses);
    }
    public function discountFor(float $subtotal): float {
        $value = $this->discount_type === 'percentage' ? $subtotal * ((float)$this->discount_value / 100) : (float)$this->discount_value;
        return round(min($subtotal, max(0, $value)), 2);
    }
}
