<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\transaction;
use App\Models\detailTransaction;

class TransactionController extends Controller
{
    const MEMBERSHIP_DISCOUNTS = [
        'Silver' => 0.05,   // 5%
        'Gold' => 0.1,      // 10%
        'Platinum' => 0.15, // 15%
    ];

    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    private function applyMembershipDiscount($isMember, $coursePrice, $membershipType)
    {
        if ($isMember && array_key_exists($membershipType, self::MEMBERSHIP_DISCOUNTS)) {
            $discountPercentage = self::MEMBERSHIP_DISCOUNTS[$membershipType];
            $discountAmount = $coursePrice * $discountPercentage;
            return $discountAmount;
        }
        return 0;
    }

    public function create()
    {
        $courses = Course::all();
        $qualifiedInstructors = Instructor::whereHas('qualifications', function ($query) {
        })->get();
        return view('transactions.create', compact('courses'), compact('qualifiedInstructors'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TransCode' => 'required|unique:transactions',
            'TransDate' => 'required|date',
            'CustName' => 'required|string',
            'Member' => 'required|in:Silver,Gold,Platinum',
        ]);

        $isMember = $request->input('Member') === 'Silver' || $request->input('Member') === 'Gold' || $request->input('Member') === 'Platinum';
        $courseId = $request->input('course_id');
        $course = Course::find($courseId);
        $coursePrice = $course->Price;
        $membershipType = $request->input('Member');
        $discountAmount = $this->applyMembershipDiscount($isMember, $coursePrice, $membershipType);
        $total = $coursePrice - $discountAmount;

        if ($validator->fails()) {
            return redirect()->route('transactions.create')
                ->withErrors($validator)
                ->withInput();
        }
        $validator = Validator::make($request->all(), [
            'CourseID' => 'required|exists:courses,id',
            'InstructorID' => 'required|exists:instructors,id',
            'StartDate' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('transactions.create')
                ->withErrors($validator)
                ->withInput();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'TransCode' => 'required|unique:transactions,TransCode,' . $id,
            'TransDate' => 'required|date',
            'CustName' => 'required|string',
            'Member' => 'required|in:Silver,Gold,Platinum',
        ]);
        if ($validator->fails()) {
            return redirect()->route('transactions.edit', ['transaction' => $id])
                ->withErrors($validator)
                ->withInput();
        }
        $transaction->TransCode = $request->input('TransCode');
        $transaction->TransDate = $request->input('TransDate');
        $transaction->CustName = $request->input('CustName');
        $transaction->Member = $request->input('Member');
        $transaction->save();
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }
}
