<?php

namespace App\Http\Controllers;

use App\Services\Category\CategoryStoreService;
use App\Http\Requests\CategoryStoreRequest;
use App\Services\Category\CategoryIndexService;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categoryIndexService = new CategoryIndexService();

        try {
            $obj = $categoryIndexService->execute($request->all());

            return $this->successResponseWithData(
                $obj,
                "Categoría obtenida con éxito"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Categoría no obtenida, ocurrió un error',
                500,
                $e->getMessage()
            );
        }
    }

    public function show($id)
    {
        try {
            $obj = Category::findOrFail($id);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Categoria obtenida correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Ocurrió un error al obtener la Categoria',
                'data' => null,
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function store(CategoryStoreRequest $request)
    {
        $storeService = new CategoryStoreService();

        try {
            $data = $request->validated();

            $obj = $storeService->execute($data);

            if ($obj && !$obj->id) {
                return $this->errorResponseWithMessage(
                    'Ocurrió un error al crear la Categoría',
                    500,
                    null
                );
            }

            return $this->successResponseWithData(
                $obj,
                "Categoría creada con éxito",
                201
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrió un error al crear la Categoría',
                500,
                $e->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validateData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:1000',
            ]);

            $obj = Category::findOrFail($id);
            $obj->update($validateData);
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Categoría actualizada correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al actualizar la Categoría',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }

    }
    public function destroy($id)
    {
        try {
            $obj = Category::findOrFail($id);
            $obj->delete();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Categoría eliminada correctamente',
                'data' => null
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al eliminar la Categoría',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search($name)
    {
        try {
            $obj = Category::where('name', 'like', '%' . $name . '%')->get();
            //$obj=Category::where('name', 'like', '%' . $name . '%')->first();
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Categorías encontradas correctamente',
                'data' => $obj
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Ocurrio un error al buscar la Categoría',
                'data' => null,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
