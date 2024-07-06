<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="promotor_clients">

    <x-slot:pageTitle>
        Promotores
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
         <!-- CONTENT HERE -->
         <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Clientes de {{$promotor->name}}</h5>
                    @if($allowAdd)
                        <a class="btn btn-success m-2" id="openModal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Agregar
                        </a>
                    @endif
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>

    </div>

    <form id="promotorClientModal" class="row g-3 needs-validation" novalidate method="POST">
        <input type="hidden" name="promotor_id" id="promotor_id" value="{{$promotor->id}}">
        <x-modal id="addPromotorClientModal" title="Agregar cliente a promotor" size="lg">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {{ $dataTable->scripts() }}
        @vite(['resources/js/promotors/promotors.js'])

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>