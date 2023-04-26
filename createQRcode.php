<?php 
// Include the QR code generator library
require_once('phpqrcode/qrlib.php');

// Define the data to be encoded in the QR code
$data = "https://example.com/linkDevice.php?qr_code=d1c5df1d6vs5dvs5d1vs";

// Set the error correction level (L, M, Q, H)
$errorCorrectionLevel = 'L';

// Set the size of the QR code (1-10, 4 is default)
$matrixPointSize = 4;

// Generate the QR code image as a data URI
// $qrCodeData = QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize);
// $qrCodeImage = "data:image/png;base64," . base64_encode($qrCodeData);

// // Display the QR code image
// echo "<img src='$qrCodeImage' alt='QR code'>";