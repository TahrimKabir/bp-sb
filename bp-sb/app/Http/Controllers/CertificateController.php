<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\MembersCourseStatus;
class CertificateController extends Controller
{
    public function generateCertificate($id)
    {
        // Get user details
        $data = MembersCourseStatus::where('id_members_course_status',$id)->first();
        $bpid = $data->bpid;
        $userName = $data->member->name;
        $date = $data->complete_date;


        
        $data = [
            'bpid' => $bpid,
            'userName' => $userName,
            'date' => $date
            // 'course'=>$course,
        ];

        // Generate PDF
        $pdf = PDF::loadView('certificate', $data);

        // Download the PDF
        return $pdf->download('certificate.pdf');
    }
}
