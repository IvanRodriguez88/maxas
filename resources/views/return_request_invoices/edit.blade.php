<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Modificar solicitud de retorno
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/return_requests/return_requests.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modificar solicitud de retorno</h5>
                <hr>
                <form id="return_request_edit-form" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_request_invoices.update', $return_request_invoice->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("return_request_invoices.facturation-fields")
                            <hr>
                            <div class="mt-2 mb-2">
                                @include("return_request_invoices.return_concepts")
                            </div>
                            <hr>
                            <div class="mt-2 mb-2">
                                @include("return_request_invoices.return_types")
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('return_requests.index')}}" class="btn btn-dark">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <form id="returnTypeModal" class="row g-3 needs-validation" novalidate method="POST">
        <input type="hidden" name="return_request_invoice_id" id="return_request_invoice_id" value="{{$return_request_invoice->id}}">
        <x-modal id="addReturnTypeModal" title="Agregar forma de retorno" size="lg">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>

    <form id="returnConceptModal" class="row g-3 needs-validation" novalidate method="POST">
        <input type="hidden" name="return_request_invoice_id" id="return_request_invoice_id" value="{{$return_request_invoice->id}}">
        <x-modal id="addReturnConceptModal" title="Agregar concepto" size="lg" btnSubmitId="btnSubmitConcept">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {!! $returnRequestConceptDT['scripts'] !!}
        {!! $returnRequestReturnTypeDT['scripts'] !!}

        @vite(['resources/js/autocomplete.js'])
        @vite(['resources/js/return_requests/return_request_clients.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>