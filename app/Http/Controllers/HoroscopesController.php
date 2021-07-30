<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Zodiac_signs;
use App\Models\Horoscopes;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HoroscopesController extends Controller
{
    /*
     * Landing page of the site
     */
    public function index()
    {
        $final_data = array();
        $zodiac_signs = Zodiac_signs::get();
        $year = date("Y");
        $zodiac_signs_selected = '';
        $year_selected = '';
        //null value set for best_month form
        $bzodiac_signs_selected = '';
        $byear_selected = '';
        //null value set for best_year form
        $byyear_selected = '';
        //dd($zodiac_signs);
        return view('welcome',compact('zodiac_signs','zodiac_signs_selected','bzodiac_signs_selected','year','year_selected','byear_selected','byyear_selected','final_data'));
    }

    /*
     * Horoscope score generation page
     */
    public function generate()
    {
        $zodiac_signs = Zodiac_signs::get();
        $year = date("Y");
        //dd($zodiac_signs);
        return view('generate-horoscopes',compact('zodiac_signs','year'));
    }

    /*
     * Horoscope store function
     * accepts request/input parameter
     */
    public function store(Request $request)
    {
        $request->validate([
            'zodiac_signs' => 'required',
            'year' => 'required',
        ]);

        $zodiac_signs = $request->zodiac_signs;
        $year = $request->year;

        //protect from duplicate entry
        $entry_exist = Horoscopes::where('zodiac_sign_id',$zodiac_signs)->where('year',$year)->get();
        if($entry_exist->isEmpty()){
            //loop for year->month->day
            //$date=new DateTime();
            for($m=1; $m<=12; $m++){
                $month = $m;
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                for ($d = 1; $d <= $daysInMonth; $d++)
                {
                    $day = $d;
                    $horoscope_score = rand(1,10);
                    Horoscopes::create([
                        'zodiac_sign_id' => $zodiac_signs,
                        'horoscope_score' => $horoscope_score,
                        'day' => $day,
                        'month' => $month,
                        'year' => $year,
                    ]);
                }
                //dd($month);
            }
            return redirect()->route('horoscopes.generate')
                ->with('success','Horoscopes stored successfully.');
        }else{
            return redirect()->route('horoscopes.generate')
                ->withErrors('Duplicate entry!');
        }

    }

    /*
     * Horoscope calendar view create
     * accepts request parameter
     * return array output
     */
    public function calendar(Request $request)
    {
        $request->validate([
            'zodiac_signs' => 'required',
            'year' => 'required',
        ]);

        $zodiac_signs = Zodiac_signs::get();
        $year = date("Y");
        $zodiac_signs_selected = $request->zodiac_signs;
        $year_selected = $request->year;
        $init_date = "$year_selected-01-01";
        //null value set for best_month form
        $bzodiac_signs_selected = '';
        $byear_selected = '';
        //null value set for best_year form
        $byyear_selected = '';
        //dd($init_date);

            //if($request->ajax()) {
            $data = Horoscopes::select('id', 'horoscope_score', DB::raw('concat(year,"-",month,"-",day) as start'))
                ->where('zodiac_sign_id', $zodiac_signs_selected)
                ->where('year',  $year_selected)
                ->get();
            //dd(response()->json($data));
            $manipulated_data = array();
            for($i=0;$i<count($data);$i++){
                //$manipulated_data[$i]["title"] = $data[$i]["title"];
                $manipulated_data[$i]["start"] = date_format(date_create($data[$i]["start"]),"Y-m-d");
                $manipulated_data[$i]["color"] = $this->get_color_code($data[$i]["horoscope_score"]);
                $manipulated_data[$i]["display"] = "background";
            }
            //dd(response()->json($manipulated_data));
            $final_data =  $manipulated_data;
        //}
        $initial_date = date_format(date_create($init_date),"Y-m-d");

        return view('welcome',compact('zodiac_signs','zodiac_signs_selected','bzodiac_signs_selected','year','year_selected','byear_selected','byyear_selected','final_data','initial_date'));
    }

    /*
     * Only private function
     * accepts parameter
     * Horoscope score generation page
     * Set color based on Horoscope score
     */
    private function get_color_code($score)
    {
        switch ($score) {
            case "1":
                $code = "#ff0000";
                break;
            case "2":
                $code = "#ff3300";
                break;
            case "3":
                $code = "#ff4000";
                break;
            case "4":
                $code = "#ff8000";
                break;
            case "5":
                $code = "#ffbf00";
                break;
            case "6":
                $code = "#ffff00";
                break;
            case "7":
                $code = "#bfff00";
                break;
            case "8":
                $code = "#80ff00";
                break;
            case "9":
                $code = "#40ff00";
                break;
            case "10":
                $code = "#00ff00";
                break;
            default:
                $code = "";
        }
        return $code;
    }

    /*
     * Horoscope calendar view create for the best month
     * accepts request parameter
     * return array output
     */
    public function best_month_calendar(Request $request)
    {
        $request->validate([
            'zodiac_signs' => 'required',
            'year' => 'required',
        ]);

        $zodiac_signs = Zodiac_signs::get();
        $year = date("Y");
        $bzodiac_signs_selected = $request->zodiac_signs;
        $byear_selected = $request->year;
        //null value set for calendar form
        $zodiac_signs_selected = '';
        $year_selected = '';
        //null value set for best_year form
        $byyear_selected = '';

        //get data for the selected year and zodiac sign
        $data = Horoscopes::select('id', 'horoscope_score', DB::raw('concat(year,"-",month,"-",day) as start'))
            ->where('zodiac_sign_id', $bzodiac_signs_selected)
            ->where('year',  $byear_selected)
            ->get();

        //dd(response()->json($data));
        $manipulated_data = array();
        for($i=0;$i<count($data);$i++){
            //$manipulated_data[$i]["title"] = $data[$i]["title"];
            $manipulated_data[$i]["start"] = date_format(date_create($data[$i]["start"]),"Y-m-d");
            $manipulated_data[$i]["color"] = $this->get_color_code($data[$i]["horoscope_score"]);
            $manipulated_data[$i]["display"] = "background";
        }
        $final_data =  $manipulated_data;

        //get the best month for the selected year and zodiac sign
        $best_month = Horoscopes::select('month', DB::raw('AVG(horoscope_score) as average_score'))
            ->where('zodiac_sign_id', $bzodiac_signs_selected)
            ->where('year',  $byear_selected)
            ->groupby('month')
            ->orderby('average_score','DESC')
            ->limit(1)
            ->get();
        //dd($best_month[0]->month);

        //init date
        $init_date = $byear_selected."-".$best_month[0]->month."-01";
        $initial_date = date_format(date_create($init_date),"Y-m-d");

        return view('welcome',compact('zodiac_signs','zodiac_signs_selected','bzodiac_signs_selected','year','year_selected','byear_selected','byyear_selected','final_data','initial_date'));
    }

    /*
     * Best year for which zodiac sign
     * accepts request parameter
     * return single output
     */
    public function best_of_year(Request $request)
    {
        $request->validate([
            'year' => 'required',
        ]);

        $zodiac_signs = Zodiac_signs::get();
        $year = date("Y");
        $byyear_selected = $request->year;

        //null value set for calendar form
        $zodiac_signs_selected = '';
        $year_selected = '';
        //null value set for best_month form
        $byear_selected = '';
        $bzodiac_signs_selected = '';

        //get the zodiac sign has the best year
        $best_zodiac_sign_query = DB::table('horoscopes')
            ->join('zodiac_signs','horoscopes.zodiac_sign_id','=','zodiac_signs.id')
            ->select('zodiac_signs.name', DB::raw('AVG(horoscopes.horoscope_score) as average_score'))
            ->where('year',  $byyear_selected)
            ->groupby('zodiac_signs.name')
            ->orderby('average_score','DESC')
            ->limit(1)
            ->get();
        //dd($best_zodiac_sign);
        $best_zodiac_sign = $best_zodiac_sign_query[0]->name;

        return view('welcome',compact('zodiac_signs','zodiac_signs_selected','bzodiac_signs_selected','year','year_selected','byear_selected','byyear_selected','best_zodiac_sign'));
    }
}
