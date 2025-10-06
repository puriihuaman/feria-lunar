@extends('layouts.layout')

@section('document-title', 'Sede Apupal')

@section('body-content')

<h1 class="title">{{ $sede->title }}</h1>


<h2 class="subtitle">Fechas disponibles:</h2>
<div class="fechas-tabs">
    @foreach($availableDates as $date)
    <a href="{{ route('sedes.stands', ['id' => $sede->id, 'fecha' => $date->toDateString()]) }}"
       class="fecha-tab {{ $selectedDate === $date->toDateString() ? 'active' : 'btn-outline-primary' }}">
        {{ $date->format('d M Y') }}
    </a>
@endforeach
</div>

<h3>
  Stands disponibles para el {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}
</h3>

<div class="form-reserva">
  <form action="{{ route('reservas.create') }}" method="GET" id="reservaForm">
    <div id="stand-select-group" class="stand-select-group">
      @foreach($sede->sedeStands as $sedeStand)
        @php
          $reservaActiva = $sedeStand->reservas()
            ->where('reservation_date', $selectedDate)
            ->whereIn('status', ['PENDING', 'PAID'])
            ->exists();
          $status = $sedeStand->statusToDate($selectedDate);
        @endphp
        <div class="stand-radio-option">
          <input 
            type="radio" 
            name="sede_stand_id" 
            id="stand_{{ $sedeStand->id }}" 
            value={{ $sedeStand->id }} 
            {{ $reservaActiva ? 'disabled' : '' }}
            data-price={{ $sedeStand->price }}" 
            class="stand-radio-input {{ $sedeStand->stand->category }} {{ $status }}" />
          <label 
            for="stand_{{ $sedeStand->id }}" 
            class="stand-radio-label {{ $status }}"
            title="Stand {{ $sedeStand->stand->booth_number}} - {{ $sedeStand->stand->category }} - {{ $sedeStand->price }} ({{ $status }})">
            {{ $sedeStand->stand->booth_number }}
          </label>
      </div>
      @endforeach
    </div>

    {{-- Campo oculto para la fecha seleccionada --}}
    <input type="hidden" name="selected_date" value="{{ $selectedDate }}">

    {{-- Botón único para enviar la reserva --}}
    <div class="mt-3">
        <button type="submit" id="reservarBtn" class="btn btn-success" style="display: none;">
            Reservar
        </button>
    </div>
  </form>
</div>

{{-- Info --}}

<div class="sede-info">
  <div class="sede-imagen-grande">
    <div class="imagen-placeholder">📍 {{ $sede->title }}</div>
  </div>
  
  <div class="sede-description">
    <h2>{{ $sede->title }}</h2>
    
    <div class="description-texto">
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
      const reservarBtn = document.getElementById('reservarBtn');
      const form = document.getElementById('reservaForm');
  
      radios.forEach(radio => {
          radio.addEventListener('change', function() {
            if (this.checked && !this.disabled) {
              reservarBtn.style.display = 'block';
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