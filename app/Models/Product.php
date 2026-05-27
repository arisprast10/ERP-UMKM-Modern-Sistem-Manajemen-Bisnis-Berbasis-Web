<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['barcode', 'name', 'category_id', 'buy_price', 'sell_price', 'stock', 'min_stock', 'image', 'is_active', 'description'];
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function transactionItems() {
        return $this->hasMany(TransactionItem::class);
    }

    public function stockHistories() {
        return $this->hasMany(StockHistory::class);
    }
}
