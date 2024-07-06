<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\GroupDataTable;
use App\Http\Requests\GroupRequest;
use App\Models\Group;

class GroupController extends Controller
{
    public function index(GroupDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("groups.create");
        return $dataTable->render('groups.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(GroupRequest $request)
    {
        $status = true;
		$group = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $group = Group::create($params);
            $message = "Group creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'groups');
		}
        return $this->getResponse($status, $message, $group);
    }

    
    public function edit(Group $group)
    {
        return view('groups.edit', compact("group"));
    }

    
    public function update(GroupRequest $request, Group $group)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $group->update($params);
            $message = "Group modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'groups');
        }
        return $this->getResponse($status, $message, $group);
    
    }

    public function destroy(Group $group)
    {
        $status = true;
        try {
            $group->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Group desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'groups');
        }
        return $this->getResponse($status, $message);
    }
}
