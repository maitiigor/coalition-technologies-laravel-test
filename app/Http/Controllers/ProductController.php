<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        //
        try {
            //code...
            $products = File::json(base_path('public/database/products.json'), JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            //throw $th;

            $products = [];
        }

        return view('welcome')->with('products', $products);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(CreateProductRequest $request)
    {
        //
        $foruminput = $request->except(['_method', '_token']);
        try {
            //get saved products
            $products = File::json(base_path('public/database/products.json'), JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            //throw $th;

            $products = [];
        }
        $create_time = date("Y-m-d h:iA", time());
        $input['id'] = count($products) + 1;
        $input['name'] = $foruminput['name'];
        $input['price'] = (float) $foruminput['price'];
        $input['quantity'] = (float) $foruminput['quantity'];
        $input['total'] = $foruminput['price'] * $foruminput['quantity'];
        $input['created_at'] = $create_time;
        $input['updated_at'] = $create_time;

        $products[] = $input;

        File::put(base_path('public/database/products.json'), json_encode($products));

        return response()->json($input, 200);
    }

    /**
     * Display the specific product by $id.
     */
    public function show($id)
    {
        //
        
        try {
            //get saved products
            $products = File::json(base_path('public/database/products.json'), JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            //throw $th;

            $products = [];
        }

        $key = array_search($id, array_column($products, 'id'));

        if ($key < 0) {

            return response()->json(["data" => "Product not found", "status", 'success'], 404);
        }

        return response(["data" => $products[$key], 'status' => "success"], 200);
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        //
        $foruminput = $request->except(['_method', '_token']);

        try {
            //get saved products
            $products = File::json(base_path('public/database/products.json'), JSON_THROW_ON_ERROR);
        } catch (\Throwable $th) {
            //throw $th;

            $products = [];
        }

        $key = array_search($id, array_column($products, 'id'));

        if ($key < 0) {

            return response()->json(["data" => "Product not found", "status", 'success'], 404);
        }

        $updated_time = date("Y-m-d h:iA", time());
        $products[$key]['name'] = $foruminput['name'];
        $products[$key]['price'] = (float) $foruminput['price'];
        $products[$key]['quantity'] = (float) $foruminput['quantity'];
        $products[$key]['total'] = $foruminput['price'] * $foruminput['quantity'];
        $products[$key]['updated_at'] = $updated_time;

        File::put(base_path('public/database/products.json'), json_encode($products));

        return response(["data" => $products[$key], 'status' => "success"], 200);

    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
