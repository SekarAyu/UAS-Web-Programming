<select name="course_id">
    @foreach ($courses as $course)
        <option value="{{ $course->id }}">{{ $course->CourseName }}</option>
    @endforeach
</select>

<select name="instructor_id">
    @foreach ($qualifiedInstructors as $instructor)
        <option value="{{ $instructor->id }}">{{ $instructor->InstructorName }}</option>
    @endforeach
</select>