@extends('layouts.layout')

@section('document-title', '')

@section('body-content')
<div class="container">
  <section class="sede">
    <h1 class="sede__title">{{ $sede->title }}</h1>

    <h2 class="sede__subtitle">Fechas disponibles:</h2>

    <div class="fechas-tabs">
      @foreach($availableDates as $date)
        <a 
          href="{{ route('sedes.stands', ['id' => $sede->id, 'fecha' => $date->toDateString()]) }}"
          class="fecha-tab {{ $selectedDate === $date->toDateString() ? 'active' : '' }}">
            {{ $date->format('d/m/Y') }}
        </a>
      @endforeach
    </div>
  </section>

  <section class="reservation">
    <h3 class="reservation__text">
      Stands disponibles para el 
      <strong>{{ \Carbon\Carbon::parse($selectedDate)->format('d/m/Y') }}</strong>
    </h3>

    <div class="reservation__content--form">
      <form action="{{ route('reservas.create') }}" method="GET" id="reservaForm" class="reservation__form form">
        <div id="stand-select-group" class="form__field form__stand-grid">
          @foreach($sede->sedeStands as $sedeStand)
            @php
              $reservaActiva = $sedeStand->reservas()
                ->where('reservation_date', $selectedDate)
                ->whereIn('status', ['pending', 'paid'])
                ->exists();
              $status = $sedeStand->statusToDate($selectedDate);
            @endphp
            <div class="form__option-stand">
              <input 
                type="radio" 
                name="sede_stand_id" 
                id="stand_{{ $sedeStand->id }}" 
                value={{ $sedeStand->id }} 
                {{ $reservaActiva ? 'disabled' : '' }}
                data-price={{ $sedeStand->price }}" 
                required
                readonly
                class="form__radio-stand {{ $sedeStand->stand->category }} {{ $status }}" />
              <label 
                for="stand_{{ $sedeStand->id }}" 
                class="form__label-stand {{ $status }}"
                title="Stand {{ $sedeStand->stand->booth_number}} - {{ $sedeStand->stand->category }} - {{ $sedeStand->price }} ({{ $status }})">
                {{ $sedeStand->stand->booth_number }}
              </label>
          </div>
          @endforeach
        </div>
    
        {{-- Campo oculto para la fecha seleccionada --}}
        <input type="hidden" name="selected_date_to_reserve" readonly value={{ $selectedDate }} class="form__selected-date--hidden">
    
        {{-- Botón único para enviar la reserva --}}
        <div class="form__field">
            <p id="form-legend" class="form__text-warning">Debe seleccionar un stand</p>

            <button 
              type="submit" 
              id="reserveBtn" 
              disabled 
              class="button form__button disabled">
              Reservar {{ $selectedDate }}
            </button>
        </div>
      </form>
    </div>
  </section>

  <!-- LEYENDA DE UBICACIONES -->

  <section class="legend">
    <div class="status">
      <div class="status__item">
        <div class="status__symbol status__symbol--success"></div>
        <div class="status__label">Libre</div>
      </div>

      <div class="status__item">
        <div class="status__symbol status__symbol--warning"></div>
        <div class="status__label">Reservado</div>
      </div>

      <div class="status__item">
        <div class="status__symbol status__symbol--danger"></div>
        <div class="status__label">Ocupado</div>
      </div>
    </div>

    <div class="category">
      <div class="category__item">
        <div class="category__symbol category__symbol--standard"></div>
        <div class="category__label">Estándar (S/100)</div>
      </div>

      <div class="category__item">
        <div class="category__symbol category__symbol--food"></div>
        <div class="category__label">Gastronomía (S/110)</div>
      </div>
    </div>
  </section>

  {{-- Info --}}
  <div class="sede-info">
    <div class="sede-info__image">
      <picture>
        <source 
          srcset="{{ asset('assets/image/feria_lunar_stand.webp') }}, {{ asset('assets/image/feria_lunar_stand.jpg') }}"
          loading="lazy"
          />
        <img 
          src="assets/image/{{ asset($sede->image) }}" 
          alt="{{ $sede->title }} - {{ $sede->address }}"
          loading="lazy"
        />
      </picture>
    </div>
    
    <div class="sede-info__details">
      <h2 class="sede-info__title">{{ $sede->title }}</h2>
      
      <div class="sede-info__description">
        <p>{{ $sede->address }}</p>
        <p><strong>Capacidad:</strong> {{ $sede->capacity }}</p>
      </div>
    </div>
  </div>
@endsection

@section('footer-scripts')
{{-- Script --}}
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const radios = document.querySelectorAll('input[name="sede_stand_id"]');
      const reserveBtn = document.getElementById('reserveBtn');
      const formLegendWarning = document.getElementById('form-legend');
      const form = document.getElementById('reservaForm');
  
      radios.forEach(radio => {
          radio.addEventListener('change', function() {
            if (this.checked && !this.disabled) {
              formLegendWarning.classList.add('hidden');
              reserveBtn.removeAttribute("disabled");
              reserveBtn.classList.remove('disabled');
            }
          });
      });
  
      // Validación de seguridad en frontend
      form.addEventListener('submit', function(e) {
          const selected = document.querySelector('input[name="sede_stand_id"]:checked');
          if (!selected) {
              e.preventDefault();
              alert('Por favor selecciona un stand antes de continuar.');
          }
      });
  });
  </script>
@endsection
</div>