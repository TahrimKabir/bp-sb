<?php
include "member_header.php";
?>
<!-- Course 1 Chapter 1 -->
<div class="container-xxl py-4 mb-5">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h5>কুইজ (লিঙ্গ ও জেন্ডার বিষয়ক প্রশিক্ষণ)</h5>
            <h5>সময়ঃ <span id="demo"></span></h5>
        </div>
        <hr><br>
        <!-- Quiz -->
        <div>
            <form action="" method="">
                <div class="question bg-white">
                    <div class="d-flex flex-row align-items-center question-title bg-light p-3">
                        <h3 class="text-primary">Q1.</h3>
                        <h5 class="ml-2"> Which of the following country has largest population?</h5>
                    </div>
                    <div class="mx-3">
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q1" value=""> <span>Option 1</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q1" value=""> <span>Option 2</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q1" value=""> <span>Option 3</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q1" value=""> <span>Option 4</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="question bg-white">
                    <div class="d-flex flex-row align-items-center question-title bg-light p-3">
                        <h3 class="text-primary">Q2.</h3>
                        <h5 class="ml-2"> Which of the following country has largest population?</h5>
                    </div>
                    <div class="mx-3">
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q2" value=""> <span>Option 1</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q2" value=""> <span>Option 2</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q2" value=""> <span>Option 3</span>
                            </label>
                        </div>
                        <div class="p-2">
                            <label class="radio"> <input type="radio" name="q2" value=""> <span>Option 4</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="course1result.php" type="submit" class="btn btn-primary rounded-pill">Submit <i class="fas fa-arrow-right"></i></a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Course 1 Chapter 1 -->

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("Dec 19, 2022 15:37:25").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        document.getElementById("demo").innerHTML = hours + "h:" +
            minutes + "m:" + seconds + "s";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>

<?php
include "member_footer.php";
?>