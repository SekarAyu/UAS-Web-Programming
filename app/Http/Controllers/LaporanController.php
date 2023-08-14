<?php

namespace App\Http\Controllers;
use App\Models\transaction;
use App\Models\detailTransaction;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LaporanController extends Controller
{
    public function laporan(){

        $subquery = DB::table('transaksis')
        ->select('CourseID', DB::raw('count(id) as jumlah_transaksi'))
        ->where('status', '=', 1)
        ->groupBy('CourseID');

        $course = DB::table('data_course')
            ->joinSub($subquery, 'transaksis', function ($join) {
                $join->on('data_course.id', '=', 'transaksis.CourseID');
            })
            ->select('data_course.*', 'transaksis.jumlah_transaksi')
            ->get();
                // dd($course);
            
            return view('laporan.index', compact('course'));
        }
}

