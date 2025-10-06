@extends('layouts.layout')

@section('document-title', 'Reserva Completada')

@section('body-content')
<div class="container text-center">
  <h2 class="text-success mb-3">¡Reserva registrada con éxito!</h2>

  <p><strong>Cliente:</strong> {{ $reserva->name }} {{ $reserva->surname }}</p>
  <p><strong>Stand:</strong> {{ $reserva->sedeStand->stand->booth_number }}</p>
  <p><strong>Sede:</strong> {{ $reserva->sedeStand->sede->title }}</p>
  <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}</p>
  {{-- <p><strong>Cantidad:</strong> {{ $reserva-> }}</p> --}}
  <p><strong>Precio:</strong> S/. {{ number_format($reserva->price, 2) }}</p>
  <p><strong>Total:</strong> S/. {{ number_format($reserva->price, 2) }}</p>

  <a href="{{ route('sedes') }}" class="btn btn-primary mt-4">Volver al inicio</a>
</div>
@endsection