<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comisión Federal de Electricidad | División Bajío') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>La Comisión Federal de Electricidad (CFE) es una empresa pública de carácter social que provee energía eléctrica, servicio fundamental para el desarrollo de una nación. Es una empresa productiva del Estado, propiedad exclusiva del gobierno federal, con personalidad jurídica y patrimonio propio. Goza de autonomía técnica, operativa y de gestión conforme a lo dispuesto en la Ley de la Comisión Federal de Electricidad.</p>
                    <br>
                    <img src="{{asset('images/Intro_imagen.jpg')}}" alt="" srcset="">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
