<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="companies">

    <x-slot:pageTitle>
        Crear empresa
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/companies/companies.scss'])

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Crear empresa</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('companies.store') }}">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("companies.fields")
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('companies.index')}}" class="btn btn-dark">Cancelar</a>
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
        @vite(['resources/js/companies/companies.js'])
    </x-slot>
</x-base-layout>