@component('mail::message')
# ¡Confirmación de pago recibida! 🎉

Hola {{ $reserva->name ?? 'Expositor' }},

Nos complace informarle que hemos **verificado y confirmado su pago** para su participación en la feria **{{ $sede->title }}**.  
A partir de este momento, su stand queda **oficialmente reservado**.

---

### 🧾 Detalles de la Reserva
- 📍 **Ubicación:** {{ $sede->address ?? 'Por confirmar' }}  
- 📅 **Fecha:** {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}  
- 🪧 **Stand:** {{ $stand->booth_number }}  
- 💰 **Precio Total:** S/ {{ number_format($reserva->price, 2) }}

---

### 🔒 Código de Validación
Este código será solicitado al momento de ingresar a la feria.  
**No lo comparta con nadie**, ya que es **personal e intransferible**.

**Código:** `{{ $reserva->key_code }}`

---

{{-- @component('mail::button', ['/' => route('index')])
Visitar Feria Lunar
@endcomponent --}}

Gracias por confiar en **Feria Lunar 🌙**  
Nos alegra contar con su presencia en este gran evento.

Atentamente,  
El equipo de **Feria Lunar**
@endcomponent