<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'transactions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Transactions of the user (purchases)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    /**
     * Quantity of user transactions (purchases)
     */
    public function getTransactionsCount()
    {
        return $this->transactions()->count();
    }

    /**
     * Products that user sells
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    /**
     * Quantity of products sold by the user
     */
    public function getProductsCount()
    {
        return $this->products()->count();
    }
}
