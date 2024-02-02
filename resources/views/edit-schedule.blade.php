
{{-- start --}}
@extends('dashboard')
@section('style')
<!-- Google Font: Source Sans Pro -->
@include('layouts.selectbox')
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
                            <h4 class="display-6 mb-0 text-center">
                               Edit Exam Schedule
                            </h4>
                            <p class="display-6 mb-0 text-center">for</p>
                            <p class="display-6 mb-0 text-center">@if($schedule->member!=null) {{$schedule->member->name_bn}} ({{$schedule->member->post}}) @endif</p>
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
                            <form action="{{route('update-schedule')}}" method="post" >
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" name="id" value="{{$schedule->id}}">
                                    <label for="configuration" class="d-block mb-0">Configuration Name
                                        <input type="text" name="configuration" id="configuration" class="form-control" value="{{$schedule->config->name}}">
                                    </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="exam" class="d-block mb-0">Select Exam
                                            <select name="exam_id" id="exam" class="select2 form-control" style="width:100%;">
                                             @if($exam!=null)
                                             @foreach($exam as $e)
                                             <option value="{{$e->exam_id}}" @if($schedule->config->exam_id==$e->exam_id) selected @endif>{{$e->exam_name}}</option>
                                             @endforeach
                                             @endif
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="numques" class="d-block mb-0">Number of Questions
                                            <input type="number" name="numques" id="numques" class="form-control" value="{{$schedule->config->total_questions}}">
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-2">
                                        <label for="pmark" class="d-block mb-0">Pass Mark
                                            <input type="number" name="pmark" id="pmark" class="form-control" value="{{$schedule->config->pass_mark}}">
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="date" class="d-block mb-0">Date
                                            <input type="date" name="date" id="date" class="form-control" value="{{$schedule->config->date}}" required>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="stime" class="d-block mb-0">Start Time
                                            <input type="time" name="stime" id="stime" class="form-control" value="{{$schedule->config->start_time}}" required>
                                        </label>
                                    </div>
                                    <div class="col-md-6 mt-md-0 mt-2">
                                        <label for="etime" class="d-block mb-0">End Time
                                            <input type="time" name="etime" id="etime" class="form-control" value="{{$schedule->config->end_time}}" required>
                                        </label>
                                    </div>
                                </div>
                                {{-- <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="rank" class="d-block mb-0">Rank
                                            <select name="rank" id="rank" class="select2 form-control" style="width:100%;"  onchange="filterPoliceOptions()">
                                                
                                                @if($rank!=null)
                                             @foreach($rank as $r)
                                             <option value="{{$r->post}}" >{{$r->post}}</option>
                                             @endforeach
                                             @endif
                                            </select>
                                        </label>
                                    </div>
                                </div> --}}
                                {{-- <div class="row mt-2">
                                    <div class="col-12" id="in">
                                        
                                          <label class="d-block mb-0" for="bpid">Select Police
                                            
                                          <select class="duallistbox" multiple="multiple" name="bpid[]" id="bpid">
                                          
                                            @if($member!=null)
                                            @foreach($member as $m)
                                            <option value="{{$m->bpid}}" @if($schedule->bpid==$m->bpid) selected @endif data-rank="{{$m->post}}" >{{$m->name_bn}}</option>
                                            @endforeach
                                            @endif
                                          </select>
                                        </label>
                                        
                                      </div>
                                </div> --}}
                                <div class="row mt-2">
                                    <div class="col-12 d-flex">
                                        <button class="btn btn-sm clr-dark-green ml-auto">
                                            update
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
        var bpidSelect = document.getElementById('bpid');
        var bpid = @json($member);
        console.log(selectedRank);
        document.getElementById('bpid').innerHTML = bpid;
        var police = [];
        // for(var i=0; i<bpid.length; i++){
        //     if(bpid[i].post===selectedRank){
        //         police.push(bpid[i].bpid);
                
        //     }
        // }
        // if(police!=null){
        //     document.getElementById('in').innerHTML=police;
        // }
       
        
        
    }

    // Manually initialize the DualListbox plugin
    // ...
</script>
{{-- message echo --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
    
    var messageContainer = document.getElementById('message-container');

   
    if (messageContainer) {
        
        setTimeout(function() {
            
            messageContainer.style.display = 'none';
        }, 4000); 
    }
});

</script>
@endsection
