@if($record && $record->letter_file_pdf)
    <iframe src="{{ asset('storage/' . $record->letter_file_pdf) }}" width="100%" height="500px"></iframe>
@else
    <p>No PDF available.</p>
@endif