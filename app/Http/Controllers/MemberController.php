<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{


    public function showMemberList()
    {
        $members = [];
        return view('member.member-list-page', compact('members'));
    }

    public function showMemberListChunk(Request $request)
    {
        // Extract the DataTable parameters
        $start = $request->input('start', 0); // Starting row
        $length = $request->input('length', 10); // Number of rows to fetch
        $searchValue = $request->input('search.value'); // Search value (if any)
        $orderColumnIndex = $request->input('order.0.column'); // Column index for sorting
        $orderDirection = $request->input('order.0.dir', 'asc'); // Sorting direction

        // Define sortable columns
        $columns = ['bpid', 'name_bn', 'designation', 'post', 'mobile', 'posting_area']; // Adjust column names to match your table
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';

        // Query the database
        $query = Member::query();

        // Apply search filter
        if ($searchValue) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('bpid', 'like', "%$searchValue%")
                  ->orWhere('name_bn', 'like', "%$searchValue%")
                  ->orWhere('designation', 'like', "%$searchValue%")
                  ->orWhere('post', 'like', "%$searchValue%")
                  ->orWhere('mobile', 'like', "%$searchValue%")
                  ->orWhere('posting_area', 'like', "%$searchValue%");
            });
        }

        // Get total count before applying pagination
        $totalRecords = $query->count();

        // Apply sorting and pagination
        $data = $query->orderBy($orderColumn, $orderDirection)
                      ->skip($start)
                      ->take($length)
                      ->get();

        // Append action column
        $data->transform(function ($item) {
            $item->action = '<a href="' . url("/edit-member/".$item->id) . '" class="custom-btn btn btn-warning btn-xs ml-1"><i class="bi bi-pencil-square"></i></a>';
            return $item;
        });

        // Return response in DataTable-compatible format
        return response()->json([
            'draw' => $request->input('draw'), // Pass through DataTables draw parameter
            'recordsTotal' => $totalRecords, // Total records without filtering
            'recordsFiltered' => $totalRecords, // Total records after filtering
            'data' => $data, // Paginated data
        ]);
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
            'name_bn'=>'required|string',
            'designation' => 'nullable',
            'designation_bn'=>'nullable|string',
            'post' => 'required',
            'posting_area' => 'required',
            'mobile' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
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

            'name' => 'required',
            'name_bn'=>'required|string',
            'designation' => 'nullable',
            'designation_bn'=>'nullable|string',
            'post' => 'required',
            'posting_area' => 'required',
            'mobile' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
        ]);


        $member = Member::findOrFail($id);


        $member->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Member details updated successfully.');
    }
}
