@component('mail::message')
# ❌ ¡Reserva cancelada!
    
Hola, {{ $reserva->name }} {{ $reserva->surname }}
    
Tu reserva ha sido **cancelada automáticamente** al no completarse el pago dentro del plazo de **1 hora**.

---

## 🧾 Detalles de la Reserva:
**🆔 ID:** {{ $reserva->id }}  
**⚙️ Estado:** Cancelada  
**🏠 Sede:** {{ $sede->title }}  
**📍 Ubicación:** {{ $sede->address }}  
**📅 Fecha:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
**🪧 Stand N°:** {{ $stand->booth_number }}  
**🏷️ Categoría:** {{ ucfirst($stand->category) }}  
**💰 Total:** S/ {{ number_format($reserva->price, 2) }}

---

El stand reservado fue liberado y está disponible nuevamente para otros expositores.  
Si aún deseas participar, puedes generar una nueva reserva desde nuestra web.


@component('mail::button', ['url' => route('index')])
Nueva Reservar
@endcomponent

Gracias por tu comprensión.  
El equipo de **{{ config('app.name') }}** 🌙
@endcomponent