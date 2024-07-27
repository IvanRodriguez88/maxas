<div class="text-end mb-1 mx-2">
    <a href="" class="text-primary">Descarga el formato de layout</a>
</div>
<div class="card">
    <div class="d-flex justify-content-between align-items-center">
        <div class="ms-3">
            <h5 class="text-center mt-3 mb-3">Formas de retorno</h5>
        </div>
        <div class="d-flex">
            <a class="btn btn-success m-2" id="openModalTypes">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Agregar
            </a>
            <a class="btn btn-success m-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                Subir layout
            </a>
        </div>
    </div>
    <hr class="m-0 mb-4">
    <div class="mb-3">
        {!! $returnRequestReturnTypeDT["view"] !!}
    </div>
    <hr>
    <div class="row mb-3">
            <div class="col-6">
            </div>
            <div class="col-md-6">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <td class="text-success"><b>TOTAL A RETORNAR</b></td>
                            <td class="text-success"><b id="total_return">$ {{ number_format($return_request->total_return, 2, '.', ',') }}</b></td>
                        </tr>
                        <tr>
                            <td><b>TOTAL SUMADO</b></td>
                            <td><b id="total_return_types">$ {{ number_format($return_request->returnTypes->sum("amount"), 2, '.', ',') }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-primary"><b>RESTANTE</b></td>
                            <td class="text-primary">
                                <b id="rest_types">
                                    $ {{ number_format($return_request->total_return - $return_request->returnTypes->sum("amount"), 2, '.', ',') }}
                                </b>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
    </div>
</div>