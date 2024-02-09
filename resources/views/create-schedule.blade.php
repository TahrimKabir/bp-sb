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
                    <div class="col-12  justify-content-center mt-5">
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
                                <form action="{{ route('store-schedule') }}" id="sform" method="post"
                                    onsubmit="submitForm()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="configuration" class="d-block mb-0">Configuration Name
                                                <input type="text" name="configuration" id="configuration"
                                                    class="form-control" placeholder="Configuration name" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="exam" class="d-block mb-0">Select Exam
                                                <select name="exam_id" id="exam" class="select2 form-control"
                                                    style="width:100%;" required>
                                                    <option value="exams" selected disabled>Select exam</option>
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
                                                <input type="number" name="numques" id="numques" class="form-control" oninput="handleInput()"
                                                    placeholder="digit ie. 10" required>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-md-0 mt-2">
                                            <label for="pmark" class="d-block mb-0">Pass Mark
                                                <input type="number" name="pmark" id="pmark" class="form-control" oninput="handleInput()"
                                                    placeholder="digit ie. 5" required>
                                            </label>
                                            <p class="mb-0 text-danger" id="errormark" style="display: none;">Pass mark should be less than the number of questions</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="date" class="d-block mb-0">Date
                                                <input type="date" name="date" id="date" class="form-control" oninput="handleInput()"
                                                    required>
                                            </label>
                                            <p class="mb-0 text-danger" id="errordate" style="display: none;">The date has passed already!</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label for="stime" class="d-block mb-0">Start Time
                                                <input type="time" name="stime" id="stime" class="form-control" oninput="handleInput()"
                                                    required>
                                            </label>
                                        </div>
                                        <div class="col-md-6 mt-md-0 mt-2">
                                            <label for="etime" class="d-block mb-0">End Time
                                                <input type="time" name="etime" id="etime" class="form-control" oninput="handleInput()"
                                                    required>
                                            </label>
                                            <p class="mb-0 text-danger" id="show" style="display: none;" class="text-danger">
                                                Endtime cannot be less than start time</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="rank" class="d-block mb-0">Rank
                                                <select name="rank" id="rank" class="select2 form-control"
                                                    style="width:100%;" onchange="filterPoliceOptions()">
                                                    <option value="police"selected disabled>select rank</option>
                                                    @if ($rank != null)
                                                        @foreach ($rank as $r)
                                                            <option value="{{ $r->post }}">
                                                                {{ $r->post }}({{ $r->designation_bn }})</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">

                                        <div class="col-12">
                                            <label class="d-block mb-0" for="bpid">Select Police</label>

                                        </div>
                                    </div>
                                    <div class="row mt-1">


                                        <div class=" col-md-5">
                                            <p class="mb-0" id="list1Count"></p>
                                            <input type="text" id="filterText" class="form-control mb-1"
                                                placeholder="search police..." oninput="filterList1()">

                                            <select id="list1" class=" form-control" multiple style="height: 30vh;">

                                            </select>


                                        </div>
                                        <div class="col-md-2 d-flex justify-content-center ">

                                            <div class="row">
                                                {{-- <div class="col-12" >
                                                    <p class="mb-0" style="visibility: hidden;">jdfd</p>
                                                    <input type="text"  style="visibility: hidden;" class="form-control">
                                                </div> --}}
                                                <div class="col-12 d-flex justify-content-center mb-1 mr-30">
                                                    <button type="button" class="btn btn-md clr-dark-green mx-auto "
                                                        onclick="rightall()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                                        </svg> ALL
                                                    </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-md clr-dark-green mx-auto "
                                                        onclick="right()">
                                                        LHS <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-md clr-dark-green"
                                                        onclick="left()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                                                        </svg> RHS
                                                    </button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-center mb-1">
                                                    <button type="button" class="btn btn-md clr-dark-green "
                                                        onclick="leftall()">
                                                        ALL <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="mb-0" id="list2Count"></p>
                                            <input type="text" id="filterTextList2" class="form-control mb-1"
                                                placeholder="search police..." oninput="filterList2()">

                                            <select name="bpid[]" id="list2" class="form-control" multiple
                                                style="height: 30vh;">

                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-12 d-flex">
                                            <button type="submit" id="submitbutton" class="btn btn-sm clr-dark-green ml-auto">
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
        var bpids = @json($member);

        // Clear existing options in list1
        list1.innerHTML = "";

        var police = [];
        // var name = [];
        // var des = [];
        for (var i = 0; i < bpids.length; i++) {
            if (bpids[i].post === selectedRank) {
                police.push(bpids[i]);
            }
        }

        for (i = 0; i < police.length; i++) {
            addOption(list1, police[i].bpid, police[i].name_bn + "-" + police[i].bpid + "(" + police[i].designation_bn +
                ")");
        }
        // to count
        countElements();
    }

    // Function to add an option to a select element
    function addOption(selectBox, value, text) {
        var option = document.createElement('option');
        option.value = value;
        option.text = text;
        selectBox.add(option);
    }
</script>

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
        countElements();
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
        countElements();
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
        countElements();
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
        countElements();
    }
</script>
{{-- to submit --}}


<script>
    function submitForm() {
        // Add this line to ensure that selected options in list2 are included in the form data
        updateList2Options();

        // Rest of your form submission logic
        var formData = new FormData(document.getElementById('sform'));
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

        //--- list1 list2 


    }
</script>
{{-- //submit --}}
{{-- counting total of list1 and list2 --}}
<script>
    function countElements() {
        var list1Count = document.getElementById('list1').options.length;
        var list2Count = document.getElementById('list2').options.length;

        document.getElementById('list1Count').innerHTML = "List1 Count: " + list1Count;
        document.getElementById('list2Count').innerHTML = "List2 Count: " + list2Count;
    }
</script>

{{-- filter from list1 and list2 --}}
<script>
    function filterList1() {
        var filterText = document.getElementById('filterText').value.toLowerCase();
        var list1 = document.getElementById('list1');

        for (var i = 0; i < list1.options.length; i++) {
            var optionText = list1.options[i].text.toLowerCase();
            var optionValue = list1.options[i].value.toLowerCase();

            // Check if the option text or value contains the filter text
            if (optionText.includes(filterText) || optionValue.includes(filterText)) {
                list1.options[i].style.display = ''; // Show the option
            } else {
                list1.options[i].style.display = 'none'; // Hide the option
            }
        }
        countElements();
    }
</script>
<script>
    function filterList2() {
        var filterText = document.getElementById('filterTextList2').value.toLowerCase();
        var list2 = document.getElementById('list2');

        for (var i = 0; i < list2.options.length; i++) {
            var optionText = list2.options[i].text.toLowerCase();
            var optionValue = list2.options[i].value.toLowerCase();

            // Check if the option text or value contains the filter text
            if (optionText.includes(filterText) || optionValue.includes(filterText)) {
                list2.options[i].style.display = ''; // Show the option
            } else {
                list2.options[i].style.display = 'none'; // Hide the option
            }
        }
        countElements();
    }
</script>
{{-- to make selected --}}
<script>
    const selectBox = document.getElementById("list1");
    selectBox.addEventListener("mousedown", function(event) {
        event.preventDefault();
        this.options[event.target.index].selected = !this.options[event.target.index].selected;
    });

    const selectBox2 = document.getElementById("list2");
    selectBox2.addEventListener("mousedown", function(event) {
        event.preventDefault();
        this.options[event.target.index].selected = !this.options[event.target.index].selected;
    });
</script>
{{-- time --}}
<script>
    // Function to compare two time strings
function compareTimes(time1, time2) {
    var time1Parts = time1.split(':');
    var time2Parts = time2.split(':');

    var hours1 = parseInt(time1Parts[0], 10);
    var minutes1 = parseInt(time1Parts[1], 10);

    var hours2 = parseInt(time2Parts[0], 10);
    var minutes2 = parseInt(time2Parts[1], 10);

    if (hours1 !== hours2) {
        return hours1 - hours2;
    }

    return minutes1 - minutes2;
}
// Function to check if a date has passed
function isDatePassed(targetDate) {
    // Get the current date
    var currentDate = new Date();

    // Convert the target date string to a Date object
    var targetDateObject = new Date(targetDate);

    // Compare the current date with the target date
    return currentDate > targetDateObject;
}
    function handleInput() {
        // Get the value of the time input
        var stime = document.getElementById('stime').value;
        var etime = document.getElementById('etime').value;
        var numq = document.getElementById('numques').value;
        var pmark = document.getElementById('pmark').value;
        var tdate = document.getElementById('date').value;
        

if (isDatePassed(tdate)) {
    document.getElementById('errordate').style.display="block";
} else {
    document.getElementById('errordate').style.display="none";
}
        if(numq<pmark){
            document.getElementById('errormark').style.display="block";
            
        }else{
            document.getElementById('errormark').style.display="none";
            console.log(numq);
            console.log(pmark);
            
        }
        
        if(compareTimes(stime, etime)>0||(numq<pmark)||(isDatePassed(tdate))){
            document.getElementById('submitbutton').disabled = true;
        }else{
            document.getElementById('submitbutton').disabled = false;
        }
        if(compareTimes(stime, etime)>0){
            document.getElementById('show').style.display="block";
            // document.getElementById('submitbutton').disabled = true;
        }else{
            document.getElementById('show').style.display="none";
            // document.getElementById('submitbutton').disabled = false;
        }
        
        
    }
</script>


@endsection
