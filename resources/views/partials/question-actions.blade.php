<div class="col-12 d-flex justify-content-center">
    <!-- Form for deleting the question -->
    <form id="deleteForm{{ $question->question_id }}" 
          action="{{ url('/delete-typing-test-question/' . $question->question_id) }}" 
          method="POST">
        @csrf
        @method("DELETE")
        <button type="button" class="custom-btn btn btn-xs btn-danger ml-1" onclick="confirmDelete({{ $question->question_id }})">
            <i class="bi bi-trash-fill"></i>
        </button>
    </form>
    <!-- Edit button -->
    <a href="{{ url('/edit-typing-test-question/' . $question->question_id) }}" class="custom-btn btn btn-warning btn-xs ml-1">
        <i class="bi bi-pencil-square"></i>
    </a>
</div>