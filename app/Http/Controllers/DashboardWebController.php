<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Donor;
use App\Models\Donation;
use App\Models\InventoryTransaction;
use App\Models\Beneficiary;
use App\Models\VolunteerAttendance;
use App\Models\VolunteerHour;
use App\Models\Task;
use App\Models\Payroll;
use App\Models\Complaint;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Expense;
use App\Models\Audit;

class DashboardWebController extends Controller
{
    public function index()
    {
        $donorsCount = Donor::count();
        $beneficiariesCount = Beneficiary::count();
        $warehousesCount = Warehouse::count();
        $volunteersCount = User::where('is_volunteer', true)->count();
        $cashDonations = Donation::where('type','cash')->sum('amount');
        $inKindDonations = Donation::where('type','in_kind')->sum('estimated_value');
        $inventoryNet = InventoryTransaction::select(DB::raw("SUM(CASE WHEN type='in' THEN quantity WHEN type='out' THEN -quantity ELSE 0 END) as net"))->value('net');
        $openTasks = Task::where('status','!=','done')->count();
        $today = now()->toDateString();
        $attendanceToday = VolunteerAttendance::where('date',$today)->count();
        $monthStart = now()->startOfMonth()->toDateString();
        $vhoursMonth = VolunteerHour::whereBetween('date', [$monthStart, $today])->sum('hours');
        $payrollMonth = Payroll::where('month', now()->format('Y-m'))->sum('amount');
        $openComplaints = Complaint::count();

        $latestDonations = Donation::orderByDesc('id')->limit(5)->get();
        $latestTasks = Task::orderByDesc('id')->limit(5)->get();
        $latestAttendance = VolunteerAttendance::orderByDesc('date')->limit(5)->get();

        $months = [];
        $cashSeries = [];
        $inKindSeries = [];
        for ($i = 11; $i >= 0; $i--) {
            $start = now()->subMonths($i)->startOfMonth();
            $end = now()->subMonths($i)->endOfMonth();
            $label = $start->format('Y-m');
            $months[] = $label;
            $cashSeries[] = (float) Donation::where('type','cash')->whereBetween('created_at', [$start, $end])->sum('amount');
            $inKindSeries[] = (float) Donation::where('type','in_kind')->whereBetween('created_at', [$start, $end])->sum('estimated_value');
        }

        $beneficiaryStatus = Beneficiary::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')->get()->map(function($r){
                $labelMap = [ 'new' => 'جديد', 'under_review' => 'قيد المراجعة', 'accepted' => 'مقبول' ];
                return ['status' => $labelMap[$r->status] ?? $r->status, 'count' => (int) $r->count];
            });

        $evaluations = [];
        $volunteers = User::where('is_volunteer', true)->orderBy('name')->limit(12)->get();
        foreach ($volunteers as $v) {
            $hours = (float) VolunteerHour::where('user_id',$v->id)->whereBetween('date', [$monthStart, $today])->sum('hours');
            $attendanceDays = (int) VolunteerAttendance::where('user_id',$v->id)->whereBetween('date', [$monthStart, $today])->distinct()->count('date');
            $tasksDone = (int) Task::where('assigned_to',$v->id)->where('status','done')->whereBetween('created_at', [now()->startOfMonth(), now()])->count();
            $score = min($hours/40,1)*40 + min($attendanceDays/20,1)*30 + min($tasksDone/10,1)*30;
            $evaluations[] = [
                'name' => $v->name,
                'hours' => $hours,
                'attendance' => $attendanceDays,
                'tasks' => $tasksDone,
                'score' => round($score)
            ];
        }

        $cashMonth = (float) Donation::where('type','cash')->whereBetween('created_at', [now()->startOfMonth(), now()])->sum('amount');
        $inKindMonth = (float) Donation::where('type','in_kind')->whereBetween('created_at', [now()->startOfMonth(), now()])->sum('estimated_value');
        $monthDonationsTotal = $cashMonth + $inKindMonth;
        $cashMonthPct = $monthDonationsTotal > 0 ? round(($cashMonth / $monthDonationsTotal) * 100) : 0;
        $inKindMonthPct = $monthDonationsTotal > 0 ? 100 - $cashMonthPct : 0;

        $expensesMonth = (float) Expense::whereBetween('created_at', [now()->startOfMonth(), now()])->sum('amount');
        $netFlowMonth = $monthDonationsTotal - $expensesMonth;

        $donorTotals = Donation::select('donor_id', DB::raw('SUM(COALESCE(amount, estimated_value, 0)) as total'))
            ->whereBetween('created_at', [now()->startOfMonth(), now()])
            ->groupBy('donor_id')->get();
        $donorIds = $donorTotals->pluck('donor_id')->filter()->unique();
        $donorsMap = Donor::whereIn('id', $donorIds)->get()->keyBy('id');
        $topDonors = $donorTotals->map(function($r) use ($donorsMap){
            return [ 'id' => $r->donor_id, 'name' => optional($donorsMap->get($r->donor_id))->name ?? '—', 'total' => (float) $r->total ];
        })->sortByDesc('total')->values()->take(5)->all();

        $user = request()->user();
        $isAdmin = $user && $user->roles()->where('key','admin')->exists();
        $audits = collect();
        $audUserMap = collect();
        if ($isAdmin) {
            $audits = Audit::orderByDesc('id')->limit(10)->get();
            $audUserIds = $audits->pluck('user_id')->filter()->unique();
            $audUserMap = User::whereIn('id', $audUserIds)->get()->keyBy('id');
        }

        $notifications = [];
        if ($openComplaints > 0) { $notifications[] = ['text' => 'شكاوى مفتوحة: '.$openComplaints, 'type' => 'warning']; }
        if ($openTasks > 0) { $notifications[] = ['text' => 'مهام مفتوحة: '.$openTasks, 'type' => 'info']; }
        if ($attendanceToday == 0) { $notifications[] = ['text' => 'لا يوجد حضور مسجل اليوم', 'type' => 'secondary']; }
        if ($netFlowMonth < 0) { $notifications[] = ['text' => 'صافي التدفق هذا الشهر سالب', 'type' => 'danger']; }
        if ($attendanceToday > 0) { $notifications[] = ['text' => 'تم تسجيل حضور اليوم', 'type' => 'success']; }
        if ($netFlowMonth >= 0 && $monthDonationsTotal > 0) { $notifications[] = ['text' => 'صافي التدفق لهذا الشهر موجب', 'type' => 'success']; }

        return view('dashboard.index', compact(
            'donorsCount','beneficiariesCount','warehousesCount','volunteersCount',
            'cashDonations','inKindDonations','inventoryNet','openTasks',
            'attendanceToday','vhoursMonth','payrollMonth','openComplaints',
            'latestDonations','latestTasks','latestAttendance','months','cashSeries','inKindSeries','beneficiaryStatus','evaluations'
            ,'cashMonth','inKindMonth','monthDonationsTotal','cashMonthPct','inKindMonthPct','expensesMonth','netFlowMonth','topDonors'
            ,'audits','audUserMap','isAdmin','notifications'
        ));
    }
}
