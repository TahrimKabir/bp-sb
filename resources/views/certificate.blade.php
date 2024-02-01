<!-- resources/views/certificate.blade.php -->


<!DOCTYPE html>
  <html>
  <head>
  <style>
  h1 {
    // color: #F9CB37;
    // color: #056839;
    color: #1e285e;
    //font-family: verdana;
    font-size: 300%;
  }
  h2 {
    color: #056839;
    //font-family: aspire;
    font-size: 230%;
  }
  h6 {
    color: #06BBCC;
    //font-family: nikosh;
    font-size: 180%;
    padding: 10px 0;
  }
  p {
    //font-family: jomolhari;
    font-size: 120%;
    font-weight: bold;
  }
  b {
    font-size: 120%;
  }
  </style>
  </head>
  <body>

  <table border="0" style="width:92%; font-size:14px; border-collapse: collapse; text-align:center;margin: 0 auto;" cellpadding="4">
      <tr>
        <td style="width: 33%; text-align:left;"><img src="../img/bdpolice-logo.png" alt="" height="70px"></td>
        <td style="width: 34%; text-align:center;"><img src="../img/logo.png" alt="" height="70px" ></td>
        <td style="width: 33%; text-align:right;"><img src="../img/unwomen-logo.png" alt="" height="60px" ></td>
      </tr>
      <tr>
        <td colspan="3">
        <br> <br><br>
          <h1><u>সমাপনী সনদ</h1><br>
          <p>এই মর্মে প্রত্যায়ন করা হচ্ছে যে, </p><br>
          <h2>{{ $userName }} </h2>  {{ $bpid }}  <br><br>
          <p> {{$date}}  তারিখের সরকারি আদেশ নং  govt order no প্রেক্ষিতে </p><br>
          <h6></h6> <br>
          <p> সংশ্লিষ্ট অনলাইন কোর্সটি '. BanglaConverter::en2bn(date_format(date_create(now()),"d-m-Y"))  তারিখে সম্পন্ন করেছেন।</p> <br>
          <br>

        </td>
      </tr>
      <tr>
        <td>
          <br> 
          <br> 
          <img src="../img/add-dig-2.png" alt="" height="50px">
          <hr>
          <b>অ্যাডিশনাল ডিআইজি <br> ট্রেনিং-২ শাখা</b>
        </td>
        <td></td>
        <td>
          <br> 
          <br> 
          <img src="../img/bpm-dig-sign.png" alt="" height="50px">
          <hr>
          <b>সভাপতি <br> বাংলাদেশ পুলিশ উইমেন নেটওয়ার্ক</b>
        </td>
      </tr>
  </table>

  </body>
  </html>
