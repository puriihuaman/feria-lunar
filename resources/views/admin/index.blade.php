@extends('layouts.layout')

@section('document-title', 'Sedes')

@section('body-content')

<div class="container">
  <h2>Gestión de Reservas</h2>

  <div class="table__container">
    <table class="table">
      <thead class="table__head">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Código</th>
          <th scope="col">Cliente</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Stand</th>
          <th scope="col">Sede</th>
          <th scope="col">Fecha</th>
          <th scope="col">Estado</th>
          <th scope="col">Acción</th>
        </tr>
      </thead>
        <tbody>
          @foreach($reservas as $reserva)
            <tr class="table__row">
              <td class="table__data--id">{{ $reserva->id }}</td>
              <td class="table__data">{{ $reserva->key_code }}</td>
              <td class="table__data">{{ $reserva->name ?? 'N/A' }}</td>
              <td class="table__data">{{ $reserva->phone ?? 'N/A' }}</td>
              <td class="table__data">
                {{ $reserva->sedeStand->stand->booth_number ?? 'N/A' }}
              </td>
              <td class="table__data">
                {{ $reserva->sedeStand->sede->title ?? 'N/A' }}
              </td>
              <td class="table__data">
                {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}
              </td>
              <td class="table__data">
                <span class="badge {{ $reserva->isPaid() ? 'success' : ($reserva->isPending() ? 'warning' : 'danger') }}">
                  {{ $reserva->status_label }}
                </span>
                {{-- <span class="badge {{ $reserva->status }}">
                    {{ $reserva->status_label  }}
                </span> --}}
              </td>
                <td class="table__data">
                  <form action="{{ route('admin.updateStatus', $reserva->id) }}" method="POST">
                      @csrf
                      @method('PATCH')
                      <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" {{ $reserva->status === $value ? 'selected' : '' }}>
                          {{ $label }}
                        </option>
                        @endforeach
                      </select>
                  </form>
                </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>
</div>
@endsection