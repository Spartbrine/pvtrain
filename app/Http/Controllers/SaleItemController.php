<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    public function index()
    {
        try {
            $obj = SaleItem::all();
            return $this->successResponseWithData(
                $obj,
                "Artículo de venta obtenida con éxito"
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Artículo de venta, ocurrió un error',
                500,
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $obj = SaleItem::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto de venta obtenido correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener el Producto de venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'product_id' => 'required|int',
                'quantity' => 'required|int|min:1',
                'price_unit' => 'decimal:10,2',
                'total_price' => 'decimal:10,2',
            ]);

            $obj = SaleItem::create($validateData);
            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Producto de venta creado correctamente',
                'data' => $obj
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al crear la Venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|string|max:255',
                'product_id' => 'required|int',
                'quantity' => 'required|int|min:1',
                'price_unit' => 'decimal:10,2',
                'total_price' => 'decimal:10,2',
            ]);

            $obj = SaleItem::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto de venta actualizado correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al actualizar la Venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = SaleItem::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Producto de venta eliminado correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el Producto de venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = SaleItem::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Venta encontrada correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al buscar el Producto de venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
