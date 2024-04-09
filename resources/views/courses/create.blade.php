<form method="POST" action="{{ route('courses.store') }}">
    @csrf
    <label for="course_data">Paste Course Data:</label><br>
    <textarea id="course_data" name="course_data" rows="4" required></textarea><br>

    <!-- Dropdown for year_semester -->
    <label for="year_semester">Year and Semester:</label><br>
    <select id="year_semester" name="year_semester" required>
        <option value="Year 1: Semester 1">Year 1: Semester 1</option>
        <option value="Year 1: Semester 2">Year 1: Semester 2</option>
        <option value="Year 2: Semester 1">Year 2: Semester 1</option>
        <option value="Year 2: Semester 2">Year 2: Semester 2</option>
        <option value="Year 3: Semester 1">Year 3: Semester 1</option>
        <option value="Year 3: Semester 2">Year 3: Semester 2</option>
        <option value="Year 4: Semester 1">Year 4: Semester 1</option>
        <option value="Year 4: Semester 2">Year 4: Semester 2</option>
    </select><br>

    <!-- Text input for description -->
    <label for="description">Description (Optional):</label><br>
    <textarea id="description" name="description" rows="2"></textarea><br>

    <!-- Text input for day and timeslot -->
    <label for="day_and_timeslot">Day and Timeslot (comma-separated for multiple):</label><br>
    <input type="text" id="day_and_timeslot" name="day_and_timeslot"><br>


    <button type="submit">Submit</button>
</form>
