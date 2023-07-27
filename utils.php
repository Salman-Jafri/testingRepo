<?php
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\CarsMake;
use App\Models\CarsModel;
use App\Models\CarsSubModel;
use App\Models\Vendors;
use App\Models\BankAccounts;
use App\Models\FeaturesLevel;
use App\Models\PartsCategory;
use App\Models\CodeGenrator;
use App\Models\Countries;
use DB;
function memberMainPath()
{
	return public_path('members_data');
}
function memberPath($uid=null)
{
	return public_path('members_data/'.$uid);
}

function hlp_gen_years($start=null,$rev=false,$add=null,$last_select=null)
{
  if($start==null)
  {
    $start=2000;
  }
  $end = date('Y');
  if($add!=null)
  {
    $end = ($end+$add);
  }
  $years=null;
  if($rev)
  {
      for($i=$start;$i<=$end;$i++)
      {
        $years .='<option value="'.$i.'" '.$last_select.'>'.$i.'</option>';
      }
  }
  else
  {
      for($i=$end;$i>=$start;$i--)
      {
        $years .='<option value="'.$i.'" '.$last_select.'>'.$i.'</option>';
      }

  }
  return $years;
}

function get_column($table,$col_sname,$col_sval,$col_gname,$rval='n/a')
{
    $col_gval=$rval;
    $last_row = DB::table($table)->where($col_sname,$col_sval)->first();
    if($last_row)
    {
      $col_gval=$last_row->$col_gname;
    }
    return $col_gval;
}


 function visits_all()
 {
    $ip_address=request()->ip();
    $agent = new Agent();
    $platform= $agent->platform();
    if($agent->isDesktop())
    {
     $device_type= 'desktop';
    }
    else if($agent->isPhone() || $agent->isMobile())
    {
     $device_type= 'mobile';
    }
    else if($agent->isTablet())
    {
     $device_type= 'tablet';
    }

   $browser = $agent->browser();
   $bversion = $agent->version($browser);
   $pversion = $agent->version($platform);

    $ins_array = array(
        'ip_address'=>$ip_address,
        'device_type'=>$device_type,
        'platform'=>$platform,
        'platform_version'=>$pversion,
        'browser_version'=>$browser.'-'.$bversion,
        'dated'=>date('Y-m-d h:m:i'),
    );
     DB::table('ac_web_visits')->insert($ins_array);

 }

function visits_links()
{

   $excluded_links = array(
        'https://cars-importers.com/cars/list/make/favicon.ico'
    );
   $referrer = url()->previous();
   $link     = url()->current();
   if(!in_array($link, $excluded_links))
   {

    $ip_address=request()->ip();
    $agent = new Agent();
    $platform= $agent->platform();
    if($agent->isDesktop())
    {
     $device_type= 'desktop';
    }
    else if($agent->isPhone() || $agent->isMobile())
    {
     $device_type= 'mobile';
    }
    else if($agent->isTablet())
    {
     $device_type= 'tablet';
    }
    $browser = $agent->browser();
    $bversion = $agent->version($browser);
    $ins_array = array(
        'referrer'=>$referrer,
        'link'=>$link,
        'ip_address'=>$ip_address,
        'device_type'=>$device_type,
        'platform'=>$platform,
        'platform_version'=>$platform.'-'.$agent->version($platform),
        'browser_version'=>$browser.'-'.$bversion,
        'dated'=>date('Y-m-d h:m:i'),
      );
    DB::table('ac_web_link_visits')->insert($ins_array);

   }

}


function visits_car($car_id)
{
    $ip_address=request()->ip();
    $agent = new Agent();
    $platform= $agent->platform();
    if($agent->isDesktop())
    {
       $device_type= 'desktop';
   }
   else if($agent->isPhone() || $agent->isMobile())
   {
       $device_type= 'mobile';
   }
   else if($agent->isTablet())
   {
       $device_type= 'tablet';
   }

   $browser = $agent->browser();
   $bversion = $agent->version($browser);
   $pversion = $agent->version($platform);

   $ins_array = array(
       'car_id'=>$car_id,
       'ip_address'=>$ip_address,
       'device_type'=>$device_type,
       'platform'=>$platform,
       'platform_version'=>$pversion,
       'browser_version'=>$browser.'-'.$bversion,
       'dated'=>date('Y-m-d h:m:i'),
   );
   DB::table('ac_web_car_visits')->insert($ins_array);

}


function hlp_nf($string,$dp=0,$dh=true)
{
   if($dh)
   {
      return str_replace(',','',number_format($string,$dp));
   }
   else
   {
      return number_format($string,$dp);
   }
}


function hlp_format_date($format,$date)
{
  $text = date($format,strtotime($date));
  return $text;
}

function hlp_posted_at($timestamp)
{
    $first_date = new DateTime($timestamp);
    $second_date = new DateTime(date('Y-m-d h:i:s'));
    $difference = $first_date->diff($second_date);
    return format_interval($difference);
}


function format_interval(DateInterval $interval)
{
      // $ci =& get_instance();

      $result =null;
      // if($ci->session->lang=='_ar')
      // {
      //     if ($interval->y)
      //     {
      //       $result .= $interval->format("%y");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' سنة ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' سنوات  ';
      //       }
      //     }
      //     else if ($interval->m)
      //     {
      //       $result .= $interval->format("%m");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' شهر ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' أشهر   ';
      //       }
      //     }
      //     else if ($interval->d)
      //     {
      //       $result .= $interval->format("%d");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' يوم ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' أيام  ';
      //       }
      //     }
      //     else if ($interval->h)
      //     {
      //       $result .= $interval->format("%h");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' ساعة ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' ساعات  ';
      //       }
      //     }
      //     else if ($interval->i)
      //     {
      //       $result .= $interval->format("%i");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' دقيقة ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' دقائق  ';
      //       }
      //     }
      //     else if ($interval->s)
      //     {
      //       $result .= $interval->format("%s");
      //       if($result<2)
      //       {
      //           $result ='قبل '.$result.' ثانية ';
      //       }
      //       else
      //       {
      //           $result ='قبل '.$result.' ثواني  ';
      //       }
      //     }

      // }
      // else
      // {
         if ($interval->y) { $result .= $interval->format("%y year(s) ago"); }
         else if ($interval->m) { $result .= $interval->format("%m month(s) ago"); }
         else if ($interval->d) { $result .= $interval->format("%d day(s) ago "); }
         else if ($interval->h) { $result .= $interval->format("%h hour(s) ago"); }
         else if ($interval->i) { $result .= $interval->format("%i minute(s) ago"); }
         else if ($interval->s) { $result .= $interval->format("%s second(s) ago"); }
      // }

      return $result;
}

function hide_mail($email)
{
  $mail_part = explode("@", $email);
  $mail_part[0] = str_repeat("*", strlen($mail_part[0]));
  return implode("@", $mail_part);
}

function getCountries()
{
    $options ='<option value="" selected>No Data Found</option>';
    $countries = Countries::orderBy('name','ASC')->get();
    if($countries->count()>0)
    {
        $options = '<option value="" selected>Countries</option>';
        foreach($countries as $rows)
        {
          $options .='<option value="'.$rows->id.'">'.$rows->name.'</option>';
        }
    }
    echo $options;
}
function getCountryCode()
{
    $options ='<option value="" selected>No Data Found</option>';
    $countries = Countries::orderBy('name','ASC')->get();
    if($countries->count()>0)
    {
        $options = '<option value="" selected>Code #</option>';
        foreach($countries as $rows)
        {
          $options .='<option value="'.$rows->id.'" data-iso="'.$rows->iso2.'"> '.$rows->iso2.' ('.$rows->phonecode.')</option>';
        }
    }
    echo $options;
}

function GetModel($make_id=null,$model_id=null,$rtype='echo')
{

      $options ='<option value="" selected>No Data Found</option>';
      $carsmodel = CarsModel::where('make_id',$make_id)->orderBy('model','ASC')->get();
      if($carsmodel->count()>0)
      {
        $options = '<option value="" selected>Choose</option>';
        if($model_id!=null)
        {
          foreach($carsmodel as $rows)
          {
            if($rows->uid==$model_id)
            {
              $options .='<option value="'.$rows->uid.'" selected>'.$rows->model.'</option>';
            }
            else
            {
              $options .='<option value="'.$rows->uid.'">'.$rows->model.'</option>';
            }
          }

        }
        else
        {

          foreach($carsmodel as $rows)
          {
            $options .='<option value="'.$rows->uid.'">'.$rows->model.'</option>';
          }

        }
      }
      if($rtype=='echo')
      {
        echo $options;
      }

      else
      {
        return $options;
      }

}

function GetSubModel($model_id=null,$sub_model_id=null,$rtype='echo')
{

      $options ='<option value="" selected>No Data Found</option>';
      $carssubmodel = CarsSubModel::where('model_id',$model_id)->orderBy('sub_model','ASC')->get();
      if($carssubmodel->count()>0)
      {
        $options = '<option value="" selected>Choose</option>';
        if($sub_model_id!=null)
        {
          foreach($carssubmodel as $rows)
          {
            if($rows->uid==$sub_model_id)
            {
              $options .='<option value="'.$rows->uid.'" selected>'.$rows->sub_model.'</option>';
            }
            else
            {
              $options .='<option value="'.$rows->uid.'">'.$rows->sub_model.'</option>';
            }
          }

        }
        else
        {

          foreach($carssubmodel as $rows)
          {
            $options .='<option value="'.$rows->uid.'">'.$rows->sub_model.'</option>';
          }

        }
      }
      if($rtype=='echo')
      {
        echo $options;
      }

      else
      {
        return $options;
      }

}
function getVendors()
{
    $options ='<option value="" selected>No Data Found</option>';
    $vendors = Vendors::orderBy('title','ASC')->get();
    if($vendors->count()>0)
    {
        $options = '<option value="" selected>Vendors</option>';
        foreach($vendors as $rows)
        {
          $options .='<option value="'.$rows->uid.'">'.$rows->title.'</option>';
        }
    }
    echo $options;
}


function getMakes()
{
    $options ='<option value="" selected>No Data Found</option>';
    $make = CarsMake::orderBy('make','ASC')->get();
    if($make->count()>0)
    {
        $options = '<option value="" selected>make</option>';
        foreach($make as $rows)
        {
          $options .='<option value="'.$rows->uid.'">'.$rows->make.'</option>';
        }
    }
    echo $options;
}

function getFeaturesLevel()
{
    $options ='<option value="" selected>No Data Found</option>';
    $make = FeaturesLevel::orderBy('title','ASC')->get();
    if($make->count()>0)
    {
        $options = '<option value="" selected>Feature level</option>';
        foreach($make as $rows)
        {
          $options .='<option value="'.$rows->uid.'">'.$rows->title.'</option>';
        }
    }
    echo $options;
}

function getCategory()
{
    $options ='<option value="" selected>No Data Found</option>';
    $category = PartsCategory::orderBy('title','ASC')->get();
    if($category->count()>0)
    {
        $options = '<option value="" selected>Category</option>';
        foreach($category as $rows)
        {
          $options .='<option value="'.$rows->uid.'">'.$rows->title.'</option>';
        }
    }
    echo $options;
}

function getBankAccounts()
{
    $options ='<option value="" selected>No Data Found</option>';
    $make = BankAccounts::orderBy('bank_title','ASC')->get();
    if($make->count()>0)
    {
        $options = '<option value="" selected>Bank Account</option>';
        foreach($make as $rows)
        {
          $options .='<option value="'.$rows->uid.'">'.$rows->bank_title.'</option>';
        }
    }
    echo $options;
}

function MakingCode($make,$model,$reqType,$year)
{

    $codemsg='';
    $cars = CarsModel::where('uid',$model)->first();
    if($cars)
    {
      if(!empty($cars->model_code))
      {
        if($reqType=='car')
        {
            $codetable=CodeGenrator::where('model_id',$model)->count();
            if($codetable>0)
            {
              $codemsg=strtoupper($cars->model_code.'-'.($codetable+1));   
            }
            else
            {
              strtoupper($codemsg=$cars->model_code.'-'.'1');  
            }
        }
        else if($reqType=='part')
        {
          strtoupper($codemsg=$cars->model_code.'-X-'.$year);
        }

      }else
      {
        $codemsg='Please add code in models';
      }

    }else
    {  
      $codemsg='Invalid Model';
    }

    echo json_encode(['code'=>$codemsg]);

        // if($type==null)
        // {
        //  $newcode= $ready;
        // }else if ($type=='addpart') 
        // {
        //  $exp = explode('-', $ready);
        //  $newcode=$exp[0].'-X-'.$exp[1];
        //  // echo $newcode;
        // }
        // echo $newcode;

    // $make_name=get_column('cars_make','uid',$make,'make');
    // $model_name=get_column('cars_model','uid',$model,'model');   
    // $count=0;
    // $cars = CarsModel::where('uid',$model)->get();
    // if($cars->count()>0)
    // {
    //     $codetable=CodeGenrator::where('model_id',$model)->count();
    //      $count=$codetable+1;
    
    // $new_make= substr($make_name,0,3);
    // $new_model= substr($model_name,0,3);
    // $new_yearfrom= substr($yearfrom,2,4);
    // $new_yearto= substr($yearto,2,4);
    // if(!empty($yearto) && $yearto!=null)
    // {
    //     $code = strtoupper($new_make.$new_model.'-'.$new_yearfrom.'-'.$new_yearto.'-'.$count);
    // }else
    // {
    //     $code = strtoupper($new_make.$new_model.'-'.$yearfrom.'-'.$count);
    // }


    // }
    // echo json_encode(['code'=>$code]);
}   


 function make_history($table,$unique_id,$do_what)
  {
    if($do_what=='insert')
    {
      if($table=='expenses')
      {
        $uid = 'expense_id';
        $column = 'expense_title';
        $project_column = 'expense_project';
        $history_column = 'amount_out';
        $amount_column = 'expense_amount';
        
      }
      if($table=='income')
      {
        $uid = 'income_id';
        $column = 'income_title';
        $project_column = 'income_category';
        $history_column = 'amount_in';
        $amount_column = 'income_amount';
      }
      if($table=='assets')
      {
        $uid = 'assets_id';
        $column = 'asset_title';
        $project_column = null;
        $history_column = 'amount_out';
        $amount_column = 'asset_price';
      }
      // if($table=='tax')
      // {
      //   $uid = 'tax_id';
      //   $column = 'notes';
      //   $project_column = null;
      //   $history_column = 'amount_out';
      //   $amount_column = 'amount';
      // }
      $description = get_column($table,$uid,$unique_id,$column);
      $amount      = get_column($table,$uid,$unique_id,$amount_column);
      if($project_column!=null){
        $type_project= get_column($table,$uid,$unique_id,$project_column);
      }
      else
      {
        $type_project=null; 
      }
      $ins_array = array(
        'type'=>$table,
        'type_uid'=>$unique_id,
        'type_project'=>$type_project,
        'description'=>$description,
        $history_column=>$amount,
        'dated'=>date('Y-m-d h:i:s'),
        'created_by'=>auth()->user()->uid,
      );
      DB::table('history')->insert($ins_array);
      // $this->db->insert('history',$ins_array);
      
    }
    if($do_what=='delete')
    {
      DB::table('history')->where('type', '=', $table)->where('type_uid','=',$unique_id)->delete();
    }


  }
function generatePartsNotification($part_quantity,$part_limit,$part_name,$record_id)
  {
    if($part_quantity <= $part_limit){

      $message = $part_name.' quantity reached to '.$part_quantity;

      $ins_array = array('record_id'=>$record_id,'type'=>'parts','message'=>$message,'created_by'=>auth()->user()->uid);

      DB::table('notifications')->insert($ins_array);
    }
  }


function genrateInvoiceHelper($table,$uid,$column,$pre)
{
      $id =0;
      $invoice = 0;
      $date = date('m/Y');
      $query=DB::table($table)->orderBy($uid,'desc')->limit(1)->get();
      if($query->count()>0)
      {
          foreach ($query as  $rows) 
          {
              $id = $rows->$uid;
          }
          $invoice = $id+1;
          $invoice = '000000'.$invoice;
          if(strlen($invoice)!=7)
          {
             $len = (strlen($invoice)-7);
             $invoice = substr($invoice,$len);
          }
          $invoice = $pre.'-'.$invoice;
      }
      else
      {
          $invoice = $pre.'-0000001';
      }   
       $insquery=DB::table($table)->insertGetId([$column=>$invoice]);
       if($insquery>0)
       {
          $quer=DB::table($table)->orderBy($uid,'desc')->limit(1)->get();
          if($quer->count()>0)
          {
              foreach ($quer as  $rows) 
              {
                  $invoice = $rows->$column;
              }
          }
          return $invoice;
       }
       else
       {
          return 'err';
       }

}