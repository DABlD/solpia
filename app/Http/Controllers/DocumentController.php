<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AuditTrail;
use DB;
use Browser;

class DocumentController extends Controller
{
    public function get(Request $req){
        $document = DB::table($req->table)->select($req->cols ?? "*");

        // IF HAS WHERE
        if($req->where){
            $document = $document->where($req->where[0], $req->where[1]);
        }

        // IF HAS WHERE
        if($req->where2){
            $document = $document->where($req->where2[0], $req->where2[1]);
        }

        if($req->first){
            $document = $document->first();
        }
        else{
            $document = $document->get();
        }

        echo json_encode($document);
    }

    public function update(Request $req){
        $document = DB::table($req->table)->where('id', $req->id)->update($req->data);

        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => "updated document $req->id",
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);
    }
}
