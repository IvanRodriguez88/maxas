<?php

namespace App\DataTables;

use App\Models\ReturnRequestConcept;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;

class ReturnRequestConceptDataTable extends DataTable
{
    public function __construct($return_request_invoice_id)
	{
		$this->return_request_invoice_id = $return_request_invoice_id;
	}

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
        ->editColumn('unit_price', function($row) {
            return "$ ".number_format($row->unit_price, 2, '.', ',');
        })
        ->editColumn('total', function($row) {
            return "$ ".number_format($row->total, 2, '.', ',');
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
     * @param \App\Models\ReturnRequestConcept $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReturnRequestConcept $model): QueryBuilder
    {
        return $model->select(
			'return_request_concepts.*',
            DB::raw("CONCAT(unit_types.code, ' - ', unit_types.name) as unit_type_id")
            )
        ->leftjoin('return_request_invoices', 'return_request_concepts.return_request_invoice_id', '=', 'return_request_invoices.id')
        ->leftjoin('unit_types', 'return_request_concepts.unit_type_id', '=', 'unit_types.id')
        ->where("return_request_concepts.return_request_invoice_id", $this->return_request_invoice_id)
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
                ->setTableId('return_request_concepts-table')
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
        $result .= '
            <a title="Editar" onclick="getEditReturnConceptModal('.$row->id.')" class="btn btn-outline-secondary btn-icon ps-2 px-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
            </a>
        ';
        $result .= '
            <a onclick="deleteReturnConcept('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
            </a>
        ';
        return $result;
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
            Column::make('id')
            ->title('Id')
            ->searchable(false)
            ->visible(false),
            Column::make('amount')->title("C."),
            Column::make('unit_type_id')->title("Unidad")->name("unit_types.name"),
            Column::make('concept')->title("Concepto"),
            Column::make('description')->title("Descripción"),
            Column::make('unit_price')->title("P. unitario"),
            Column::make('total')->title("Importe"),
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
        return 'ReturnRequestConcepts_' . date('YmdHis');
    }
}
