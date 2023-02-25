<?php

namespace App\Http\Controllers\Front;

use App\Model\Doctor;
use App\Model\History;
use App\Model\Patient;
use App\Model\PatientRequest;
use App\Model\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDF;
use App\Newsletter;
use App\Model\Message;
use App\Model\Blog;
use App\Model\ApptTime;
class FrontController extends Controller
{

    public function index(){
        return redirect()->route('admin.dashboard');
    }
}
