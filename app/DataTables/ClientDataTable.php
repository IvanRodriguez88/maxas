<?php

namespace App\DataTables;

use App\Models\Client;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $datatable = (new EloquentDataTable($query))
        ->setRowId('id')
        ->editColumn('created_at', function($row) {
            return date("d/m/Y H:i", strtotime($row->created_at));
        })
        ->editColumn('updated_at', function($row) {
            return date("d/m/Y H:i", strtotime($row->updated_at));
        })
        ->editColumn('is_active', function($row) {
            if (!$row->is_active) {
                return '<span class="badge badge-danger mb-2 me-4">No</span>';
            }
            return '<span class="badge badge-success mb-2 me-4">Sí</span>';
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Client $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Client $model): QueryBuilder
    {
        return $model->select(
            'clients.*',
            'client_types.name as client_type_id',
            'users.email as email',
		)
		->leftjoin('client_types', 'clients.client_type_id', '=', 'client_types.id')
        ->leftjoin('users', 'clients.user_id', '=', 'users.id')
		->newQuery();
    }

    public function getActions($row){
        $result = null;
        if (auth()->user()->hasPermissions("clients.edit")) {
            $result .= '
                <a title="Editar" href='.route("clients.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("clients.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
                </a>
            ';
        }

        return $result;
	}

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->parameters([
                        'paging' => true,
                        'searching' => true,
                        'info' => true,
                        'responsive' => true,
                        "scrollX"=> true,
                    ])
                    ->setTableId('clients-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, "asc")
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
        ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')
            ->title('Id')
            ->searchable(false)
            ->visible(false),
            Column::make('name')->title("Nombre"),
            Column::make('email')->name("users.email")->title("Correo"),
            Column::make('client_type_id')->name("client_types.name")->title("Tipo de cliente"),
            Column::make('created_at')->searchable(false)->title("Fecha creado"),
            Column::make('updated_at')->searchable(false)->title("Fecha editado"),
            Column::make('is_active')->title("Activo"),
        ];

        if (auth()->user()->hasPermissions("clients.edit") ||
            auth()->user()->hasPermissions("clients.create") ||
            auth()->user()->hasPermissions("clients.destroy")) {
            $columns = array_merge($columns, [
                Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Acciones')
            ]);
        }

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Clients' . date('YmdHis');
    }
}
