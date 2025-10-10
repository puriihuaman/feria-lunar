@extends('layouts.layout')

@section('document-title', 'Reserva')

@section('body-content')
<div class="container">
    <h1>Información de la reserva</h1>
    <section>
        <h2>Detalles de su reserva</h2>

        <div class="card mb-4">
            <div class="card-body">
                <div>
                    <strong>Sede: </strong>
                    <h4>{{ $sedeStand->sede->title }}</h4>
                </div>
                <div>
                    <strong>Dirección:</strong> 
                    <p>{{ $sedeStand->sede->address }}</p>
                </div>

                <div>
                    <strong>Stand N°:</strong>
                    <p>{{ $sedeStand->stand->booth_number }}</p>
                </div>

                <div>
                    <strong>Categoría:</strong>
                    <p>{{ ucfirst($sedeStand->stand->category) }}</p>
                </div>

                <div>
                    <strong>Precio:</strong>
                    <p>S/. {{ number_format($sedeStand->price, 2) }}</p>
                </div>

                <div>
                    <strong>Fecha de reserva:</strong>
                    <p>
                        {{ \Carbon\Carbon::parse($selectedDateToReserve)->format('d/m/Y')}}
                    </p>
                </div>
            </div>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
          </div>
        @endif
    </section>

    <section>
        <h3>Ingrese sus datos</h3>

        <form  id="reservaForm" method="POST" action="{{ route('reservas.store') }}" class="form">
            @csrf
      
            <input type="hidden" name="sede_stand_id" id="sede_stand_id" value="{{ $sedeStand->id }}">
            <input type="hidden" name="reservation_date" id="reservation_date" value="{{ $selectedDateToReserve }}">
      
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Fernando...">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <div class="mb-3">
                <label for="surname" class="form-label">Apellido</label>
                <input type="text" name="surname" id="surname" class="form-control" value="{{ old('surname') }}" placeholder="Fernandez" />
                @error('surname') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="fernando@example.com" />
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="999 999 999" />
                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <div class="mb-3">
                <label for="captcha" class="form-label">Captcha: ¿Cuánto es 3 + 4?</label>
                <input type="text" name="captcha" id="captcha" class="form-control" placeholder="Escribe la respuesta">
                @error('captcha') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="termsCheck" id="termsCheck">
                <label  class="form-check-label" for="termsCheck">
                    Acepto los <a href="{{ route('terms') }}" target="_blank">Términos y Condiciones</a>.
                </label>
                @error('termsCheck') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
      
            <button type="submit" class="button">Confirmar Reserva</button>
      
            <div id="errorAlert"></div>
        </form>
    </section>
</div>
@endsection

@section('footer-scripts')
<script>
document.getElementById('reservaForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita el envío inmediato

    const sede_stand_id = document.getElementById('sede_stand_id').value.trim();
    const reservation_date = document.getElementById('reservation_date').value.trim();
    const name = document.getElementById('name').value.trim();
    const surname = document.getElementById('surname').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const email = document.getElementById('email').value.trim();
    const termsCheck = document.getElementById('termsCheck').checked;

    let errors = [];

    if (!name) errors.push('El nombre es obligatorio.');
    if (!surname) errors.push('El apellido es obligatorio.');
    if (!phone) errors.push('El teléfono es obligatorio.');
    if (!email) {
        errors.push('El correo electrónico es obligatorio.');
    } else {
        const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
        if (!emailRegex.test(email)) errors.push('El correo electrónico no es válido.');
    }
    if (!termsCheck) errors.push('Debe aceptar los términos y condiciones.');

    const errorAlert = document.getElementById('errorAlert');

    if (errors.length > 0) {
        errorAlert.innerHTML = errors.join('<br>');
        errorAlert.classList.remove('d-none');
    } else {
        errorAlert.classList.add('d-none');
        this.submit(); // Si todo está correcto, envía el formulario
    }
});
</script>
@endsection