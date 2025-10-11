@extends('layouts.layout')

@section('document-title', 'Reserva Completada')

@section('body-content')
<section class="reservation-success">
  <div class="container reservation-success__content">
    <h2 class="reservation-success__title">¡Reserva registrada con éxito!</h2>
  
    <div class="reservation-success__info">
      <div class="reservation-success__item">
        <strong>Cliente: </strong>
        <p>{{ $reserva->name }} {{ $reserva->surname }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Stand N°: </strong>
        <p>{{ $reserva->sedeStand->stand->booth_number }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Fecha: </strong>
        <p>
          {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}
        </p>
      </div>
      
      <div class="reservation-success__item">
        <strong>Sede: </strong>
        <p>{{ $reserva->sedeStand->sede->title }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Dirección: </strong>
        <p>{{ $reserva->sedeStand->sede->address }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Cantidad: </strong>
        <p>{{ 1 }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Precio: </strong>
        <p>S/. {{ number_format($reserva->price, 2) }}</p>
      </div>

      <div class="reservation-success__item">
        <strong>Total: </strong>
        <p>S/. {{ number_format($reserva->price, 2) }}</p>
      </div>
      
      <div class="reservation-success__item">
        <a href="{{ route('sedes') }}" class="button reservation-success__button">
          Volver al inicio
        </a>
      </div>
    </div>
  </div>
</section>
@endsection