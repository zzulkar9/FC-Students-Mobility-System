<form method="POST" action="{{ route('courses.store') }}">
    @csrf
    <label for="course_data">Paste Course Data:</label><br>
    <textarea id="course_data" name="course_data" rows="4" required></textarea><br>
    <button type="submit">Submit</button>
</form>
