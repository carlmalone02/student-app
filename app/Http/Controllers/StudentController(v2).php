<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index()
    {
        $students=Student::all();
        return view('dashboard', conpact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:255'
        ]);
        Student::create([
            'name'=>$request->name
        ]);
        return redirect()->route('dashboard');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade' => 'required|integer'
        ]);

        $student = Student::findOrFail($id);
        $student ->update([
            'grade'=>$request->grade
        ]);

        return response()->json(['success'=> true]);
    }

    public function delete($id)
    {
        $student=Student::find($id);
        if ($student){
            $student->delete();
            return response()->json(['success'=> true]);
        }
        return response()->json(['success'=>false, 'message'=>'student not found', 404]);
    }   


    public function import(Request $request)
    {
        $request->validate([
            'file'=>'required|file|mimes:xlsx,csv,ods'
        ]);

        try {
            Excel::import(new StudentImport, $request->file('file'));
            return back()->with('success', 'Students imported successfully!');
        } catch (\Exception $e) {
            dd();
            return back()->with('error', 'Failed to import students. Please try again.');
        }
    }


    public function export()
    {
        $studentsGrade = Student::all();
        $exportFileName = 'Students-Grade.csv';
        $headers = ['Name', 'Grade'];
        $handle = fopen('php://memory', 'w+');
        fputcsv($handle, $headers);
    
        foreach ($studentsGrade as $student) {
            fputcsv($handle, [$student->name, $student->grade]);
        }
    
        rewind($handle);
        $grades = stream_get_contents($handle);
        fclose($handle);
    
        return response($grades, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$exportFileName}",
        ]);
    }
    
    public function generateCert(Request $request)
    {
        $students=Student::where('grade', '>=', 60)->get();
        $pdf=PDF::loadView('certificate', compact('students'))->setPaper('a4', 'landscape');
        return $pdf->download('certificates.pdf');
    }

}
