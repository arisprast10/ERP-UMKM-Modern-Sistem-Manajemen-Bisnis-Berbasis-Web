<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['invoice_no', 'user_id', 'customer_id', 'subtotal', 'discount', 'total', 'payment_method', 'paid_amount', 'change_amount', 'status', 'notes'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function items() {
        return $this->hasMany(TransactionItem::class);
    }
}
