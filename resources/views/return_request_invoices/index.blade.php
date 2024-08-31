<x-base-layout :scrollspy="false">
    <input type="hidden" id="route" value="return_requests">

    <x-slot:pageTitle>
        Solicitudes de retorno
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/accordions.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <x-slot:scrollspyConfig>
        data-bs-spy="scroll" data-bs-target="#navSection" data-bs-offset="100"
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">
         <!-- CONTENT HERE -->
         
         <div class="card">
            <div class="card-body">
                @include("components.custom.session-errors")
                <div class="d-flex justify-content-between align-items-center mb-2 p-2">
                    <h5 class="card-title">Facturas de Solicitud # {{$return_request->id}}</h5>
                    @if($allowAdd)
                        <a href="{{route('return_request_invoices.create', $return_request->id)}}" class="btn btn-success text-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            Agregar
                        </a>
                    @endif
                </div>
                {!! $returnRequestInvoiceDT["view"] !!}
            </div>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        {!! $returnRequestInvoiceDT["scripts"] !!}

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>