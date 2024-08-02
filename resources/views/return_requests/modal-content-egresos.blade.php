<input type="hidden" id="return_request_return_type_id" value="{{$return_request_return_type->id }}">

<div class="m-2">
    <p>Beneficiario: {{$return_request_return_type->beneficiary_name}}</p>
    <p>Banco: {{$return_request_return_type->bank->name}}</p>
    <p>Forma de retorno: {{$return_request_return_type->returnType->name}}</p>
    <p>Cuenta: {{$return_request_return_type->account_number}}</p>
    <p>Monto: {{$return_request_return_type->amount}}</p>
    <p>Referencia: {{$return_request_return_type->reference ?? ""}}</p>

</div>
<hr>
<div class="row m-2">
    <label class="px-0" for="dispersion_voucher_file">Comprobante <span class="text-danger">*</span></label>
    <input required name="dispersion_voucher_file" id="dispersion_voucher_file" type="file" accept=".pdf" class="form-control">
</div>