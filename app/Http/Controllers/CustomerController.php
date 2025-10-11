<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $obj = Customer::all();
            return $this->successResponseWithData(
                $obj,
                "Cliente obtenido con éxito"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Cliente no obtenida, ocurrió un error',
                500,
                $e->getMessage()
            );
        }
    }
    public function show($id)
    {
        try {
            $obj = Customer::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Cliente obtenido correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener al Cliente',
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
                'phone' => 'nullable|string|max:1000',
                'email' => 'nullable|string|max:200',
                'address' => 'nullable|string|max:200',
                'city' => 'nullable|string|max:200',
            ]);

            $obj = Customer::create($validateData);
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
                'name' => 'required|string|max:255',
                'phone' => 'sometimes|string|max:1000',
                'email' => 'sometimes|string|max:200',
                'address' => 'sometimes|string|max:200',
                'city' => 'sometimes|string|max:200',
            ]);

            $obj = Customer::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Cliente actualizado correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al actualizar al CLiente',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = Customer::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Cliente eliminada correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al eliminar al Cliente',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Customer::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Clientes encontrados correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrió un error al buscar al Cliente',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}