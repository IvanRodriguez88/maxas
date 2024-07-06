<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CompanyLevelDataTable;
use App\Http\Requests\CompanyLevelRequest;
use App\Models\CompanyLevel;

class CompanyLevelController extends Controller
{
    public function index(CompanyLevelDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("company_levels.create");
        return $dataTable->render('company_levels.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('company_levels.create');
    }

    public function store(CompanyLevelRequest $request)
    {
        $status = true;
		$company_level = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $company_level = CompanyLevel::create($params);
            $message = "Nivel de empresa creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'company_levels');
		}
        return $this->getResponse($status, $message, $company_level);
    }

    
    public function edit(CompanyLevel $company_level)
    {
        return view('company_levels.edit', compact("company_level"));
    }

    
    public function update(CompanyLevelRequest $request, CompanyLevel $company_level)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $company_level->update($params);
            $message = "Nivel de empresa modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'company_levels');
        }
        return $this->getResponse($status, $message, $company_level);
    
    }

    public function destroy(CompanyLevel $company_level)
    {
        $status = true;
        try {
            $company_level->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Nivel de empresa desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'company_levels');
        }
        return $this->getResponse($status, $message);
    }
}
