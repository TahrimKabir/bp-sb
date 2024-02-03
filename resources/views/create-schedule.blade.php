{{-- start --}}
@extends('dashboard')
@section('style')
    <!-- Google Font: Source Sans Pro -->
    @include('layouts.selectbox')
    <style>
        /* Optional styling for frame, container, checkbox list, search bar */
        iframe {
            border: 1px solid #ccc;
            width: 300px;
            height: 200px;
        }

        .checkbox-container {
            height: 100%;
            overflow-y: auto;
            /* Enable scrollbar */
        }

        .checkbox-list {
            list-style: none;
            padding: 0;
        }

        .checkbox-list li {
            margin-bottom: 5px;
        }

        .checkbox-list label {
            display: block;
        }

        #search-bar {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8 justify-content-center mt-5">
                        <div class="card">
                            <div class="card-header clr-dark-green text-white">
                                <h2 class="display-6 mb-0 text-center">
                                    Fix Exam Schedule
                                </h2>
                            </div>
                            <div class="card-body">
                                <div id="message-container">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    @if (session('fail'))
                                        <div class="alert alert-danger">
                                            {{ session('fail') }}
                                        </div>
                                    @endif
                                </div>
                                <form action="{{ route('store-schedule') }}" method="post" onsubmit="submitForm()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="configuration" class="d-block mb-0">Configuration Name
                                                <input type="text" name="configuration" id="configuration"
                                                    class="form-control" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="exam" class="d-block mb-0">Select Exam
                                                <select name="exam_id" id="exam" class="select2 form-control"
                                                    style="width:100%;" required>
                                                    @if ($exam != null)
                                                        @foreach ($exam as $e)
                                                            <option value="{{ $e->exam_id }}">{{ $e->exam_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="numques" class="d-block mb-0">Number of Questions
                                                <input type="number" name="numques" id="numques" class="form-control"
                                                    required>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-md-0 mt-2">
                                            <label for="pmark" class="d-block mb-0">Pass Mark
                                                <input type="number" name="pmark" id="pmark" class="form-control"
                                                    required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="date" class="d-block mb-0">Date
                                                <input type="date" name="date" id="date" class="form-control"
                                                    required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="stime" class="d-block mb-0">Start Time
                                                <input type="time" name="stime" id="stime" class="form-control"
                                                    required>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-md-0 mt-2">
                                            <label for="etime" class="d-block mb-0">End Time
                                                <input type="time" name="etime" id="etime" class="form-control"
                                                    required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="rank" class="d-block mb-0">Rank
                                                <select name="rank" id="rank" class="form-control"
                                                    style="width:100%;" onchange="filterPoliceOptions()">

                                                    @if ($rank != null)
                                                        @foreach ($rank as $r)
                                                            <option value="{{ $r->post }}">{{ $r->post }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        {{-- <div class="col-12" id="in"> --}}
                                          
                                            {{-- <label class="d-block mb-0" for="bpid">Select Police

                                                <select class="duallistbox" multiple="multiple" name="bpid[]"
                                                    id="bpid">

                                                    @if ($member != null)
                                                        @foreach ($member as $m)
                                                            <option value="{{ $m->bpid }}"
                                                                data-rank="{{ $m->post }}">
                                                                {{ $m->name_bn }}-{{ $m->post }}{{ $m->exam_id }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label> --}}
                                            
                                        {{-- </div> --}}
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label class="d-block mb-0" for="bpid">Select Police</label>
                                        </div>
                                        <div class="col-md-5">
                                            
                                            <select name="bpid[]" id="list1" class=" form-control" multiple>
                                                {{-- @if ($member != null)
                                                    @foreach ($member as $m)
                                                        <option value="{{ $m->bpid }}" data-rank="{{ $m->post }}">
                                                            
                                                            {{ $m->name_bn }} - {{ $m->post }} {{ $m->bpid }}
                                                        </option>
                                                    @endforeach
                                                @endif --}}
                                            </select>
 

                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center" >
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-xs clr-dark-green mx-auto " onclick="rightall()">
                                                        >> </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-xs clr-dark-green mx-auto " onclick="right()">
                                                        > </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-xs clr-dark-green" onclick="left()">
                                                        <
                                                    </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-xs clr-dark-green " onclick="leftall()">
                                                        <<
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <select name="bpid[]" id="list2" class="form-control" multiple >
                                                
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="col-12 d-flex">
                                            <button type="submit" class="btn btn-sm clr-dark-green ml-auto">
                                                create
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@endsection
<!-- ./wrapper -->

<!-- jQuery -->
@section('script')
@parent
<script>
    function filterPoliceOptions() {
    var selectedRank = document.getElementById('rank').value;
    var list1 = document.getElementById('list1');
    var bpid = @json($member);
    
    // Clear existing options in list1
    list1.innerHTML = "";

    var police = [];
    for (var i = 0; i < bpid.length; i++) {
        if (bpid[i].post === selectedRank) {
            police.push(bpid[i].bpid);
        }
    }

    for (i = 0; i < police.length; i++) {
        addOption(list1, police[i], police[i]);
    }
}

// Function to add an option to a select element
function addOption(selectBox, value, text) {
    var option = document.createElement('option');
    option.value = value;
    option.text = text;
    selectBox.add(option);
}

</script>
{{-- <script>
    function addOption(value, text) {
        var selectBox = document.getElementById('list1');

        // Create a new option element
        var option = document.createElement('option');

        // Set the value and text for the option
        option.value = value;
        option.text = text;

        // Append the option to the select box
        selectBox.add(option);
    }

    function filterPoliceOptions() {
        var selectedRank = document.getElementById('rank').value;
        var exam =document.getElementById('exam').value;
        // var bpidSelect = document.getElementById('bpid');
        var bpid = @json($member);
        console.log(selectedRank);
        // document.getElementById('bpid').innerHTML = bpid;
        var police = [];
        for (var i = 0; i < bpid.length; i++) {
            if (bpid[i].post === selectedRank ) {
                police.push(bpid[i].bpid);

            }
        }
        console.log(police);

        for (i = 0; i < police.length; i++) {
            console.log(police[i]);

            addOption(police[i], police[i]);
        }



    }
</script> --}}
<script>
function right() {
    var list1 = document.getElementById('list1');
    var list2 = document.getElementById('list2');

    // Get all selected options in list1
    var selectedOptions = [...list1.selectedOptions];

    // Check if any options are selected
    if (selectedOptions.length > 0) {
        selectedOptions.forEach(function(selectedOption) {
            // Create a new option element for list2
            var option = document.createElement('option');
            option.value = selectedOption.value;
            option.text = selectedOption.text;

            // Append the option to list2
            list2.add(option);

            // Remove the selected option from list1
            selectedOption.remove();
        });
    }
}
</script>
<script>
    function left1() {
        var list1 = document.getElementById('list1');
        var list2 = document.getElementById('list2');

        // Get the selected option in list2
        var selectedOption = list2.options[list2.selectedIndex];

        // Check if any option is selected
        if (selectedOption) {
            // Create a new option element for list1
            var option = document.createElement('option');
            option.value = selectedOption.value;
            option.text = selectedOption.text;

            // Append the option to list1
            list1.add(option);

            // Remove the selected option from list2
            list2.remove(list2.selectedIndex);
        }
    }
</script>
<script>
   
    function left() {
        var list1 = document.getElementById('list1');
        var list2 = document.getElementById('list2');

        // Get all selected options in list2
        var selectedOptions = [...list2.selectedOptions];

        // Check if any options are selected
        if (selectedOptions.length > 0) {
            selectedOptions.forEach(function(selectedOption) {
                // Create a new option element for list1
                var option = document.createElement('option');
                option.value = selectedOption.value;
                option.text = selectedOption.text;

                // Append the option to list1
                list1.add(option);

                // Remove the selected option from list2
                selectedOption.remove();
            });
        }
    }


</script>

<script>
    function leftall() {
        var list1 = document.getElementById('list1');
        var list2 = document.getElementById('list2');

        // Move all options from list2 to list1
        while (list2.options.length > 0) {
            // Create a new option element for list1
            var option = document.createElement('option');
            option.value = list2.options[0].value;
            option.text = list2.options[0].text;

            // Append the option to list1
            list1.add(option);

            // Remove the option from list2
            list2.options[0].remove();
        }
    }
</script>
<script>
    function rightall() {
        var list1 = document.getElementById('list1');
        var list2 = document.getElementById('list2');

        // Move all options from list1 to list2
        while (list1.options.length > 0) {
            // Create a new option element for list2
            var option = document.createElement('option');
            option.value = list1.options[0].value;
            option.text = list1.options[0].text;

            // Append the option to list2
            list2.add(option);

            // Remove the option from list1
            list1.options[0].remove();
        }
    }
</script>
{{-- to submit --}}
<script>
    function submitForm() {
    // Add this line to ensure that selected options in list2 are included in the form data
    updateList2Options();

    // Rest of your form submission logic
    var formData = new FormData(document.getElementById('yourFormId'));
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
}

// Function to update the form data with selected options from list2
function updateList2Options() {
    var list2 = document.getElementById('list2');
    for (var i = 0; i < list2.options.length; i++) {
        list2.options[i].selected = true;
    }
}

</script>

@endsection
