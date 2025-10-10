@extends('layouts.layout')

@section('document-title', 'Sedes')

@section('body-content')

<section class="sedes">
  <div class="container">
    <h1 class="sedes__title">Sedes</h1>
    
    <section class="sedes-grid">
      @component('_components.sede-card')
      @slot('image', 'feria_lunar_stand.webp')
      @slot('title', 'Sede Apupal - Los Olivos')
      @slot('address', 'Av. Las Palmeras 3943, Los Olivos.')
      @slot('reference', 'A 1 cdra de la Municipalidad')
      @slot('capacity', 68)
      @slot('link', route('sedes.stands', 1))
      @endcomponent
      
      @component('_components.sede-card')
      @slot('image', 'feria_lunar_stand.webp')
      @slot('title', 'Sede Surco - Surco')
      @slot('address', 'Av. Javier Prado con Av. Guardia Civil, Surco.')
      @slot('reference', 'Al frente de La Rambla de San Borja')
      @slot('capacity', 146)
      @slot('link', route('sedes.stands', 2))
      @endcomponent
    </section>
  </div>
</section>
@endsection
