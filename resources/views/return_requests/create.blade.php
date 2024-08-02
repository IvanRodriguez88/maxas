<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Crear solicitud de retorno
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
        <input type="hidden" id="type" value="create">
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nueva solicitud de retorno</h5>
                <hr>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_requests.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("return_requests.facturation-fields")

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{route('return_requests.index')}}" class="btn btn-dark">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/autocomplete.js'])
        @vite(['resources/js/return_requests/return_request_clients.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>