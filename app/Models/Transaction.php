<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'user_id',
        'product_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that always be appends.
     *
     * @var array
     */
    protected $appends = [
        'product_name',
        'purchased_at'
    ];

    /**
     * Product sold
     */
    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }

    /**
     * User who buys
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

    /**
     * Product's name
     */

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }
    /**
     * Product's purchased at
     */

    public function getPurchasedAtAttribute()
    {
        return $this->product->created_at->format('Y-m-d H:i:s');
    }

}
