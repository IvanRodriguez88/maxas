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

class ReturnRequestReturnTypeDataTable extends DataTable
{
    public function __construct($return_request_invoice_id)
	{
		$this->return_request_invoice = ReturnRequestInvoice::find($return_request_invoice_id);
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
        ->editColumn('amount', function($row) {
            return "$ ".number_format($row->amount, 2, '.', ',');
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action"]);
        
        return $datatable;
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ReturnRequestReturnType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ReturnRequestReturnType $model): QueryBuilder
    {
        return $model->select(
			'return_request_return_types.*',
            'banks.name as bank_id',
            'return_types.name as return_type_id',
		)
        ->leftjoin('banks', 'return_request_return_types.bank_id', '=', 'banks.id')
        ->leftjoin('return_types', 'return_request_return_types.return_type_id', '=', 'return_types.id')
        ->where("return_request_return_types.return_request_invoice_id", $this->return_request_invoice->id)

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
                ->setTableId('return_request_return_types-table')
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
        if ($this->return_request->return_request_status_id == 5) {
            if ($row->dispersion_voucher_file == null) {
                $result .= '
                    <a title="Agregar archivo" onclick="getAddDispersionVoucherFileModal('.$row->id.')" class="btn btn-outline-dark btn-icon ps-2 px-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>                </a>
                    ';
            }else{
                $result .= '
                        <a id="file" target="_blank" href="'.route("return_requests.downloadDispersionVoucherFile", $row->id).'">
                            <u>Ver comprobante</u>
                        </a>
                    ';
            }
        }else {
            $result .= '
                <a title="Editar" onclick="getEditReturnTypeModal('.$row->id.')" class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
            $result .= '
                <a onclick="deleteReturnType('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>        </a>
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
            Column::make('id')
            ->title('Id')
            ->searchable(false)
            ->visible(false),

            Column::make('beneficiary_name')->title("Beneficiario"),
            Column::make('bank_id')->title("Banco"),
            Column::make('return_type_id')->title("Forma de retorno"),
            Column::make('account_number')->title("Cuenta"),
            Column::make('amount')->title("Monto"),
            Column::make('reference')->title("Referencia"),

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
        return 'ReturnRequests_' . date('YmdHis');
    }
}
