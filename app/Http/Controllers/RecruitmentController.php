<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Applicant, SeaService};
use App\Models\{TempApplicant, TempSeaService};
use App\{User, TempUser};

class RecruitmentController extends Controller
{
    public function __construct(){
        $this->middleware('permissions:' . 'Admin/Recruitment Officer');
    }

    public function index(){
        return $this->_view('index', [
            'title' => "Recruitment"
        ]);
    }

    private function _view($view, $data = array()){
        return view('recruitments.' . $view, $data);
    }
}
