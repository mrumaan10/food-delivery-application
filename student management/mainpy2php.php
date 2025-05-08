<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Models
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Attendance;
use App\Models\Trigger;

// Home Page
Route::get('/', function () {
    return view('index');
});

// Student Details
Route::get('/studentdetails', function () {
    $students = Student::all();
    return view('studentdetails', ['students' => $students]);
});

// Triggers
Route::get('/triggers', function () {
    $triggers = Trigger::all();
    return view('triggers', ['triggers' => $triggers]);
});

// Add Department
Route::match(['get', 'post'], '/department', function (Request $request) {
    if ($request->isMethod('post')) {
        $dept = $request->input('dept');
        $existingDepartment = Department::where('branch', $dept)->first();
        if ($existingDepartment) {
            return redirect('/department')->with('warning', 'Department Already Exists');
        }
        $newDepartment = new Department();
        $newDepartment->branch = $dept;
        $newDepartment->save();
        return redirect('/department')->with('success', 'Department Added Successfully');
    }
    return view('department');
});

// Add Attendance
Route::match(['get', 'post'], '/addattendance', function (Request $request) {
    $students = Student::all();
    if ($request->isMethod('post')) {
        $rollno = $request->input('rollno');
        $attendance = $request->input('attend');
        $newAttendance = new Attendance();
        $newAttendance->rollno = $rollno;
        $newAttendance->attendance = $attendance;
        $newAttendance->save();
        return redirect('/addattendance')->with('warning', 'Attendance added');
    }
    return view('attendance', ['students' => $students]);
});

// Search
Route::match(['get', 'post'], '/search', function (Request $request) {
    if ($request->isMethod('post')) {
        $rollno = $request->input('roll');
        $bio = Student::where('rollno', $rollno)->first();
        $attend = Attendance::where('rollno', $rollno)->first();
        return view('search', ['bio' => $bio, 'attend' => $attend]);
    }
    return view('search');
});

// Delete Student
Route::post('/delete/{id}', function ($id) {
    $student = Student::find($id);
    $student->delete();
    return redirect('/studentdetails')->with('danger', 'Slot Deleted Successfully');
})->middleware('auth');

// Edit Student
Route::match(['get', 'post'], '/edit/{id}', function (Request $request, $id) {
    if ($request->isMethod('post')) {
        $student = Student::find($id);
        $student->rollno = $request->input('rollno');
        $student->sname = $request->input('sname');
        $student->sem = $request->input('sem');
        $student->gender = $request->input('gender');
        $student->branch = $request->input('branch');
        $student->email = $request->input('email');
        $student->number = $request->input('num');
        $student->address = $request->input('address');
        $student->save();
        return redirect('/studentdetails')->with('success', 'Slot is Updated');
    }
    $departments = Department::all();
    $student = Student::find($id);
    return view('edit', ['student' => $student, 'departments' => $departments]);
})->middleware('auth');

// Sign Up
Route::match(['get', 'post'], '/signup', function (Request $request) {
    if ($request->isMethod('post')) {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return redirect('/signup')->with('warning', 'Email Already Exists');
        }
        $newUser = new User();
        $newUser->username = $username;
        $newUser->email = $email;
        $newUser->password = Hash::make($password);
        $newUser->save();
        return redirect('/login')->with('success', 'Signup Successful. Please Login');
    }
    return view('signup');
});

// Login
Route::match(['get', 'post'], '/login', function (Request $request) {
    if ($request->isMethod('post')) {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            // Authenticated
            return redirect('/')->with('primary', 'Login Success');
        } else {
            // Invalid credentials
            return redirect('/login')->with('danger', 'Invalid Credentials');
        }
    }
    return view('login');
});

// Logout
Route::get('/logout', function () {
    // Logout Logic
    return redirect('/login')->with('warning', 'Logout Successful');
})->middleware('auth');

// Add Student
Route::match(['get', 'post'], '/addstudent', function (Request $request) {
    $departments = Department::all();
    if ($request->isMethod('post')) {
        $student = new Student();
        $student->rollno = $request->input('rollno');
        $student->sname = $request->input('sname');
        $student->sem = $request->input('sem');
        $student->gender = $request->input('gender');
        $student->branch = $request->input('branch');
        $student->email = $request->input('email');
        $student->number = $request->input('num');
        $student->address = $request->input('address');
        $student->save();
        return redirect('/addstudent')->with('info', 'Booking Confirmed');
    }
    return view('student', ['departments' => $departments]);
})->middleware('auth');

// Test Database Connection
Route::get('/test', function () {
    try {
        // Test your database connection here
        Student::all();
        return 'My database is Connected';
    } catch (Exception $e) {
        return 'My db is not Connected';
    }
});

// Start the Laravel Application
Route::middleware(['web', 'auth'])->get('/*', function () {
    return view('index');
});

//APP_NAME=Laravel
//APP_ENV=local
//APP_KEY=base64:SomeRandomKeyHere
//APP_DEBUG=true
//APP_URL=http://localhost

//DB_CONNECTION=mysql
//DB_HOST=127.0.0.1
//DB_PORT=3306
//DB_DATABASE=students
//DB_USERNAME=root
//DB_PASSWORD=


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('rollno');
            $table->string('sname');
            $table->integer('sem');
            $table->string('gender');
            $table->string('branch');
            $table->string('email');
            $table->string('number');
            $table->string('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}