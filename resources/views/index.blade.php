@extends('layouts.layout')

@section('document-title', 'Sede Apupal')

@section('body-content')

{{-- Banner --}}

<div class="banner">
    <div class="container banner__content">
        <div class="banner__left">
            <p class="company">FERIA LUNAR</p>
            <h2 class="">Tu negocio, tu espacio en Feria Lunar</h2>
            <p class="slogan">Moda accesible: Polos, camisas y pantalones para todos los gustos.</p>
            <a href="/sedes" class="banner-link" role="button">
                Reservar ahora
            </a>
        </div>

        <div class="banner__right">
            <button aria-label="Reproducir video" class="button-play">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-icon lucide-play"><path d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"/></svg>
            </button>
        </div>
    </div>
</div>

{{-- Feature --}}
<section class="feature">
    <div class="container feature__container">
        <div class="feature__content">
            <div class="feature__item">
                <div class="feature__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check-icon lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h3 class="feature__title">Alta Visibilidad</h3>
                <p class="feature__subtitle">Tu stand en el mejor lugar para destacar.</p>
            </div>

            <div class="feature__item">
                <div class="feature__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>
                </div>
                <h3 class="feature__title">Montaje Rápido</h3>
                <p class="feature__subtitle">Instálate sin complicaciones y comienza a vender.</p>
            </div>

            <div class="feature__item">
                <div class="feature__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check-icon lucide-shield-check"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                </div>
                <h3 class="feature__title">Confianza Garantizada</h3>
                <p class="feature__subtitle">Eventos organizados y seguros para ti y tus clientes.</p>
            </div>
        </div>
    </div>
</section>

{{-- Sedes --}}

<section class="sedes">
    <div class="container sedes__container">
        <h2>Nuestras Sedes</h2>
        <p>Visite cada una de nuestras sedes y alquila tu stand ¡AHORA!</p>
      
      <section class="sedes-grid">
        @component('_components.sede-card')
        @slot('image', 'assets/image/ferialunar-stand.jpg')
        @slot('title', 'Sede Apupal - Los Olivos')
        @slot('address', 'Av. Las Palmeras 3943, Los Olivos.')
        @slot('reference', 'A 1 cdra de la Municipalidad')
        @slot('capacity', 68)
        @slot('link', route('sedes.stands', 1))
        @endcomponent
        
        @component('_components.sede-card')
        @slot('image', 'assets/image/ferialunar-stand.jpg')
        @slot('title', 'Sede Surco - Surco')
        @slot('address', 'Av. Javier Prado con Av. Guardia Civil, Surco.')
        @slot('reference', 'Al frente de La Rambla de San Borja')
        @slot('capacity', 146)
        @slot('link', route('sedes.stands', 2))
        @endcomponent
      </section>
    </div>
</section>

{{-- Maps --}}

@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif

@endsection
