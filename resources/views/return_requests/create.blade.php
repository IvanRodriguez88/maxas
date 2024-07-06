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
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear solicitud de retorno</h5>
                <hr>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('return_requests.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("return_requests.fields")
                            <p class="text-secondary text-center">
                                Es necesario guardar para llenar las formas de retorno
                            </p>

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
        @vite(['resources/js/return_requests/return_requests.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>