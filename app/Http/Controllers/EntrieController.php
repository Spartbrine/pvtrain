<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Entrie;
use Illuminate\Http\Request;

class EntrieController extends Controller
{
    public function index()
    {
        try {
            $obj = Entrie::all();
            return $this->successResponseWithData(
                $obj,
                "Entradas obtenidas con éxito"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                "Error al obtener las entradas",
                500,
                $e->getMessage()
            );
        }
    }
    public function show($id)
    {
        try {
            $obj = Entrie::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Entrada obtenida correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener la Entrada',
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
                'product_id' => 'required|int|exists:products,id',
                'provider_id' => 'required|int|extist:providers,id',
                'branch_id' => 'required|int|exists:branches,id',
                'quantity' => 'required|int|min:1',
                'unit_cost' => 'decimal:10,2|nullable',
            ]);

            $obj = Entrie::create($validateData);
            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Cliente creado correctamente',
                'data' => $obj
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al crear al Cliente',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'product_id' => 'sometimes|int|exists:products,id',
                'provider_id' => 'sometimes|int|extist:providers,id',
                'branch_id' => 'sometimes|int|exists:branches,id',
                'quantity' => 'sometimes|int|min:1',
                'unit_cost' => 'decimal:10,2|sometimes',
            ]);

            $obj = Entrie::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Entrada actualizado correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al actualizar la Entrada',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = Entrie::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Entrada eliminada correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al eliminar la Entrada',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Entrie::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Entrada encontrados correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al buscar la Entrada',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}