<?php

/**
 * Template Name: Confirmation Cruise Page 
 * Template Post Type: page
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . '/wp-load.php';

// Check the actual stay length before the email template reads the submitted dates.
$bookingZone = new DateTimeZone('America/Los_Angeles');
$parseBookingTime = static function ($date, $time) use ($bookingZone) {
    if (!is_string($date) || !is_string($time)) {
        return null;
    }
    $value = trim($date) . ' ' . strtolower(trim($time));
    $parsed = DateTimeImmutable::createFromFormat('!m/d/Y h:i a', $value, $bookingZone);
    return $parsed && $parsed->format('m/d/Y h:i a') === $value ? $parsed : null;
};
$bookingStart = $parseBookingTime($_POST['drop_off'] ?? null, $_POST['drop_off_time'] ?? null);
$bookingEnd = $parseBookingTime($_POST['pick_up'] ?? null, $_POST['pick_up_time'] ?? null);
$bookingMinimumDays = max(1, (int) get_field('number_of_days', 80));
if (!$bookingStart || !$bookingEnd
    || $bookingEnd <= $bookingStart
    || $bookingEnd->getTimestamp() - $bookingStart->getTimestamp() < $bookingMinimumDays * 86400) {
    header('Location: /reservation-error', true, 303);
    exit;
}

require_once('./email-cruise.php');
require_once('./confirm-reservations/api/index.php');
require_once('./confirm-reservations/api/cc-cruise.php');
require_once('./confirm-reservations/api/constant-contact-api.php');

// Recaptcha
if (empty($_POST)) {
    header("Location: /reservation-error");
    exit();
}

// 
if (!isset($_POST['validate_token']) || $_POST['validate_token'] != '(ME4a9Qf3sSM^%cR') {
    header("Location: /reservation-error");
    exit();
}

//
$drop_off_timestamp = $bookingStart->getTimestamp();
$pick_up_timestamp = $bookingEnd->getTimestamp();
$days_diff = (int) ceil(($pick_up_timestamp - $drop_off_timestamp) / 86400);

$recaptcha_token = $_POST['recaptcha_token'];
$secret_key = '6Le_rjQmAAAAAFNU3TV8StICdqcXJ-BCaGrnbVVh';

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptcha_token);
$response_data = json_decode($response);

// Validation for POST
// if (!$response_data->success) {
//     header("Location: /reservation-error");
//     exit();
// } 

// Production Variables
$client_name = $_POST['first_name'] . ' ' . $_POST['last_name'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$drop_off = $_POST['drop_off'];
$drop_off_time = $_POST['drop_off_time'];
$pick_up = $_POST['pick_up'];
$pick_up_time = $_POST['pick_up_time'];
$how_did = $_POST['how_did'];
$lot = 'LOT C';
$admin_email = 'rene@sdparkshuttleandfly.com';
// $admin_email = 'diego.sungar@gmail.com';

// Email Functions
sendAdminEmailCruise($client_name, $admin_email, $email_subject, $how_did, $cust_email4);
sendCustomerEmailCruise($email, $email_subject_customer, $cust_email4);

// API Variables and Function
$api_key_sd_park = 'uQzXqNK5LfuuESXsyfq0SJoO7E0fAICT';
$api_url = 'https://reservations.sdparkshuttlefly.com/public/api/reservation';

createReservationAPI($api_key_sd_park, $api_url, $first_name, $last_name, $email, $phone, $lot, $drop_off, $drop_off_time, $pick_up, $pick_up_time, $how_did);

// Constant Contact Functions
// $listNumber = "1378820122";
// $listNumberCruises = "1460272404";
// createOrUpdateContact($email, $first_name, $last_name, $phone, $how_did, $listNumber, $admin_email);
// createOrUpdateContactCruise($email, $first_name, $last_name, $phone, $how_did, $listNumberCruises, $admin_email);
// List IDs
$general_list_id = '6c39d840-77d0-11e3-a12f-d4ae529a8250';
$cruise_list_id = '4436ef4c-5b9a-11ed-8f10-fa163e37306a';
//
$refreshToken = 'zbJA6XyTk-cSznOXDXN05UUCHszYXnoHdKHV5DLKlho';
$clientId = 'ffffdf2a-8751-4a60-bf6f-88b247f65c0f';
$clientSecret = 'fIBCZtt07UKSAz8_Vy4e7g';
$json_array = json_decode(refreshToken($refreshToken, $clientId, $clientSecret));
$accessToken = $json_array->access_token;
// Functions
createContact($accessToken, $email, $first_name, $last_name, $how_did, $general_list_id);
createContact($accessToken, $email, $first_name, $last_name, $how_did, $cruise_list_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-TNHHRW7');
    </script>
    <!-- End Google Tag Manager -->
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '247799299543519');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=247799299543519&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <title>Confirmation Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TNHHRW7"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <style>
        table {
            font-size: 20px;
        }

        body>div:nth-child(2)>div>a {
            background-color: #ce363f;
            border: none;
        }
    </style>
    <div class="container mt-4">
        <div class="col-md-12 text-center">
            <h1>Your Confirmation for your Airport Parking at SD Park Shuttle and FLY</h1>
            <h1 style="color:#ce363f;"><b>NO BARCODE/QR CODE TAKE A TICKET</b></h1>
            <!-- Button to go back to the home page -->
            <a href="https://sdparkshuttlefly.com/" class="btn btn-primary" style="background:#ce363f;">Go Back to Home Page</a>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <br><br>
                <p>An email went out with your reservation information. Please check your spam if you do not see it in your inbox.</p>
                <p>Thank you for using our online reservation system. We look forward to serving you!</p>
                <p><b>With 15+ years in airport parking, we provide reliable and secure solutions.</b></p>
                <br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 text-center">

                <p>
                    <b style="color:#ce363f;">SD Park Shuttle and Fly Lot A</b><br>
                    3405 Pacific Highway <br>
                    San Diego Ca 92101 <br>
                    Phone: 619-291-1234 <br>
                    Pricing: <b>$<?php echo $rate; ?>/24 hours</b> <br>
                    <span style="color:red;">Payment due at Exit</span> <br />
                    <a href="https://sdparkshuttlefly.com/coupons/">Rate By Presenting Coupon - Regular Rate $24.95</a> <br />
            </div>
            <div class="col-md-6 text-center">
                <?php echo '<p>Customer Name: ' . $client_name . '<br>
                    Customer Email: ' . $email . '<br>
                    Customer Phone: ' . $phone . '<br>
                    Drop Off Information: ' . $drop_off . ' ' . $drop_off_time . '<br>
                    Pick Up Information: ' . $pick_up . ' ' . $pick_up_time . '</p>'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p style="color:#ce363f; margin:20px 0px;"><b style="color:#ce363f;">
                        SUGGESTION:</b>
                    Due to the overwhelming demand for Cruise ship parking, it is SUGGESTED that parties of 4 or more drop off ALL their family members and luggage at the Cruise Ship Terminal PRIOR to parking. This allows for shorter, quicker shuttle time frames to and from the Cruise Ship terminal.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <br><br>
                <?php echo $rate_table; ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <br><br><br>
                <p>
                    <b>Miscellaneous Information:</b> <br>
                    <b>NOTE: PLEASE ARRIVE AT OUR FACILITY AT LEAST 2-3 HOURS PRIOR TO YOUR DEPARTURE TIME TO ENSURE YOU ARRIVE AT THE AIRPORT WITH AMPLE TIME!</b>
                </p>

                <p>
                    <b>Welcome Patrons</b>
                    <p>
                        Your Parking fee covers vehicle storage ONLY. <br />
                        To make your travels easier, our complimentary shuttle is a FREE, OPTIONAL service provided for your convenience.
                    </p>
                    <p>
                        Courtesy Shuttles to and from the Cruise Ship Terminal run 24 hours a day, 7 days a week, ON DEMAND ONLY.
                        As the shuttle is a complimentary amenity, guests who elect to use alternative transportation services (such as Uber, Lyft, or taxis) do so at their own discretion and convenience. Any associated costs are the responsibility of the guest and will not be covered, credited, or reimbursed by management.
                        <br/> <br />
                        Thank you for your understanding.
                    </p>
                </p>

                <p>
                    <b>Be advised that Parking is paid at the end of your trip. Please be prepared to pay for parking at the end of your trip.</b>
                </p>

                <p style="color:#ce363f"><b style="color:#ce363f">
                        A reservation made for a specific parking facility is good for both LOT A and/or LOT B regardless of which property you have chosen in the initial reservation.</b>
                </p>

                <p>
                    <b>Hours of Operation:</b> <br>
                    Open 24 Hours a Day, 7 Days a Week!
                </p>


                <p>
                    <b>Modification Policy:</b> <br>
                    to advise parking facility 24 hours prior to original reservation.
                </p>

                <p>
                    <b>Refund/Cancellation Policy:</b> <br>
                    ALL SALES ARE FINAL! NO REFUNDS! Customer cannot cancel or receive a refund once services have been rendered.
                </p>

                <?php if ($lot == 'LOT A') { ?>

                    <!--<p>-->
                    <!--    <b>Driving Directions:</b> <br>-->
                    <!--    <b>I-5 Freeway Southbound</b> Exit San Diego Airport/Sassafras Street. Turn right onto Sassafras Street at the first traffic signal light then turn right onto Pacific Highway, once on Pacific Highway our entrance is IMMEDIATELY ON THE LEFT.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>I-5 Freeway Northbound</b> Exit Sassafras/India Street, Turn left onto Sassafras Street at the first traffic signal light then turn right onto Pacific Highway, once on Pacific Highway our entrance is IMMEDIATELY ON THE LEFT.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>From SR 163 South</b> take I-5 North/ San Diego Freeway toward Los Angeles. Exit Sassafras/India Street, Turn left onto Sassafras Street at the first traffic signal light then turn right onto Pacific Highway, once on Pacific Highway our entrance is IMMEDIATELY ON THE LEFT.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>I-8 Freeway Westbound</b> Take ramp right for I-5 South/San Diego Freeway. Exit San Diego Airport/ Sassafras Street, Turn right onto Sassafras Street at the first traffic signal light then turn right onto Pacific Highway, once on Pacific Highway our entrance is IMMEDIATELY ON THE LEFT.-->
                    <!--</p>-->

                <?php } else { ?>

                    <!--<p>-->
                    <!--    <b>Driving Directions:</b> <br>-->
                    <!--    <b>I-5 Freeway Southbound Exit San Diego Airport/Sassafras Street.</b> Turn right onto Sassafras Street at the first traffic signal light then cross the train tracks and our entrance is IMMEDIATELY ON THE RIGHT before Pacific Highway.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>I-5 Freeway Northbound</b> - Exit Sassafras/India Street, Turn left onto Sassafras Street at the first traffic signal light then cross the train tracks and our entrance is IMMEDIATELY ON THE RIGHT before Pacific Highway.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>From SR 163 South - take I-5 North/ San Diego Freeway toward Los Angeles.</b> Exit Sassafras/India Street, Turn left onto Sassafras Street at the first traffic signal light then cross the train tracks and our entrance is IMMEDIATELY ON THE RIGHT before Pacific Highway.-->
                    <!--</p>-->

                    <!--<p>-->
                    <!--    <b>I-8 Freeway Westbound - Take ramp for I-5 South/San Diego Freeway. </b> Exit San Diego Airport/ Sassafras Street, Turn right onto Sassafras Street at the first traffic signal light then cross the train tracks and our entrance is IMMEDIATELY ON THE RIGHT before Pacific Highway.-->
                    <!--</p>-->

                <?php } ?>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
