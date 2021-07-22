<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Auth;
//use Excel;
use App\Models\UserProfile;

class ExprtExcelController extends Controller
{
    public function index()
    {
        $user_data = DB::table('users')->get();
        return view('user.export_excel')->with('user_data', $user_data);
    }
    public function excel()
    {
        $customer_data = UserProfile::with(['seekersData'])
            ->where('expert_id', Auth::user()->id)
            ->distinct()
            ->where('email_optin', '1')
            ->get(['seeker_id']);

        $newArray = array();
        $newArray[0]['first_name']   = 'First Name';
        $newArray[0]['last_name']    = 'Last Name';
        $newArray[0]['name']         = 'User Name';
        $newArray[0]['email']        = 'User Email';
        $mk = 1;
        foreach ($customer_data as $key => $customer) {
            $newArray[$mk]['first_name']   = $customer['seekersData']['first_name'];
            $newArray[$mk]['last_name']    = $customer['seekersData']['last_name'];
            $newArray[$mk]['name']         = $customer['seekersData']['name'];
            $newArray[$mk]['email']        = $customer['seekersData']['email'];
            $mk++;
        }
        $this->array_to_csv_download($newArray, "exportEmails.csv", ",");
    }
    public function array_to_csv_download($array, $filename = "exportEmails.csv", $delimiter = ";")
    {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://memory', 'w');
        // loop over the input array
        foreach ($array as $line) {
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter);
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        // tell the browser it's going to be a csv file
        header('Content-Type: application/csv');
        // tell the browser we want to save it instead of displaying it
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        // make php send the generated csv lines to the browser
        fpassthru($f);
    }
}
