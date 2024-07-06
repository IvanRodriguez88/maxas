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
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_requests.update', $return_request->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("return_requests.fields")
                            <div class="text-end mb-1 mx-2">
                                <a href="" class="text-primary">Descarga el formato de layout</a>
                            </div>
                            <div class="card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="ms-3">
                                        <h5 class="text-center mt-3 mb-3">Formas de retorno</h5>
                                    </div>
                                    <div class="d-flex">
                                        <a class="btn btn-success m-2" id="openModal">
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
        <input type="hidden" name="return_request_id" id="return_request_id" value="{{$return_request->id}}">
        <x-modal id="addReturnTypeModal" title="Agregar forma de retorno" size="lg">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {!! $returnRequestReturnTypeDT['scripts'] !!}

        @vite(['resources/js/autocomplete.js'])
        @vite(['resources/js/return_requests/return_requests.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>