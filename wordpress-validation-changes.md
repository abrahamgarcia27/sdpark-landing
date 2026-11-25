# Ajustes de validacion para WordPress

Las lineas corresponden a los archivos compartidos. Ubica tambien las funciones por nombre porque la numeracion cambiara al editar. Estos cambios exigen un minimo de dias completos de 24 horas. El servidor es la autoridad para la zona horaria de San Diego.

## 1. Frontend: minimo con respaldo

En `reservation.php`, linea 429, y `cruise.php`, linea 400, sustituye la declaracion de `minDays` por:

```php
const minDays = <?php echo max(1, (int) get_field('number_of_days', 80)); ?>;
```

Ambos formularios actualmente leen el registro ACF 80. Este ajuste conserva esa configuracion compartida.

## 2. Frontend: reemplazar la validacion antigua

En `reservation.php`, reemplaza desde `// Validation for days` (linea 478) hasta el final de `oldValidateMinDaysTime`, antes de `</script>`. Elimina tambien la funcion `validateReservation` de las lineas 453-476 porque sus llamadas se reemplazan aqui.

En `cruise.php`, reemplaza desde `// Validation for days` (linea 425) hasta el final de `oldValidateMinDaysTime`, antes de `</script>`.

Pega el mismo bloque en ambos archivos. Conserva las declaraciones anteriores de `dropOff`, `pickUp`, `dropOffTime`, `pickUpTime`, `loaderSubmit` y `reservationButton`.

```javascript
const bookingForm = document.getElementById('reservation-form');

function readBookingDate(dateField, timeField) {
    const value = dateField.value + ' ' + timeField.value;
    const parsed = flatpickr.parseDate(value.toUpperCase(), 'm/d/Y h:i K');
    return parsed && Number.isFinite(parsed.getTime()) ? parsed : null;
}

function checkBookingDates() {
    pickUpTime.setCustomValidity('');
    if (!dropOff.value || !pickUp.value || !dropOffTime.value || !pickUpTime.value) {
        return false;
    }

    const start = readBookingDate(dropOff, dropOffTime);
    const end = readBookingDate(pickUp, pickUpTime);
    let message = '';
    if (!start || !end) {
        message = 'Please choose valid dates and times.';
    } else if (end <= start) {
        message = 'Pick-up must be after drop-off.';
    } else if (end.getTime() - start.getTime() < minDays * 86400000) {
        message = 'Reservation must be at least ' + minDays + ' day(s).';
    }

    pickUpTime.setCustomValidity(message);
    return message === '';
}

[dropOff, pickUp, dropOffTime, pickUpTime].forEach(function (field) {
    field.addEventListener('change', checkBookingDates);
});

bookingForm.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!checkBookingDates() || !bookingForm.checkValidity()) {
        bookingForm.reportValidity();
        return;
    }
    loaderSubmit.style.display = 'block';
    reservationButton.style.display = 'none';
    bookingForm.submit();
});
```

Este bloque compara horas completas y vuelve a validar al enviar. El calendario conserva sus fechas restringidas. La comprobacion JavaScript usa el calendario del navegador. En viajes que crucen cambios de horario de verano y con visitantes en otra zona puede diferir del servidor. La validacion PHP siguiente aplica las horas reales en San Diego y rechaza fechas pasadas.

## 3. Backend: validar antes de generar correos

En ambos archivos `confirmation-page.php` y `confirmation-cruise-page.php`, agrega este bloque inmediatamente ANTES del primer `require_once('./email-...php')`, actualmente en la linea 11. El bloque carga WordPress antes de consultar ACF.

```php
require_once __DIR__ . '/wp-load.php';

function sdpark_reject_booking() {
    header('Location: /reservation-error', true, 303);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sdpark_reject_booking();
}

foreach (['first_name', 'last_name', 'email', 'phone', 'drop_off',
          'drop_off_time', 'pick_up', 'pick_up_time', 'how_did'] as $field) {
    if (!isset($_POST[$field]) || !is_string($_POST[$field]) || trim($_POST[$field]) === '') {
        sdpark_reject_booking();
    }
}
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    sdpark_reject_booking();
}

$bookingZone = new DateTimeZone('America/Los_Angeles');
function sdpark_parse_booking_time($date, $time, $zone) {
    $value = trim($date) . ' ' . strtolower(trim($time));
    $parsed = DateTimeImmutable::createFromFormat('!m/d/Y h:i a', $value, $zone);
    if (!$parsed || $parsed->format('m/d/Y h:i a') !== $value) {
        return null;
    }
    return $parsed;
}

$bookingStart = sdpark_parse_booking_time($_POST['drop_off'], $_POST['drop_off_time'], $bookingZone);
$bookingEnd = sdpark_parse_booking_time($_POST['pick_up'], $_POST['pick_up_time'], $bookingZone);
$bookingMinimumDays = max(1, (int) get_field('number_of_days', 80));

if (!$bookingStart || !$bookingEnd
    || $bookingStart < new DateTimeImmutable('now', $bookingZone)
    || $bookingEnd <= $bookingStart
    || $bookingEnd->getTimestamp() - $bookingStart->getTimestamp() < $bookingMinimumDays * 86400) {
    sdpark_reject_booking();
}
```

Estas funciones tienen el mismo nombre en ambos archivos porque cada archivo atiende una pagina independiente. No incluyas ambas paginas de confirmacion en una misma peticion.

Solo en `confirmation-page.php`, agrega tambien antes del primer require del correo:

```php
if (!isset($_POST['lot']) || !is_string($_POST['lot'])
    || !in_array($_POST['lot'], ['LOT A', 'LOT B'], true)) {
    sdpark_reject_booking();
}
```

En ambos archivos elimina el bloque antiguo de fechas: desde `if (!is_string($_POST['drop_off']) ...` hasta el final del rechazo por `$days_diff`. Corresponde a las lineas 29-42 de normal y 29-44 de cruise. En su lugar deja:

```php
$drop_off_timestamp = $bookingStart->getTimestamp();
$pick_up_timestamp = $bookingEnd->getTimestamp();
$days_diff = (int) ceil(($pick_up_timestamp - $drop_off_timestamp) / 86400);
```

El redondeo se conserva para calcular dias facturables despues de validar la duracion exacta.

## 4. Tarifa de un dia

Si el cupon de $18.95 debe aplicar tambien a una estancia de exactamente 24 horas, modifica ambos sitios que definen la tarifa normal.

En `email-reservation.php`, sustituye el `if ($days_diff == 1)` de las lineas 32-36 por:

```php
$parking_rate = '18.95';
```

En `confirmation-page.php`, sustituye el bloque de las lineas 72-80 por:

```php
$parking_rate = '18.95';
$pricing_display = '$18.95/24 hours';
```

Asi el correo y la pantalla utilizan la misma tarifa. El fee de $4.75 permanece en su calculo actual. Cruise obtiene sus tarifas de ACF y requiere revisar esos valores si tambien aparecen tarifas incorrectas.

## 5. Otros problemas detectados que requieren cambios coordinados

- reCAPTCHA: el rechazo del backend esta comentado. Hay que renovar el token en el frontend justo al enviar y comprobar en PHP `success`, `action`, `score` y el hostname esperado. Habilitar solamente el bloque comentado puede provocar fallos por tokens generados cuando se abrio el formulario.
- API y correos: mover los envios despues de `createReservationAPI()` requiere comprobar como esa funcion devuelve errores y exitos. Hace falta revisar `confirm-reservations/api/index.php` para dar el reemplazo exacto. La confirmacion debe depender de un registro exitoso.
- HTML: al imprimir nombre, email, telefono y fechas, envolver cada valor con `htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8')`. Aplicarlo tambien al construir los templates de correo. Conservar sin escapar los bloques HTML intencionales como `$rate_table` y `$lot_info`.
- Fechas restringidas: los handlers compartidos no consultan las listas ACF que usa el calendario. Deben comprobarse en el servidor usando la misma politica de bloqueo de fechas.
- Produccion: cambiar `ini_set('display_errors', 1)` a `ini_set('display_errors', 0)` en ambas paginas para que los errores no se impriman antes de las redirecciones. Consultar los errores en el log del servidor.

## 6. Comprobacion antes de publicar

Probar en staging con el minimo ACF configurado en 1 dia:

- Entrada 6:00 pm, salida del dia siguiente 5:30 am: rechazar.
- Entrada 6:00 pm, salida del dia siguiente 6:00 pm: aceptar.
- Salida igual o anterior a entrada: rechazar.
- Entrada en el pasado: rechazar desde PHP.
- Cambiar las horas despues de elegir fechas: volver a validar.
- Enviar un POST directo con 11.5 horas: rechazar antes de enviar correos o registrar.
- Configurar minimo 2 dias: rechazar 24 horas y aceptar 48 horas.

Los fragmentos son instrucciones de edicion. No se modificaron los archivos de Downloads ni se probaron contra el WordPress del servidor.
