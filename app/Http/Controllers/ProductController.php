<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductBuyRequest;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Index of products
     *
     * Return list of products in stock
     *
     */

    public function index(Request $request)
    {
        return $this->showOne(
            Product::inStock()
                ->name($request->name)
                ->get()
        );
    }
    /**
     * Show products
     *
     * Store a single product
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    /**
     * Store products
     *
     * Store a single product
     */
    public function store(ProductRequest $request)
    {
        $user_id = $request->user()->id;

        $product = new Product($request->all());
        $product->user_id = $user_id;
        if($product->save()){
            return $this->showOne([
                'message' => 'Registro del producto exitoso'
            ]);
        }
        return $this->showError('Error al guardar el producto', [], 400);
    }

    public function buy(Product $product, ProductBuyRequest $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->user()->id;
            $product->transactions()->create([
                'user_id' => $user_id,
                'quantity' => $request->quantity,
            ]);
            $product->quantity -= $request->quantity;
            if($product->update()){
                DB::commit();
                return $this->showOne([
                    'message' => 'Compra del producto exitoso'
                ]);
            }

            DB::rollback();
            return $this->showError('Error al comprar el producto', [], 400);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->showError('Error al comprar el producto', [], 400);
        }


    }
}
