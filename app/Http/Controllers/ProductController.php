<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Listar productos con su categoría
    public function index()
    {
        try {
            $obj = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as category_name')
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'id' => $item->id,
                        'name' => $item->name,
                        'description' => $item->description,
                        'price' => $item->price,
                        'category' => [
                            'id' => $item->category_id,
                            'name' => $item->category_name
                        ]
                    ];
                });

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Productos obtenidos con éxito',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Mostrar un producto
    public function show($id)
    {
        try {
            $obj = Product::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto obtenido correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Producto no encontrado',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // Crear un producto
    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'nullable|string|max:255',
                'barcode' => 'nullable|string|max:255',
                'image_url' => 'nullable|string|max:200',
                'description' => 'nullable|string|max:1000',
                'price' => 'required|numeric|between:0,99999999.99',
                'min_stock' => 'nullable|integer|min:1',
                'category_id' => 'required|exists:categories,id',
                'status' => 'nullable|string|max:255',
            ]);

            $obj = Product::create($validateData);

            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Producto creado correctamente',
                'data' => $obj
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error al crear el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Actualizar producto
    public function update(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'sku' => 'sometimes|string|max:255',
                'barcode' => 'sometimes|string|max:255',
                'image_url' => 'sometimes|string|max:200',
                'description' => 'sometimes|string|max:1000',
                'price' => 'sometimes|numeric|between:0,99999999.99',
                'min_stock' => 'sometimes|integer|min:1',
                'category_id' => 'sometimes|exists:categories,id',
                'status' => 'sometimes|string|max:255',
            ]);

            $obj = Product::findOrFail($id);
            $obj->update($validateData);

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Eliminar producto
    public function destroy($id)
    {
        try {
            $obj = Product::findOrFail($id);
            $obj->delete();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto eliminado correctamente'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Buscar producto por nombre
    public function search($name)
    {
        try {
            $obj = Product::where('name', 'like', '%' . $name . '%')->get();

            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Productos encontrados correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Error al buscar productos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
