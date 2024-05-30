<!-- resources/views/credit-transfer/result.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Credit Transfer Result</title>
</head>
<body>
    <h1>Credit Transfer Result</h1>
    <p>European Credits (ECTS): {{ $ectsCredits }}</p>
    <p>Equivalent UTM Credits: {{ $utmCredits }}</p>

    <a href="{{ route('credit-transfer.form') }}">Back</a>
</body>
</html>
