<?php

namespace App\Http\Controllers\admin\purchases;

use App\Http\Controllers\Controller;
use App\Models\Vendors;
use App\Models\HideShowColumns;
use Illuminate\Http\Request;
use File;
use DB;

class VendorsController extends Controller
{
    public function vendors()
    {
        $HideShowColumns=HideShowColumns::all();
        $param=['columns'=>$HideShowColumns];
        return view('admin.purchases.vendors')->with($param);
    }
    
    public function add(Request $request)
    {
      $error_log=array();
      $errors_counter = 0 ;
      $msg = null;
      $errors = $request->validate([
            'title' => 'required',
            'country_id' => 'required',
            'phonecode_id' => 'required',
            'contact' => 'required|unique:vendors',
            'emails' => 'required|unique:vendors',
            'notes' => 'required',
      ]);
      $vendor_uniqueid = genrateInvoiceHelper('vendors_uniqueid','vendor_uid','u_number',ucfirst('VEN'));

          $vendor = new Vendors;
          $vendor->vendor_sr_no=$vendor_uniqueid; 
          $vendor->title=$request->title;  
          $vendor->contact=$request->contact;
          $vendor->country_id=$request->country_id;
          $vendor->phonecode_id=$request->phonecode_id;
          $vendor->emails=$request->emails;
          $vendor->cr_number=$request->cr_number;
          $vendor->account_number=$request->account_number;
          $vendor->branch=$request->branch;
          $vendor->address=$request->address;
          $vendor->vat=$request->vat;
          $vendor->notes=$request->notes;
          $vendor->created_by=auth()->user()->uid;
          if($vendor->save())
          {
              $msg = 'success';
          }
          else
          {
              $msg = 'error';
          }
       
       
       echo json_encode(array('token',$msg));

    }
    
    public function show(Request $request)
    {
        
       $draw = intval($request->draw);
       $start = intval($request->start);
       $length = intval($request->length);
       $order = $request->order;
       $search= $request->search;
       $search = $search['value'];
       $col = 0;
       $dir = "";

       if(!empty($order)) 
       {
          foreach($order as $o) 
          {
            $col = $o['column'];
            $dir= $o['dir'];
          }
       }

          if($dir != "asc" && $dir != "desc") 
          {
            $dir = "desc";
          }

          $valid_columns = array(
           0=>'vendor_sr_no',
           1=>'title',
           2 =>'country_id',
           3 =>'phonecode_id',
           4=>'contact',
           5=>'emails',
           6=>'cr_number',
           7=>'account_number',
           8=>'branch',
           9=>'address',
           10=>'vat',
           11=>'notes',
           12=>'' 

         );

          if(!isset($valid_columns[$col])) 
          {
           $order = null;
          } 
         else 
         {
           $order = $valid_columns[$col];
         }

         $vendors = DB::table('vendors');
         if(!empty($search))
         {
           $x=0;

           foreach($valid_columns as $sterm)
           {
             if(!empty($sterm))
             {

               if($x==0)
               {
                                   // $this->db->like($sterm,$search);
                 $vendors->where($sterm, 'LIKE', '%'.$search.'%');
               }
               else
               {
                                   // $this->db->or_like($sterm,$search);
                $vendors->orWhere($sterm, 'LIKE', '%'.$search.'%');
              }
              $x++;
            }
          }                 
        }

        if($order !=null) 
        {
          $vendors->orderBy($order,$dir);
        }
        else
        {
          $vendors->orderBy('uid','DESC');
        }

        $query=$vendors->offset($start)->limit($length);
               // $str   = $this->db->last_query();
               // echo $str;
               // exit;
        $data = array();
        $sno = 0;
        if(!empty($query))
        {
         foreach($query->get() as $rows)
         {

          $chkDelete=$this->checkExist('purchase','vendor_id',$rows->uid);

           $sno++;
           $json[]= array(
                    $rows->vendor_sr_no,
                    $rows->title,
                    get_column('countries','id',$rows->country_id,'name','-'),
                    get_column('countries','id',$rows->phonecode_id,'phonecode','-'),
                    $rows->contact,
                    $rows->emails,
                    $rows->vat,
                    $rows->cr_number,
                    $rows->account_number,
                    $rows->branch,
                    $rows->address,
                    $rows->notes,
                    '<ul class="action"> 
                      <li class="edit"> <a href="#" id="'.$rows->uid.'" data-bs-toggle="modal" data-bs-target="#edit-modal" data-title="edit"><i class="icon-pencil-alt"></i></a></li>
                      <li class="delete"><a href="#" class="ml-1 text-danger '.$chkDelete.'" data-bs-toggle="modal" data-bs-target="#delete-modal" lbl="btn-delete" id="'.$rows->uid.'" data-title="delete"><i class="icon-trash"></i></a></li>
                    </ul>',
          );     

         }    
         $total_members = $this->get_total_members();
         $output = array(
           "draw" => $draw,
           "recordsTotal" => $total_members,
           "recordsFiltered" => $total_members,
           "data" => $json,
         );
         echo json_encode($output);
         exit(); 
        }
        else
        {
         $response = array();
         $response['sEcho'] = 0;
         $response['iTotalRecords'] = 0;
         $response['iTotalDisplayRecords'] = 0;
         $response['aaData'] = [];
         echo json_encode($response);
        }
    }
    public function get_total_members()
    {
        $result=Vendors::count();
        if(isset($result)) return $result;
        return 0;
    }
    public function edit(Request $request)
    {
        $edit_result =   Vendors::where('uid',$request->unique_id)->first();
        echo json_encode(array('token_value',$edit_result));
    }

    public function update(Request $request)
    {
       $uid = $request->unique_id;
       $msg = null;

        $errors = $request->validate([
            'title' => 'required',
            'country_id' => 'required',
            'phonecode_id' => 'required',
            'contact' => 'required|unique:vendors,contact,' . $uid . ',uid',
            'emails' => 'required|unique:vendors,emails,' . $uid . ',uid',
            'notes' => 'required',
        ]);

          $vendor = Vendors::find($request->unique_id);
          $vendor->title=$request->title;  
          $vendor->contact=$request->contact;
          $vendor->country_id=$request->country_id;
          $vendor->phonecode_id=$request->phonecode_id;
          $vendor->emails=$request->emails;
          $vendor->cr_number=$request->cr_number;
          $vendor->account_number=$request->account_number;
          $vendor->branch=$request->branch;
          $vendor->address=$request->address;
          $vendor->vat=$request->vat;
          $vendor->notes=$request->notes;
           $vendor->updated_by=auth()->user()->uid;
           if($vendor->update())
           {
               $msg = 'success';
           }
           else
           {
               $msg = 'error';
           }
        
        
        echo json_encode(array('token',$msg));  
    }

    public function delete(Request $request)
    {
        $vednors = Vendors::where(['uid'=>$request->unique_id])->get();  
        if($vednors->isNotEmpty())
        { 

          $path='all_images/vendors_images/';
          foreach($vednors as $rows)
          {

            if (is_file(public_path($path.$rows->image))) {
                 File::delete(public_path($path.$rows->image));
             }
          }   
         $status=  Vendors::find($request->unique_id)->delete(); 
        }

        if($status==1)
        {
            echo json_encode(array('token','success'));
        }else
        {
            echo json_encode(array('token','error'));
        }
    }

}
