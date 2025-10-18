<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchStoreRequest;
use App\Services\Branch\BranchCreateService;
use App\Services\Branch\BranchDestroyService;
use App\Services\Branch\BranchIndexService;
use App\Services\Branch\BranchSearchService;
use App\Services\Branch\BranchShowService;
use App\Services\Branch\BranchUpdateService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        try {
            $filters = $request->all();
            $branchIndexService = new BranchIndexService();
            $obj = $branchIndexService->execute($filters);

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
            $branchShowService = new BranchShowService();
            $obj = $branchShowService->execute($id);

            return $this->successResponseWithData(
                $obj,
                "Sucursal obtenida correctamente"
            );
        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrió un error al obtener la Sucursal',
                404,
                $e->getMessage()
            );
        }
    }

    public function store(BranchStoreRequest $request)
    {
        try {
            $branchCreateService = new BranchCreateService();
            $obj = $branchCreateService->execute($request->validated());

            return $this->successResponseWithData(
                $obj,
                "Sucursal creada correctamente",
                201
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrio un error al crear la Sucursal',
                500,
                $e->getMessage()
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $branchUpdateService = new BranchUpdateService();
            $obj = $branchUpdateService->execute($id, $data);

            return $this->successResponseWithData(
                $obj,
                "Sucursal actualizada correctamente"
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrio un error al actualizar la Sucursal',
                500,
                $e->getMessage()
            );
        }
    }

    public function destroy($id)
    {
        try {
            $branchDestroyService = new BranchDestroyService();
            $branchDestroyService->execute($id);

            return $this->successResponseSimple(
                "Sucursal eliminada correctamente"
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrio un error al eliminar la Sucursal',
                500,
                $e->getMessage()
            );
        }
    }

    public function search($name)
    {
        try {
            $branchSearchService = new BranchSearchService();
            $obj = $branchSearchService->execute($name);

            return $this->successResponseWithData(
                $obj,
                "Sucursales encontradas correctamente"
            );

        } catch (\Exception $e) {
            return $this->errorResponseWithMessage(
                'Ocurrio un error al buscar la Sucursal',
                500,
                $e->getMessage()
            );
        }
    }
}