<!DOCTYPE html>
<html>
<head>
    <style>
        h1 {
            color: #1e285e;
            font-size: 300%;
        }
        h2 {
            color: #056839;
            font-size: 230%;
        }
        h3 {
            color: #c99c0a;
            font-size: 180%;
        }
        h6 {
            color: #06BBCC;
            font-size: 180%;
            padding: 10px 0;
        }
        p {
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
        <td style="width: 33%; text-align:left;"><img src="{{ asset('img/bdpolice-logo.png') }}" alt="" height="70px"></td>
        <td style="width: 34%; text-align:center;"><img src="{{ asset('img/logo.png') }}" alt="" height="70px" ></td>
        <td style="width: 33%; text-align:right;"><img src="{{ asset('img/unwomen-logo.png') }}" alt="" height="60px" ></td>
    </tr>
    <tr>
        <td colspan="3">
            <br><br><br>
            <h1><u>সমাপনী সনদ</u></h1><br>
            <p>এই মর্মে প্রত্যয়ন করা হচ্ছে যে,</p><br>
            <h2>{{ $member->name_bn }}</h2>
            <h3>{{ $member->designation_bn }}</h3>
            {{ $member->id }}
            <br><br>
            <h6>"{{ $course->title }}"</h6><br>
            <p>সংশ্লিষ্ট ৭দিন ব্যাপী অনলাইন কোর্সটি তারিখে সম্পন্ন করেছেন।</p><br>
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <br>
            <img src="{{ asset('img/add-dig-2.png') }}" alt="" height="50px">
            <hr>
            <b>অ্যাডিশনাল ডিআইজি <br> ট্রেনিং-২ শাখা</b>
        </td>
        <td></td>
        <td>
            <br>
            <br>
            <img src="{{ asset('img/bpm-dig-sign.png') }}" alt="" height="50px">
            <hr>
            <b>সভাপতি <br> বাংলাদেশ পুলিশ উইমেন নেটওয়ার্ক</b>
        </td>
    </tr>
</table>
</body>
</html>
