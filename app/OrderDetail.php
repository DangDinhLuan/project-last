<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_price',
        'order_id' ,
        'size_id',
        'quantity',
    ];

    protected $table = 'order_details';

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class)->withTrashed()->withPivot('topping_price');
    }

    public function size()
    {
        return $this->belongsTo(Size::class)->withTrashed();
    }
}
