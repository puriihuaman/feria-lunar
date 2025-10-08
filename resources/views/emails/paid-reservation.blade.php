@component('mail::message')
# ✅ ¡Pago Confirmado!

Hola {{ $reserva->name ?? 'Expositor' }},

Tu pago ha sido **verificado exitosamente**.  
Tu stand en **{{ $sede->title }}** queda **confirmado y reservado**.

---

## 🧾 Detalles:  
**🏠 Sede:** {{ $sede->title }}  
**📍 Ubicación:** {{ $sede->address ?? 'Por confirmar' }}  
**📅 Fecha:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
**🪧 Stand N°:** {{ $stand->booth_number }}  
**💰 Total Pagado:** S/ {{ number_format($reserva->price, 2) }}

---

## 🔒 Código de Validación  
Este código será solicitado al ingresar al evento.  
**No lo compartas con nadie.**  

**Código:** `{{ $reserva->key_code }}`

---

@component('mail::button', ['url' => route('index')])
Visitar {{ config('app.name') }}
@endcomponent

Gracias por ser parte de **{{ config('app.name') }}** 🌙  
¡Nos alegra contar contigo en esta próxima edición!  

Atentamente,  
El equipo de **{{ config('app.name') }}**

*Correo automático. No responder.*
@endcomponent