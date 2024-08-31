<?php

namespace App\DataTables;

use App\Models\ReturnRequestReturnType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestInvoice;

class ReturnRequestInvoiceDataTable extends DataTable
{
    public function __construct($return_request_id)
	{
		$this->return_request = ReturnRequest::find($return_request_id);
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
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action"]);

        return $datatable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReturnRequestInvoice $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReturnRequestInvoice $model): QueryBuilder
    {
        return $model->select(
			'return_request_invoices.*',
		)
        ->leftjoin('return_requests', 'return_request_invoices.return_request_id', '=', 'return_requests.id')
        ->where("return_request_invoices.return_request_id", $this->return_request->id)
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
                ->setTableId('return_request_invoices-table')
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

            Column::make('subtotal')->title("subtotal"),
            // Column::make('bank_id')->title("Banco"),
            // Column::make('return_type_id')->title("Forma de retorno"),
            // Column::make('account_number')->title("Cuenta"),
            // Column::make('amount')->title("Monto"),
            // Column::make('reference')->title("Referencia"),

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
        return 'ReturnRequestInvoices_' . date('YmdHis');
    }
}
