<?php

namespace App\DataTables;

use App\Models\ReturnRequest;
use App\Models\Client;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClientReturnRequestDataTable extends DataTable
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
        })
        ->editColumn('date', function($row) {
            return date("d/m/Y H:i:s", strtotime($row->date));
        })
        ->editColumn('total_return', function($row) {
            return "$ ".number_format($row->total_return, 2, '.', ',');
        });
     

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active"]);

        $datatable->filter(function($query) {
            if(request('initial_date') !== null){
				$query->whereDate('return_requests.date', '>=', request('initial_date'));
			}

            if(request('final_date') !== null){
				$query->whereDate('return_requests.date', '<=', request('final_date'));
			}

            if(request('return_request_status_id') !== null){
				$query->where('return_requests.return_request_status_id', request('return_request_status_id'));
			}
           
		}, true);


        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReturnRequest $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReturnRequest $model): QueryBuilder
    {
        //Obtener clientId
        $client = Client::where("user_id", auth()->user()->id)->first();
        return $model->select(
		    'return_requests.*',
		)
        ->where("return_requests.created_by", auth()->user()->id)
        ->orderBy("return_requests.id", "desc")
		->newQuery();
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
                ->setTableId('client_return_requests-table')
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

    public function getActions($row){
        $result = null;
        if (auth()->user()->hasPermissions("return_requests.show")) {
            $result .= '
                <a title="Ver" href='.route("return_request_invoices.index", $row->id).' class="btn btn-outline-dark btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>                    
                </a>
            ';
        }
        return $result;
	}

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        $columns = [
            Column::make('id')->title('# Sol.'),

            Column::make('total_return')->title("Total a retornar"),
            Column::make('created_at')->title("Fecha creado"),
            // Column::make('updated_at')->title("Fecha editado"),
            // Column::make('is_active')->title("Activo"),
        ];

        if (auth()->user()->hasPermissions("return_requests.edit") ||
            auth()->user()->hasPermissions("return_requests.create") ||
            auth()->user()->hasPermissions("return_requests.destroy")) {
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
        return 'ClientReturnRequests_' . date('YmdHis');
    }
}
