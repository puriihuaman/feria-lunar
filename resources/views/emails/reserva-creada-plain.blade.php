📝 ¡Reserva Registrada! 🎉

Hola, {{ $reserva->name }} {{ $reserva->surname }}

Tu reserva ha sido REGISTRADA CORRECTAMENTE para la feria del **{{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}**.  
Para confirmar tu participación, debes **realizar el pago completo** dentro del plazo establecido.

------------------------------------------------------------
🧾 Detalles de la Reserva:
------------------------------------------------------------
🏠 Sede:: {{ $sede->title }}
📍 Ubicación: {{ $sede->address }}
🪧 Stand N°: {{ $stand->booth_number }}
🏷️ Categoría: {{ ucfirst($stand->category) }}
💰 Total: S/ {{ number_format($reserva->price, 2) }}

------------------------------------------------------------
🛍️ Incluye:
------------------------------------------------------------
- 1 toldo (2x2 m)
- 1 mesa
- 1 silla

📅 **Día del evento:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
🕓 *Feria activa los domingos*

------------------------------------------------------------
🎫 Código de validación:
------------------------------------------------------------
**{{ $reserva->key_code }}**  
Este código es **personal e intransferible**.  
Inclúyelo como mensaje al momento de enviar tu comprobante de pago.

------------------------------------------------------------
⏳ Importante:
------------------------------------------------------------
- Tienes **1 hora** para realizar el pago desde el momento de la reserva.  
- Pasado este tiempo, el stand será **liberado automáticamente**.  
- Envía el comprobante de pago por **WhatsApp** al número **906542477**, junto con tu código de validación.

Una vez confirmado el pago, recibirás un **correo final de confirmación** con los detalles de tu stand y ubicación dentro del evento.

------------------------------------------------------------
Equipo Feria Lunar
------------------------------------------------------------
Gracias por confiar en **{{ config('app.name') }}** 🌙  

*Este es un mensaje automático. Por favor, no respondas a este correo.*