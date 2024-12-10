<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
        $columns = ['id', 'bpid', 'name_bn', 'designation', 'post', 'mobile', 'posting_area']; // Adjust column names to match your table
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
        $data->transform(function ($item, $index) use ($start) {
            $item->serial = $start + $index + 1;
            $item->action = '<div class="col-12 d-flex justify-content-center">
                                <a href="' . url('/delete-member/'.$item->id) .'" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you sure you want to delete?\');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                </a>
                                <a href="' . url("/edit-member/".$item->id) . '" class="custom-btn btn btn-warning btn-xs ml-1"><i class="bi bi-pencil-square"></i></a>
                            </div>';
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
            'bpid' => 'required|max:20',
            'name' => 'nullable|string',
            'name_bn'=>'required|string',
            'designation' => 'nullable|string',
            'designation_bn'=>'nullable|string',
            'post' => 'required',
            'posting_area' => 'nullable|string',
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

    public function storeBulkMember(Request $request) {

        $request->validate([
            'bulk_member_file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) use ($request) {
                    $file = $request->file($attribute);
                    $extension = $file->getClientOriginalExtension();
        
                    if (!in_array($extension, ['xlsx', 'xls', 'ods'])) {
                        $fail('The file must be a valid Excel file.');
                    }
                },
            ],
        ]);

        $file = $request->file('bulk_member_file');
        File::cleanDirectory(storage_path('app/bulk_member_file'));
        $path = $file->storeAs('bulk_member_file', $file->getClientOriginalName());
        $fullPath = storage_path('app/' . $path);
        
        $data = Excel::toArray([], $fullPath);

        if (empty($data) || empty($data[0])) {
            return back()->with('error', 'The Excel file is empty or invalid.');
        }

        foreach ($data as &$sheet) {
            foreach ($sheet as &$row) {
                $dateColumns = [8, 9];
        
                foreach ($dateColumns as $col) {
                    if (isset($row[$col]) && is_numeric($row[$col]) && $row[$col] > 25569 && $row[$col] < 2958465) {
                        $row[$col] = Date::excelToDateTimeObject($row[$col])->format('Y-m-d');
                    }
                }
            }
        }

        $rows = $data[0];

        $expectedColumns = [
            'BPID', 'Bangla Name', 'English Name', 'Designation', 
            'Designation Bangla', 'Post', 'Posting Area', 
            'Mobile', 'Date of Birth', 'Joining Date'
        ];

        $header = $rows[0];
        if ($header !== $expectedColumns) {
            return back()->with('error', 'The Excel file columns are not valid.');
        }

        unset($rows[0]);

        $validPostValues = ['ASI', 'ADD-DIG', 'ATSI', 'CONSTABLE', 'INSPECTOR', 'SI', 'SERGEANT'];

        foreach ($rows as $row) {
            $rowData = array_combine($header, $row);

            $postValue = $rowData['Post'] ?? null;

            $mappedData = [
                'bpid' => $rowData['BPID'] ?? null,
                'name_bn' => $rowData['Bangla Name'] ?? null,
                'name' => $rowData['English Name'] ?? null,
                'designation' => $rowData['Designation'] ?? null,
                'designation_bn' => $rowData['Designation Bangla'] ?? null,
                'post' => in_array($postValue, $validPostValues) ? $postValue : null,
                'posting_area' => $rowData['Posting Area'] ?? null,
                'mobile' => $rowData['Mobile'] ?? null,
                'dob' => !empty($rowData['Date of Birth']) ? date('Y-m-d', strtotime($rowData['Date of Birth'])) : null,
                'joining_date' => !empty($rowData['Joining Date']) ? date('Y-m-d', strtotime($rowData['Joining Date'])) : null,
            ];

            $member = Member::where('bpid', $mappedData['bpid'])->first();
            if ($member) {
                foreach ($mappedData as $key => $value) {
                    if (!is_null($value)) {
                        $member->$key = $value;
                    }
                }
                $member->save();
            } else {
                Member::create($mappedData);
            }
        }

        return back()->with('success', 'Members added successfully.');

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

            'name' => 'nullable',
            'name_bn'=>'required|string',
            'designation' => 'nullable',
            'designation_bn'=>'nullable|string',
            'post' => 'nullable',
            'posting_area' => 'nullable',
            'mobile' => 'required|regex:/^01[3-9][0-9]{8}$/',
            'dob' => 'nullable|date',
            'joining_date' => 'nullable|date',
        ]);


        $member = Member::findOrFail($id);


        $member->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Member details updated successfully.');
    }


    public function deleteMember($id)
    {
        Member::where('id', $id)->delete();
        return redirect()->back()->with('fail', 'Member deleted successfully');
    }
}
