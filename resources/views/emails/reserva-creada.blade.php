{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button> --}}

{{-- Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}


@component('mail::message')
# ¡Su reserva ha sido registrada con éxito! 🎉

**Buenos días/tardes, {{ $reserva->name }} {{ $reserva->surname }}**

Les saluda **Feria Lunar 🌙**

¡Su reserva ha sido registrada con éxito!  
Para asegurar su participación en la próxima edición de la feria del **{{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}**, solo falta completar el pago correspondiente.

---

## 🏢 Información del Stand Reservado
**Sede:** {{ $reserva->sedeStand->sede->title }}  
**Dirección:** {{ $reserva->sedeStand->sede->address }}  
**Stand N°:** {{ $reserva->sedeStand->stand->booth_number }}  
**Categoría:** {{ ucfirst($reserva->sedeStand->stand->category) }}  
**Total:** S/ {{ number_format($reserva->sedeStand->price, 2) }}

---

📍 **Ubicación del evento:**  
{{ $reserva->sedeStand->sede->address }}  

🛍️ **Tu stand incluye:**
- 1 toldo de 2x2 m  
- 1 mesa  
- 1 silla  

💰 **Total a pagar:** S/ {{ number_format($reserva->price, 2) }}  
📅 **Fecha:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
🕓 *(Trabajamos todos los domingos)*

---
🎫 Código de validación: {{ $reserva->key_code }}

🔒 Importante:
El código de validación es personal e intransferible.
No lo compartas con nadie, ya que garantiza la seguridad y autenticidad de tu reserva.

@component('mail::panel')
Para completar su reserva, realice el pago completo escaneando el siguiente código QR, como mensaje incluye el código de validación.  

📸 **Escanea el siguiente código QR para completar tu pago:**

<div style="text-align:center; margin: 20px 0;">
    <img src="{{ $message->embed(public_path('assets/image/yape_qr.png')) }}" 
         alt="QR de pago Feria Lunar" 
         style="max-width:250px;">
</div>

📱 Número para Yape:
906542477
@endcomponent

---
Una vez realizado el pago, envía el comprobante por WhatsApp al mismo número (906542477) junto con el código único de validación:

⏳ **Importante:**  
Dispone de **1 hora** para realizar el pago desde el momento de la reserva.  
Pasado este tiempo, el espacio quedará liberado automáticamente y podrá ser asignado a otro expositor.

Una vez confirmado el pago, recibirá un nuevo correo con la confirmación final de su stand y los detalles de ubicación dentro del plano del evento.

---

Gracias por ser parte de **Feria Lunar**,  
el espacio donde sus productos destacan y sus ventas crecen 🚀

Saludos cordiales,  
**Equipo Feria Lunar**
@endcomponent