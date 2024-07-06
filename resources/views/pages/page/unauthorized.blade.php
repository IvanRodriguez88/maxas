<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/pages/error/error.scss'])
        @vite(['resources/scss/dark/assets/pages/error/error.scss'])
        <!--  END CUSTOM STYLE FILE  -->

        <style>
            body.layout-dark .theme-logo.dark-element {
                display: inline-block;
            }
            .theme-logo.dark-element {
                display: none;
            }
            body.layout-dark .theme-logo.light-element {
                display: none;
            }
            .theme-logo.light-element {
                display: inline-block;
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="container-fluid">
        <div class="row">
            <div class="mt-3 text-center">
                <a href="{{ route('dashboard.index') }}" class="ml-md-5">
                    <img alt="image-404" src="{{Vite::asset('resources/images/logo.svg')}}" class="dark-element theme-logo">
                    <img alt="image-404" src="{{Vite::asset('resources/images/logo2.svg')}}" class="light-element theme-logo">
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid d-flex justify-content-center">
        <div class="text-center">
            <h1 class="error-number mt-2">401</h1>
            <p class="mb-4 mt-1">No estás autorizado para entrar a esta página!</p>
            <img src="{{Vite::asset('resources/images/error.svg')}}" alt="No autorizado" class="error-img w-75">
        </div>
    </div>   
    <div class="d-flex justify-content-center">
        <a href="{{ route('dashboard.index') }}" class="btn btn-dark mt-5">Regresar</a>
    </div>

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>