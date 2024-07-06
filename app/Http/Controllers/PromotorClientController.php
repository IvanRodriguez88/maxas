<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PromotorDataTable;
use App\DataTables\PromotorClientDataTable;

use App\Http\Requests\PromotorClientRequest;
use App\Models\PromotorClient;

class PromotorClientController extends Controller
{
    public function store(PromotorClientRequest $request)
    {
        $status = true;
		$promotor = null;
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $promotor = PromotorClient::create($params);
            $message = "Promotor creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'promotors');
		}
        return $this->getResponse($status, $message, $promotor);
    }

    public function destroy(PromotorClient $promotor_client)
    {
        $status = true;
        try {
            $promotor_client->delete();
            $message = "Promotor desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'promotors');
        }
        return $this->getResponse($status, $message);
    }
}
