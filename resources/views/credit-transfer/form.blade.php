<!-- resources/views/credit-transfer/form.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>ECTS to UTM Credit Conversion</title>
</head>
<body>
    <h1>ECTS to UTM Credit Conversion</h1>
    <form action="{{ route('credit-transfer.calculate') }}" method="POST">
        @csrf
        <div>
            <label for="ects_credits">European Credits (ECTS):</label>
            <input type="number" id="ects_credits" name="ects_credits" step="0.01" required>
        </div>
        <button type="submit">Calculate</button>
    </form>
</body>
</html>
