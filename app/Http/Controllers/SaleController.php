<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        try {
            $obj = Sale::all();
            return $this->successResponseWithData(
                $obj,
                "Venta obtenida con éxito"
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Venta no obtenida, ocurrió un error',
                500,
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $obj = Sale::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Venta obtenida correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener la Venta',
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
                'user_id' => 'required|int|exists:users,id',
                'branch_id' => 'required|int|exists:branches,id',
                'customer_id' => 'required|int|extist:customers,id',
                'payment_type' => 'required|string|max:200',
                'total' => 'decimal:10,2',
                'status' => 'nullable|string|max:255',
            ]);

            $obj = Sale::create($validateData);
            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Venta creado correctamente',
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
                'user_id' => 'required|int|exists:users,id',
                'branch_id' => 'required|int|exists:branches,id',
                'customer_id' => 'required|int|extist:customers,id',
                'payment_type' => 'required|string|max:200',
                'total' => 'decimal:10,2',
                'status' => 'nullable|string|max:255',
            ]);

            $obj = Sale::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Venta actualizado correctamente',
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
            $obj = Sale::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Venta eliminado correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al eliminar la Venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Sale::where('name', 'like', '%' . $name . '%')->get();
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
                'message' => 'Ocurrió un error al buscar la Venta',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}