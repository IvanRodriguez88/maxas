<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        Modificar cliente
    </x-slot>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
        @include("components.custom.errors")
        <!-- CONTENT HERE -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Modificar cliente</h5>
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method("PUT")
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            @include("clients.fields")
                            <hr>
                            <div class="card mt-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="ms-3">
                                        <h5 class="text-center mt-3 mb-3">Razones sociales</h5>
                                    </div>
                                    <div class="d-flex">
                                        <a class="btn btn-success m-2" id="openModal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                            Agregar
                                        </a>
                                    </div>
                                </div>
                                <hr class="m-0 mb-4">
                                <div class="mb-3">
                                    {!! $clientBusinessDT["view"] !!}
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{route('clients.index')}}" class="btn btn-dark">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form id="clientBusinessModalForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
        <input type="hidden" name="client_id" id="client_id" value="{{$client->id}}">
        <x-modal id="addClientBusinessModal" title="Agregar razón social" size="lg">
            <!-- Este contenido se llenará por AJAX -->
        </x-modal>
    </form>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/js/clients/clients.js'])
        {!! $clientBusinessDT["scripts"] !!}

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>