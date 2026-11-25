<?php
// require_once('wp-load.php');
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://www.google.com/recaptcha/api.js?render=6Le_rjQmAAAAAAYlaP8lHyGdQmj3pdGa1UIKghWy"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://js.sentry-cdn.com/e4ea85116019ec65a23123ddeb684ebc.min.js" crossorigin="anonymous"></script>
<style id="style-cruise">
    /* div.flatpickr-months > div {
        height: 50px !important;
    } */

    .flatpickr-month,
    body>div.flatpickr-calendar.animate.arrowTop.open>div.flatpickr-month {
        height: 70px !important;
    }

    .numInput {
        font-size: 15px;
        text-align: center;
        padding: 0px;
    }

    input[type=date],
    input[type=email],
    input[type=number],
    input[type=password],
    input[type=search],
    input[type=tel],
    input[type=text],
    input[type=url],
    select,
    textarea {
        background-color: #FBFBFB !important;
        border-color: #DADADA !important;
        border-radius: 10px 10px 10px 10px !important;
        color: #000000 !important;
        height: 59px !important;
    }

    label {
        height: 20px !important;
    }

    button {
        font-family: "Khula", Sans-serif !important;
        font-size: 20px !important;
        font-weight: 600 !important;
        border-radius: 10px 10px 10px 10px !important;
        min-height: 72px !important;
        padding: 0px !important;
    }

    /* Animation of pulse for the button */
    button:hover {
        animation: pulse 1s infinite;
        color: #BD0F12 !important;
        background-color: #FFFFFF !important;
        border: 1px solid #BD0F12 !important;
    }
/* 
    .row {
        margin-top: -20px !important;
    } */
	
	#reservation-form > .row {
		margin-top: 0 !important;
		margin-bottom: 16px;
	}

	#reservation-form .form-group {
		margin-bottom: 0;
	}

	#reservation-form label {
		display: block;
		height: auto !important;
		margin-bottom: 6px;
		line-height: 1.3;
	}
	
	@media screen and (min-width: 768px) and (max-width: 1025px) {

		#reservation-form > .row {
			margin-top: 0 !important;
			margin-bottom: 18px !important;
			row-gap: 18px;
		}

		#reservation-form .form-group {
			width: 100%;
		}

		#reservation-form label {
			position: static !important;
			display: block !important;
			width: 100%;
			height: auto !important;
			margin: 0 0 7px 0 !important;
			line-height: 1.25 !important;
		}

		#reservation-form input,
		#reservation-form select {
			width: 100% !important;
			margin: 0 !important;
		}

		#reservation-form #send-reservations {
			width: calc(100% - 24px);
			margin-left: 12px;
			margin-right: 12px;
		}
	}

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    #reservation-form #send-reservations:disabled,
    #reservation-form #send-reservations:disabled:hover {
        background-color: #BD0F12 !important;
        border-color: #BD0F12 !important;
        color: #ffffff !important;
        opacity: 0.65;
        animation: none !important;
        cursor: not-allowed;
    }

    #loader-content {
        display: none;
    }

    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }

    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 8px;
        border-radius: 50%;
        border: 6px solid #BD0F12;
        border-color: #BD0F12 transparent #BD0F12 transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }

    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    div:where(.swal2-container) button:where(.swal2-styled).swal2-confirm {
        border: 0 !important;
        border-radius: .25em !important;
        background: initial !important;
        background-color: #7066e0 !important;
        color: #fff !important;
        font-size: 1em !important;
        width: 60px !important;
    }

    div:where(.swal2-container) button:where(.swal2-styled).swal2-cancel {
        border: 0 !important;
        border-radius: .25em !important;
        background: initial !important;
        background-color: #6e7881 !important;
        color: #fff !important;
        font-size: 1em !important;
        width: 60px !important;
    }
.sdpark-calendar {
        font-family: Arial, sans-serif;
        background: #fff;
        border: 1px solid #dedede;
        border-radius: 8px;
        box-shadow: 0 12px 36px rgba(0,0,0,.18);
        padding-bottom: 12px;
        color: #232323;
    }
    .sdpark-calendar__heading {
        padding: 14px 18px;
        margin: 0;
        border-bottom: 1px solid #dedede;
        font-size: 15px !important;
        line-height: 1.4 !important;
        font-weight: 700;
        text-align: left;
    }
    .sdpark-calendar .flatpickr-months {
        padding: 8px 0;
    }
    .sdpark-calendar .flatpickr-month {
        height: 34px !important;
    }
    .sdpark-calendar .flatpickr-prev-month,
    .sdpark-calendar .flatpickr-next-month {
        top: 58px;
        height: 34px;
    }
    .sdpark-calendar .flatpickr-current-month {
        font-size: 16px !important;
    }
    .sdpark-calendar .flatpickr-current-month input.cur-year {
        height: auto !important;
        min-height: 0 !important;
        padding: 0 0 0 4px !important;
        border: 0 !important;
        background: transparent !important;
        border-radius: 0 !important;
        font-size: 16px !important;
        box-shadow: none !important;
    }
    .sdpark-calendar .flatpickr-weekday {
        color: #5d6167;
        font-size: 12px !important;
        font-weight: 600;
    }
    .sdpark-calendar .flatpickr-day {
        border-radius: 4px;
        font-size: 14px !important;
        font-weight: 600;
        color: #232323;
    }
    .sdpark-calendar .flatpickr-day:hover,
    .sdpark-calendar .flatpickr-day:focus {
        background: #fff4d1;
        border-color: #f4c542;
    }
    .sdpark-calendar .flatpickr-day.selected,
    .sdpark-calendar .flatpickr-day.selected:hover {
        color: #fff;
        background: #BD0F12;
        border-color: #BD0F12;
    }
    .sdpark-calendar .flatpickr-day.flatpickr-disabled,
    .sdpark-calendar .flatpickr-day.flatpickr-disabled:hover {
        color: #aaa;
        background: #fff;
        border-color: transparent;
        cursor: not-allowed;
    }
    .sdpark-calendar .sdpark-calendar__blocked {
        text-decoration: line-through;
    }

</style>

<div class="container">
    <div class="row">
        <form class="elementor-form" method="post" name="reservation-form" id="reservation-form" action="<?php echo bloginfo('url'); ?>/confirmation-cruise-page.php">
            <input type="hidden" id="recaptcha_token" name="recaptcha_token">
            <div class="row">
                <div class="col-6 ">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="hidden" name="validate_token" value="(ME4a9Qf3sSM^%cR">
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name *" required>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name *" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 ">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email *" required>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="form-group">
                        <label for="phone">Phone *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone*" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6 ">
                    <label for="drop_off">Drop Off *</label>
                    <input type="text" class="form-control flatpickr" name="drop_off" id="drop_off" placeholder="Drop Off*" required>
                </div>
                <div class="col-6 ">
                    <div class="form-group">
                        <label for="drop_off_time">Drop Off Time *</label>
                        <select class="form-select" name="drop_off_time" id="drop_off_time" aria-invalid="false" required>
                            <!-- <option value="" disabled selected>Drop Off Time *</option> -->
                            <option value="12:00 am">12:00 am</option>
                            <option value="12:30 am">12:30 am</option>
                            <option value="01:00 am">01:00 am</option>
                            <option value="01:30 am">01:30 am</option>
                            <option value="02:30 am">02:30 am</option>
                            <option value="03:00 am">03:00 am</option>
                            <option value="03:30 am">03:30 am</option>
                            <option value="04:00 am">04:00 am</option>
                            <option value="04:30 am">04:30 am</option>
                            <option value="05:00 am">05:00 am</option>
                            <option value="05:30 am">05:30 am</option>
                            <option value="06:00 am">06:00 am</option>
                            <option value="06:30 am">06:30 am</option>
                            <option value="07:00 am">07:00 am</option>
                            <option value="07:30 am">07:30 am</option>
                            <option value="08:00 am">08:00 am</option>
                            <option value="08:30 am">08:30 am</option>
                            <option value="09:00 am">09:00 am</option>
                            <option value="09:30 am">09:30 am</option>
                            <option value="10:00 am">10:00 am</option>
                            <option value="10:30 am">10:30 am</option>
                            <option value="11:00 am">11:00 am</option>
                            <option value="11:30 am">11:30 am</option>
                            <option value="12:00 pm">12:00 pm</option>
                            <option value="12:30 pm">12:30 pm</option>
                            <option value="01:00 pm">01:00 pm</option>
                            <option value="01:30 pm">01:30 pm</option>
                            <option value="02:00 pm">02:00 pm</option>
                            <option value="02:30 pm">02:30 pm</option>
                            <option value="03:00 pm">03:00 pm</option>
                            <option value="03:30 pm">03:30 pm</option>
                            <option value="04:00 pm">04:00 pm</option>
                            <option value="04:30 pm">04:30 pm</option>
                            <option value="05:00 pm">05:00 pm</option>
                            <option value="05:30 pm">05:30 pm</option>
                            <option value="06:00 pm">06:00 pm</option>
                            <option value="06:30 pm">06:30 pm</option>
                            <option value="07:00 pm">07:00 pm</option>
                            <option value="07:30 pm">07:30 pm</option>
                            <option value="08:00 pm">08:00 pm</option>
                            <option value="08:30 pm">08:30 pm</option>
                            <option value="09:00 pm">09:00 pm</option>
                            <option value="09:30 pm">09:30 pm</option>
                            <option value="10:00 pm">10:00 pm</option>
                            <option value="10:30 pm">10:30 pm</option>
                            <option value="11:00 pm">11:00 pm</option>
                            <option value="11:30 pm">11:30 pm</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="pick_up">Pick-Up *</label>
                        <input type="text" class="form-control flatpickr" name="pick_up" id="pick_up" placeholder="Pick-Up*" required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="pick_up_time">Pick-Up Time *</label>
                        <select class="form-select" name="pick_up_time" id="pick_up_time" aria-invalid="false" required>
                            <!-- <option value="" disabled selected>Pick-Up Time*</option> -->
                            <option value="12:00 am">12:00 am</option>
                            <option value="12:30 am">12:30 am</option>
                            <option value="01:00 am">01:00 am</option>
                            <option value="01:30 am">01:30 am</option>
                            <option value="02:30 am">02:30 am</option>
                            <option value="03:00 am">03:00 am</option>
                            <option value="03:30 am">03:30 am</option>
                            <option value="04:00 am">04:00 am</option>
                            <option value="04:30 am">04:30 am</option>
                            <option value="05:00 am">05:00 am</option>
                            <option value="05:30 am">05:30 am</option>
                            <option value="06:00 am">06:00 am</option>
                            <option value="06:30 am">06:30 am</option>
                            <option value="07:00 am">07:00 am</option>
                            <option value="07:30 am">07:30 am</option>
                            <option value="08:00 am">08:00 am</option>
                            <option value="08:30 am">08:30 am</option>
                            <option value="09:00 am">09:00 am</option>
                            <option value="09:30 am">09:30 am</option>
                            <option value="10:00 am">10:00 am</option>
                            <option value="10:30 am">10:30 am</option>
                            <option value="11:00 am">11:00 am</option>
                            <option value="11:30 am">11:30 am</option>
                            <option value="12:00 pm">12:00 pm</option>
                            <option value="12:30 pm">12:30 pm</option>
                            <option value="01:00 pm">01:00 pm</option>
                            <option value="01:30 pm">01:30 pm</option>
                            <option value="02:00 pm">02:00 pm</option>
                            <option value="02:30 pm">02:30 pm</option>
                            <option value="03:00 pm">03:00 pm</option>
                            <option value="03:30 pm">03:30 pm</option>
                            <option value="04:00 pm">04:00 pm</option>
                            <option value="04:30 pm">04:30 pm</option>
                            <option value="05:00 pm">05:00 pm</option>
                            <option value="05:30 pm">05:30 pm</option>
                            <option value="06:00 pm">06:00 pm</option>
                            <option value="06:30 pm">06:30 pm</option>
                            <option value="07:00 pm">07:00 pm</option>
                            <option value="07:30 pm">07:30 pm</option>
                            <option value="08:00 pm">08:00 pm</option>
                            <option value="08:30 pm">08:30 pm</option>
                            <option value="09:00 pm">09:00 pm</option>
                            <option value="09:30 pm">09:30 pm</option>
                            <option value="10:00 pm">10:00 pm</option>
                            <option value="10:30 pm">10:30 pm</option>
                            <option value="11:00 pm">11:00 pm</option>
                            <option value="11:30 pm">11:30 pm</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 ">
                    <div class="form-group">
                        <label for="how_did">How did you hear about us? *</label>
                        <select class="form-select" name="how_did" id="how_did" aria-invalid="false" required>
                            <option value="" disabled selected>How did you hear about us?*</option>
                            <option value="Google">Google</option>
                            <option value="Yelp">Yelp</option>
                            <option value="Friend">Friend</option>
                            <option value="Street Sign">Street Sign</option>
                            <option value="Yellow Pages">Yellow Pages</option>
                            <option value="Repeat Customer">Repeat Customer</option>
                        </select>
                    </div>
                </div>

                <button id="send-reservations" type="submit" class="btn btn-primary mt-3" style="color:#ffffff">Send</button>

                <div class="hidde-content" id="loader-content">
                    <div class="row d-flex justify-content-center align-items-center hidde-content">
                        <div class="lds-dual-ring"></div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    Sentry.onLoad(function() {
        Sentry.init({
            // Performance Monitoring
            tracesSampleRate: 1.0, // Capture 100% of the transactions
            // Session Replay
            replaysSessionSampleRate: 0.1, // This sets the sample rate at 10%. You may want to change it to 100% while in development and then sample at a lower rate in production.
            replaysOnErrorSampleRate: 1.0, // If you're not already sampling the entire session, change the sample rate to 100% when sampling sessions where errors occur.
        });
    });
</script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6Le_rjQmAAAAAAYlaP8lHyGdQmj3pdGa1UIKghWy', {
                action: 'validation_form_cruise'
            })
            .then(function(token) {
                document.getElementById('recaptcha_token').value = token;
            });
    });
</script>
<script id="script-cruise">
    // ACF Variables
const minDays = <?php echo max(1, (int) get_field('number_of_days', 80)); ?>;
    let rawDates = '<?php echo get_field('restrict_dates', 398); ?>';
    let dates_array = rawDates.split(',').map(dateString => {
        let [year, month, day] = dateString.split('-');
        return new Date(year, month - 1, day);
    });

    document.addEventListener("DOMContentLoaded", function() {
        flatpickr(".flatpickr", {
            enableTime: false,
            dateFormat: "m/d/Y",
            minDate: "today",
            disable: dates_array,
            altInput: true,
            altFormat: 'M j, Y',
            ariaDateFormat: 'F j, Y',
            showMonths: window.innerWidth >= 760 ? 2 : 1,
            monthSelectorType: 'static',
            disableMobile: true,
            allowInput: false,
            onReady: function (dates, value, picker) {
                picker.calendarContainer.classList.add('sdpark-calendar');
                const heading = document.createElement('div');
                heading.className = 'sdpark-calendar__heading';
                heading.textContent = picker.input.id === 'drop_off' ? 'Drop-off date' : 'Pick-up date';
                picker.calendarContainer.prepend(heading);
                picker.altInput.setAttribute('aria-label', heading.textContent);
                picker.altInput.setAttribute('aria-haspopup', 'dialog');
                picker.calendarContainer.setAttribute('role', 'dialog');
                picker.calendarContainer.setAttribute('aria-label', heading.textContent);
            },
            onOpen: function (dates, value, picker) {
                picker.set('showMonths', window.innerWidth >= 760 ? 2 : 1);
                if (picker.input.id === 'pick_up') {
                    const startPicker = document.getElementById('drop_off')._flatpickr;
                    const start = startPicker && startPicker.selectedDates[0];
                    if (start) {
                        picker.set('minDate', start);
                        picker.jumpToDate(start);
                    }
                }
                picker.altInput.setAttribute('aria-expanded', 'true');
            },
            onChange: function (dates, value, picker) {
                if (picker.input.id === 'drop_off' && dates[0]) {
                    const endInput = document.getElementById('pick_up');
                    const endPicker = endInput._flatpickr;
                    if (endPicker) {
                        endPicker.set('minDate', dates[0]);
                        endPicker.jumpToDate(dates[0]);
                        endInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                }
            },
            onClose: function (dates, value, picker) {
                picker.altInput.setAttribute('aria-expanded', 'false');
            },
            onDayCreate: function (dates, value, picker, day) {
                if (dates_array.some(function (blocked) {
                    return blocked.getFullYear() === day.dateObj.getFullYear()
                        && blocked.getMonth() === day.dateObj.getMonth()
                        && blocked.getDate() === day.dateObj.getDate();
                })) {
                    day.classList.add('sdpark-calendar__blocked');
                    day.title = 'Unavailable';
                }
            },
        });
    });

    const pickUp = document.getElementById("pick_up");
    const dropOff = document.getElementById("drop_off");
    const pickUpTime = document.getElementById("pick_up_time");
    const dropOffTime = document.getElementById("drop_off_time");
    const loaderSubmit = document.getElementById("loader-content");
    const reservationButton = document.getElementById("send-reservations");
    // phone for focus
    const phoneFocus = document.getElementById("phone");


    const bookingForm = document.getElementById('reservation-form');
    const bookingError = document.createElement('p');
    bookingError.setAttribute('role', 'alert');
    bookingError.id = 'booking-time-error';
    bookingError.style.cssText = 'display:none;font-size:13px!important;line-height:1.4!important;font-weight:400!important;letter-spacing:0!important;color:#b00020;padding:6px 0!important;margin:0!important;';
    pickUpTime.insertAdjacentElement('afterend', bookingError);
    pickUpTime.setAttribute('aria-describedby', bookingError.id);
    if (!Array.from(pickUpTime.options).some(function (option) { return option.value === ''; })) {
        const placeholder = new Option('Select pick-up time', '');
        placeholder.disabled = true;
        pickUpTime.insertBefore(placeholder, pickUpTime.firstChild);
    }

    function bookingTimestamp(dateValue, timeValue) {
        const date = /^(\d{2})\/(\d{2})\/(\d{4})$/.exec(dateValue);
        const time = /^(\d{2}):(\d{2})\s(am|pm)$/i.exec(timeValue);
        if (!date || !time) return NaN;
        const hour = Number(time[1]);
        const minute = Number(time[2]);
        if (hour < 1 || hour > 12 || minute > 59) return NaN;
        const hours = hour % 12 + (time[3].toLowerCase() === 'pm' ? 12 : 0);
        const wallTime = Date.UTC(Number(date[3]), Number(date[1]) - 1, Number(date[2]), hours, minute);
        const formatter = new Intl.DateTimeFormat('en-US', {
            timeZone: 'America/Los_Angeles', year: 'numeric', month: '2-digit',
            day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit',
            hourCycle: 'h23'
        });
        let timestamp = wallTime;
        // Resolve the selected San Diego time independently of the visitor's timezone.
        for (let attempt = 0; attempt < 4; attempt++) {
            const parts = {};
            formatter.formatToParts(new Date(timestamp)).forEach(function (part) {
                parts[part.type] = part.value;
            });
            const represented = Date.UTC(Number(parts.year), Number(parts.month) - 1,
                Number(parts.day), Number(parts.hour), Number(parts.minute), Number(parts.second));
            if (represented === wallTime) return timestamp;
            timestamp += wallTime - represented;
        }
        return NaN;
    }

    function validateBooking() {
        if (!dropOff.value || !pickUp.value || !dropOffTime.value || !pickUpTime.value) {
            reservationButton.disabled = true;
            return false;
        }
        const start = bookingTimestamp(dropOff.value, dropOffTime.value);
        const end = bookingTimestamp(pickUp.value, pickUpTime.value);
        let message = '';
        if (!Number.isFinite(start) || !Number.isFinite(end)) {
            message = 'Please choose valid dates and times.';
        } else if (end <= start) {
            message = 'Pick-up must be after drop-off.';
        } else if (end - start < minDays * 86400000) {
            message = 'Minimum stay: ' + (minDays * 24) + ' hours. Please choose a later pick-up time or date.';
        }
        pickUpTime.setCustomValidity(message);
        pickUpTime.setAttribute('aria-invalid', message ? 'true' : 'false');
        if (message) {
            pickUpTime.value = '';
        }
        bookingError.textContent = message;
        bookingError.style.display = message ? 'block' : 'none';
        reservationButton.disabled = message !== '';
        return message === '';
    }

    [dropOff, pickUp, dropOffTime, pickUpTime].forEach(function (field) {
        field.addEventListener('change', validateBooking);
    });
    validateBooking();
    bookingForm.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!validateBooking() || !bookingForm.checkValidity()) {
            bookingForm.reportValidity();
            return;
        }
        loaderSubmit.style.display = 'block';
        reservationButton.style.display = 'none';
        bookingForm.submit();
    });
</script>
