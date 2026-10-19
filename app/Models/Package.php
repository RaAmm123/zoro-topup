<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Package extends Model
{
    protected $fillable = ['name','robux_amount','price','discount_percent','description','is_active','sort_order'];
    protected function casts(): array { return ['price'=>'decimal:2','discount_percent'=>'integer','is_active'=>'boolean']; }
    public function orders() { return $this->hasMany(Order::class); }
}
