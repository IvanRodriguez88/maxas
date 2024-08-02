<div class="card">
    <div class="d-flex justify-content-between align-items-center">
        <div class="ms-3">
            <h5 class="text-center mt-3 mb-3">Conceptos</h5>
        </div>
        <div class="d-flex">
            <a class="btn btn-success m-2" id="openModalConcepts">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Agregar
            </a>
        </div>
    </div>
    <hr class="m-0 mb-4">
    <div class="mb-3">
        {!! $returnRequestConceptDT["view"] !!}
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="p-3">
                    <label for="client_payment_proof">Comprobante de pago</label>
                    <input type="file" class="form-control" id="client_payment_proof" name="client_payment_proof" accept=".pdf">
                </div>
            </div>
            <div class="col-md-6">
                <table class="table-custom">
                    <tbody>
                        <tr>
                            <td>SUBTOTAL</td>
                            <td id="subtotal">$ {{ number_format($return_request->subtotal, 2, '.', ',') }}</td>
                            </tr>
                        <tr>
                            <td>IVA 16%</td>
                            <td id="iva">$ {{ number_format($return_request->iva, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td><b>TOTAL FACTURA</b></td>
                            <td><b id="total">$ {{ number_format($return_request->total_invoice, 2, '.', ',') }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>