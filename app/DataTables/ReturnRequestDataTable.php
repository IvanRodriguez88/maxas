<?php

namespace App\DataTables;

use App\Models\ReturnRequest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReturnRequestDataTable extends DataTable
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
            return date("d/m/Y", strtotime($row->date));
        })
        ->editColumn('total_invoice', function($row) {
            return "$ ".number_format($row->total_invoice, 2, '.', ',');
        })
        ->editColumn('total_return', function($row) {
            return "$ ".number_format($row->total_return, 2, '.', ',');
        })
        ->editColumn('comission_charged', function($row) {
            return "$ ".number_format($row->comission_charged, 2, '.', ',');
        })
        ->editColumn('iva', function($row) {
            return "$ ".number_format($row->iva, 2, '.', ',');
        })
        ->editColumn('social_cost', function($row) {
            return "$ ".number_format($row->social_cost, 2, '.', ',');
        })
        ->editColumn('comission_promotor', function($row) {
            return "$ ".number_format($row->comission_promotor, 2, '.', ',');
        })
        ->editColumn('comission_cab', function($row) {
            return "$ ".number_format($row->comission_cab, 2, '.', ',');
        })
        ->editColumn('comission_play', function($row) {
            return "$ ".number_format($row->comission_play, 2, '.', ',');
        })
        ->editColumn('play_return', function($row) {
            return "$ ".number_format($row->play_return, 2, '.', ',');
        })
        ->editColumn('cab5T', function($row) {
            return "$ ".number_format($row->cab5T, 2, '.', ',');
        })
        ->editColumn('total_invoice', function($row) {
            return "$ ".number_format($row->total_invoice, 2, '.', ',');
        })
        ->editColumn('return_percentage', function($row) {
            return $row->return_percentage." %";
        })
        ->editColumn('return_request_status_id', function($row) {
            switch ($row->return_request_status_id) {
                case 'Ingresos':
                    $color = "primary";
                    break;
                case 'Egresos':
                    $color = "info";
                    break;
                case 'Mesa de control':
                    $color = "dark";
                    break;
                case 'Egresos':
                    $color = "success";
                    break;
                default:
                    $color = "secondary";
                    break;
            }
            return '<span class="badge badge-'.$color.' mb-2 me-4">'.$row->return_request_status_id.'</span>';
        })
        ->editColumn('client_payment_proof', function($row) {
            $route = route("return_requests.downloadClientPaymentProof", $row->id);
            return '
                <a href="'.$route.'" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                </a>
            ';
        });

        $datatable->addColumn('action', function($row){
            return $this->getActions($row);
        })->rawColumns(["action", "is_active", "client_payment_proof", "return_request_status_id"]);

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
        return $model->select(
			'return_requests.*',
            'companies.name as company_id',
            'clients.name as client_id',
            'promotors.name as promotor_id',
            'banks.name as account_id',
            'return_bases.name as return_base_id',
            'return_request_statuses.name as return_request_status_id'
		)
        ->leftjoin('clients', 'return_requests.client_id', '=', 'clients.id')
        ->leftjoin('promotors', 'return_requests.promotor_id', '=', 'promotors.id')
        ->leftjoin('companies', 'return_requests.company_id', '=', 'companies.id')
        ->leftjoin('accounts', 'return_requests.account_id', '=', 'accounts.id')
        ->leftjoin('banks', 'accounts.bank_id', '=', 'banks.id')
        ->leftjoin('return_bases', 'return_requests.return_base_id', '=', 'return_bases.id')
        ->leftjoin('return_request_statuses', 'return_requests.return_request_status_id', '=', 'return_request_statuses.id')
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
                ->setTableId('return_requests-table')
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
        if (auth()->user()->hasPermissions("return_requests.edit")) {
            $result .= '
                <a title="Editar" href='.route("return_requests.edit", $row->id).' class="btn btn-outline-secondary btn-icon ps-2 px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                </a>
            ';
        }
        if (auth()->user()->hasPermissions("return_requests.destroy")) {
            $result .= '
                <a onclick="deleteRow('.$row->id.')" title="Eliminar" class="btn btn-outline-danger btn-icon ps-2 px-1">
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

            Column::make('return_request_status_id')->title("Estado")->name("return_request_statuses.name"),
            Column::make('client_id')->title("Cliente")->name("clients.name"),
            Column::make('company_id')->title("Empresa")->name("companies.name"),
            Column::make('account_id')->title("Cuenta")->name("banks.name"),
            Column::make('promotor_id')->title("Promotor")->name("promotors.name"),
            Column::make('date')->title("Fecha")->name("return_requests.date"),
            Column::make('total_invoice')->title("Total de factura")->className("text-end"),
            Column::make('client_payment_proof')->title("Cpbnte. de pago")->className("text-center"),
            Column::make('invoice')->title("Factura")->className("text-end"),
            Column::make('total_return')->title("Total a retornar")->className("text-end"),
            Column::make('comission_charged')->title("Comisión cobrada")->className("text-end"),
            Column::make('iva')->title("IVA")->className("text-end"),
            Column::make('social_cost')->title("Costo social")->className("text-end"),
            Column::make('comission_promotor')->title("Comisión de promotor")->className("text-end"),
            Column::make('comission_cab')->title("Comisión CAB")->className("text-end"),
            Column::make('comission_play')->title("Comisión Play")->className("text-end"),
            Column::make('play_return')->title("Retorno play")->className("text-end"),
            Column::make('cab5T')->title("CAB .5% sobre T")->className("text-end"),
            Column::make('return_percentage')->title("% de retorno")->className("text-center"),
            Column::make('return_base_id')->title("Base de retorno")->name("return_bases.name"),


            Column::make('created_at')->title("Fecha creado"),
            Column::make('updated_at')->title("Fecha editado"),
            Column::make('is_active')->title("Activo"),
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
