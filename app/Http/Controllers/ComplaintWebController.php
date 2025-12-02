<?php
namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Models\Donor;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class ComplaintWebController extends Controller
{
    public function index() { $complaints = Complaint::orderByDesc('id')->paginate(20); return view('complaints.index', compact('complaints')); }
    public function create() { $users = User::orderBy('name')->get(); $donors = Donor::orderBy('name')->get(); $beneficiaries = Beneficiary::orderBy('full_name')->get(); return view('complaints.create', compact('users','donors','beneficiaries')); }
    public function store(Request $request)
    {
        $data = $request->validate(['source_type' => 'required|in:donor,beneficiary,employee','source_id' => 'required|integer','against_user_id' => 'nullable|exists:users,id','status' => 'in:open,in_progress,closed','subject' => 'required|string','message' => 'required|string']);
        $c = Complaint::create($data);
        return redirect()->route('complaints.show',$c);
    }
    public function show(Complaint $complaint) { return view('complaints.show', compact('complaint')); }
    public function edit(Complaint $complaint) { $users = User::orderBy('name')->get(); return view('complaints.edit', compact('complaint','users')); }
    public function update(Request $request, Complaint $complaint) { $data = $request->validate(['against_user_id' => 'nullable|exists:users,id','status' => 'in:open,in_progress,closed']); $complaint->update($data); return redirect()->route('complaints.show',$complaint); }
    public function destroy(Complaint $complaint) { $complaint->delete(); return redirect()->route('complaints.index'); }
}
