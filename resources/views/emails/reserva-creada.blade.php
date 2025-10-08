@component('mail::message')
# 📝 ¡Reserva Registrada! 🎉

**Hola, {{ $reserva->name }} {{ $reserva->surname }}**

Tu reserva ha sido **registrada correctamente** para la feria del **{{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}**.  
Para confirmar tu participación, debes **realizar el pago completo** dentro del plazo establecido.

---

## 🧾 Detalles de la Reserva:
**🏠 Sede:** {{ $sede->title }}  
**📍 Ubicación:** {{ $sede->address }}  
**🪧 Stand N°:** {{ $stand->booth_number }}  
**🏷️ Categoría:** {{ ucfirst($stand->category) }}  
**💰 Total:** S/ {{ number_format($reserva->price, 2) }}

---

## 🛍️ Incluye:
- 1 toldo (2x2 m)  
- 1 mesa  
- 1 silla  
📅 **Día del evento:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
🕓 *Feria activa los domingos*

---

## 🎫 Código de validación:  
**{{ $reserva->key_code }}**  
Este código es **personal e intransferible**.  
Inclúyelo como mensaje al momento de enviar tu comprobante de pago.

---

@component('mail::panel')
### 💳 Pago de Reserva
Realiza el pago a través de **Yape** escaneando el siguiente código QR, como mensaje incluye el código de validación.  

<div style="text-align:center; margin: 20px 0;">
    <img src="{{ $message->embed(public_path('assets/image/yape_qr.png')) }}" 
         alt="QR de pago Feria Lunar" 
         style="max-width:250px;">
</div>

📱 **Número Yape:** 906542477
@endcomponent

---

## ⏳ Importante:
- Tienes **1 hora** para realizar el pago desde el momento de la reserva.  
- Pasado este tiempo, el stand será **liberado automáticamente**.  
- Envía el comprobante de pago por **WhatsApp** al número **906542477**, junto con tu código de validación.

Una vez confirmado el pago, recibirás un **correo final de confirmación** con los detalles de tu stand y ubicación dentro del evento.

---

Gracias por confiar en **{{ config('app.name') }}** 🌙  
**El equipo de {{ config('app.name') }}**

*Este es un mensaje automático. Por favor, no respondas a este correo.*
@endcomponent