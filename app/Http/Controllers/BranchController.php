<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        try {
            $obj = Branch::all();
            return $this->successResponseWithData(
                $obj,
                "Sucursales obtenidas con éxito"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Sucursales no obtenidas, ocurrió un error',
                500,
                $e->getMessage()
            );


        }
    }

    public function show($id)
    {
        try {
            $obj = Branch::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Sucursal obtenida correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener la Sucursal',
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
                'location' => 'nullable|string|max:1000',
                'status' => 'nullable|string|max:200',
            ]);

            $obj = Branch::create($validateData);
            return response()->json([
                'status' => 201,
                'success' => true,
                'message' => 'Sucursal creada correctamente',
                'data' => $obj
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al crear la Sucursal',
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
                'description' => 'nullable|string|max:1000',
            ]);

            $obj = Branch::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Sucursal actualizada correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al actualizar la Sucursal',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = Branch::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Sucursal eliminada correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al eliminar la Sucursal',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Branch::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Sucursales encontradas correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al buscar la Sucursal',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}