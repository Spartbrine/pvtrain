<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        try {
            $obj = Provider::all();
            return $this->successResponseWithData(
                $obj,
                "Proveedor obtenido con éxito"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Proveedor no obtenido, ocurrió un error',
                500,
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $obj = Provider::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Proveedor obtenido correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener el Proveedor',
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
                'contact_name' => 'nullable|string|max:255',
                'phone' => 'sometimes|string|max:1000',
                'email' => 'sometimes|string|max:200',
                'address' => 'sometimes|string|max:200',
            ]);

            $obj = Provider::create($validateData);
            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Proveedor creado correctamente',
                'data' => $obj
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al crear el Proveedor',
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
                'contact_name' => 'nullable|string|max:255',
                'phone' => 'sometimes|string|max:1000',
                'email' => 'sometimes|string|max:200',
                'address' => 'sometimes|string|max:200',
            ]);

            $obj = Provider::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Proveedor actualizado correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al actualizar el Proveedor',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = Provider::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Proveedor eliminado correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al eliminar el Proveedor',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Provider::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Proveedor encontrados correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al buscar el Proveedor',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
