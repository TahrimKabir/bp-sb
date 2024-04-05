<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{


    public function showMemberList()
    {
        $members = Member::all();
        return view('member.member-list-page', compact('members'));
    }
    public function addMember(){
        return view('member.member-add-page');
    }

    public function storeMember(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'bpid' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'post' => 'required',
            'posting_area' => 'required',
            'mobile' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'dob' => 'required|date',
            'joining_date' => 'required|date',
        ]);

        // Check if the bpid already exists
        $existingMember = Member::where('bpid', $validatedData['bpid'])->first();

        if ($existingMember) {

            return redirect()->back()->withInput()->with('fail', 'BPID already exists.');
        }

        // Create a new member and store it in the database
        Member::create($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Member added successfully.');
    }

    public function editMember($id)
    {
        $member = Member::where('id', $id)->first();

        if (!$member) {
            abort(404);
        }

        return view('member.edit-member-page', compact('member'));
    }

    public function updateMember(Request $request, $id)
    {
        // Validate the form data
        $validatedData = $request->validate([

            'name_bn'=>'required',
            'designation_bn'=>'required',
            'post' => 'required',
            'posting_area' => 'required',

        ]);


        $member = Member::findOrFail($id);


        $member->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Member details updated successfully.');
    }
}
