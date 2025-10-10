@extends('layouts.layout')

@section('document-title', 'Reserva')

@section('body-content')
<section class="reservation">
    <div class="container reservation__content">
        <h1 class="reservation__title">Información de la reserva</h1>

        <section class="reservation__group info">
            <h2 class="info__title">Detalles de su reserva</h2>
    
            <div class="info__card">
                <div class="info__item">
                    <strong>Sede: </strong>
                    <h4>{{ $sedeStand->sede->title }}</h4>
                </div>
                
                <div class="info__item">
                    <strong>Dirección:</strong> 
                    <p>{{ $sedeStand->sede->address }}</p>
                </div>

                <div class="info__item">
                    <strong>Stand N°:</strong>
                    <p>{{ $sedeStand->stand->booth_number }}</p>
                </div>

                <div class="info__item">
                    <strong>Categoría:</strong>
                    <p>{{ ucfirst($sedeStand->stand->category) }}</p>
                </div>

                <div class="info__item">
                    <strong>Precio:</strong>
                    <p>S/. {{ number_format($sedeStand->price, 2) }}</p>
                </div>

                <div class="info__item">
                    <strong>Fecha de reserva:</strong>
                    <p>
                        {{ \Carbon\Carbon::parse($selectedDateToReserve)->format('d/m/Y')}}
                    </p>
                </div>
            </div>
    
            @if ($errors->any())
              <div class="alert danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div>
            @endif
        </section>
    
        <section class="reservation__group">
            <h3 class="reservation__form-title">Ingrese sus datos</h3>
    
            <form  id="reservaForm" method="POST" action="{{ route('reservas.store') }}" class="reservation__form form">
                @csrf
          
                <input 
                    type="hidden" 
                    name="sede_stand_id" 
                    id="sede_stand_id" 
                    value="{{ $sedeStand->id }}"
                    required/>
                <input 
                    type="hidden" 
                    name="reservation_date" 
                    id="reservation_date" 
                    value="{{ $selectedDateToReserve }}"
                    required/>
          
                <div class="form__field">
                    <label for="name" class="form__label">Nombre</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form__control" 
                        value="{{ old('name') }}" 
                        placeholder="Fernando..."
                        
                        />
                    @error('name') <small class="alert danger">{{ $message }}</small>@enderror
                </div>
          
                <div class="form__field">
                    <label for="surname" class="form__label">Apellido</label>
                    <input 
                        type="text" 
                        name="surname" 
                        id="surname" 
                        class="form__control" 
                        value="{{ old('surname') }}" 
                        placeholder="Fernandez" 
                        
                        />
                    @error('surname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
          
                <div class="form__field">
                    <label for="email" class="form__label">Correo electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form__control" 
                        value="{{ old('email') }}" placeholder="fernando@example.com"
                        
                        />
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
          
                <div class="form__field">
                    <label for="phone" class="form__label">Teléfono</label>
                    <input 
                        type="text" 
                        name="phone" 
                        id="phone" 
                        class="form__control" 
                        value="{{ old('phone') }}" 
                        placeholder="999 999 999"
                        
                        />
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
          
                <div class="form__field">
                    <label for="captcha" class="form__label">Captcha: ¿Cuánto es 3 + 4?</label>
                    <input 
                        type="text" 
                        name="captcha" 
                        id="captcha" 
                        class="form__control" 
                        placeholder="Escribe la respuesta"
                        
                        />
                    @error('captcha')
                        <small class="alert-danger">{{ $message }}</small>
                    @enderror
                </div>
          
                <div class="form__field form__field--term">
                    <input 
                        type="checkbox" 
                        name="termsCheck" 
                        id="termsCheck"
                        class="form__control form__control--check form-check-input"
                        
                        />
                    <label  class="form__label form-check-label" for="termsCheck">
                        Acepto los <a href="{{ route('terms') }}" target="_blank">Términos y Condiciones</a>.
                    </label>
                    @error('termsCheck') <small class="danger">{{ $message }}</small> @enderror
                </div>
          
                <button type="submit" class="button form__button">Confirmar Reserva</button>
          
                <div id="errorAlert" class="alert danger"></div>
            </form>
        </section>
    </div>
</section>
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