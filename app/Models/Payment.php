<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    protected $fillable = ['order_id','provider','provider_transaction_id','amount','currency','status','paid_at','provider_payload'];
    protected function casts(): array { return ['amount'=>'decimal:2','paid_at'=>'datetime','provider_payload'=>'array']; }
    public function order() { return $this->belongsTo(Order::class); }
}
