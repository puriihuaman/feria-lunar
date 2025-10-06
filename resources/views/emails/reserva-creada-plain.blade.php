Buenos días, {{ $reserva->name }}

Les saluda Feria Lunar 🌙

Su reserva ha sido registrada con éxito.

Para asegurar su participación en la próxima edición de la feria del 
{{ \Carbon\Carbon::parse($reserva->reservation_date)->translatedFormat('l d \d\e F') }}, 
solo falta completar el pago correspondiente.

------------------------------------------------------------
🏢 Información del Stand Reservado
------------------------------------------------------------
Sede: {{ $reserva->sedeStand->sede->title }}
Dirección: {{ $reserva->sedeStand->sede->address }}
Stand N°: {{ $reserva->sedeStand->stand->booth_number }}
Categoría: {{ ucfirst($reserva->sedeStand->stand->category) }}
Precio: S/ {{ number_format($reserva->sedeStand->price, 2) }}

------------------------------------------------------------
🛍️ Incluye por stand:
------------------------------------------------------------
- 1 toldo de 2x2 m
- 1 mesa
- 1 silla

Costo por stand: S/ {{ number_format($reserva->price, 2) }}
Fecha: {{ \Carbon\Carbon::parse($reserva->reservation_date)->format('d/m/Y') }}
Ubicación: {{ $reserva->sedeStand->sede->address }}

------------------------------------------------------------
⏳ Importante:
------------------------------------------------------------
Dispone de 1 hora para realizar el pago desde el momento de la reserva.
Pasado este tiempo, el espacio quedará liberado automáticamente 
y podrá ser asignado a otro expositor.

Una vez confirmado el pago, recibirá un nuevo correo con la confirmación 
final de su stand y los detalles de ubicación dentro del plano del evento.

------------------------------------------------------------
Equipo Feria Lunar
------------------------------------------------------------
Feria Lunar 🌙 - Donde tus productos destacan y tus ventas crecen 🚀
