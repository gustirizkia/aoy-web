<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Illuminate\Http\Request as HttpRequest;

class AdminTransaksisController extends \crocodicstudio\crudbooster\controllers\CBController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "payment_name";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = true;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = true;
        $this->button_delete = false;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "transaksis";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label"=>"User","name"=>"user_id","join"=>"users,name"];
        $this->col[] = ["label"=>"Invoice","name"=>"no_inv"];
        $this->col[] = ["label"=>"Jenis Order","name"=>"jenis_inv"];
        $this->col[] = ["label"=>"Metode Pembayaran","name"=>"payment_name"];
        $this->col[] = ["label"=>"Admin Pembayaran","name"=>"fee_customer"];
        $this->col[] = ["label"=>"Biaya Pengiriman","name"=>"biaya_pengiriman"];
        $this->col[] = ["label"=>"Metode Pengiriman","name"=>"metode_pengiriman"];
        $this->col[] = ["label"=>"Status","name"=>"status"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label'=>'User','name'=>'user_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'users,name'];
        $this->form[] = ['label'=>'No Inv','name'=>'no_inv','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Jenis Inv','name'=>'jenis_inv','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Metode Pembayaran','name'=>'metode_pembayaran','type'=>'select', 'dataenum'=>'MYBVA;PERMATAVA;BNIVA;BRIVA;BCAVA;CIMBVA;ALFAMART','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Biaya Pengiriman','name'=>'biaya_pengiriman','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Admin Pembayaran','name'=>'admin_pembayaran','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Metode Pengiriman','name'=>'metode_pengiriman','type'=>'select', 'dataenum'=>'antaraja;sicepat;jnt;jne', 'validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Payment At','name'=>'payment_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Sub Total','name'=>'sub_total','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Pay Code','name'=>'pay_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Expired Time','name'=>'expired_time','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Fee Customer','name'=>'fee_customer','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Payment Name','name'=>'payment_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Total Harga Barang','name'=>'total_harga_barang','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Diskon','name'=>'diskon','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        // $this->form[] = ['label'=>'Reference','name'=>'reference','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        $this->form[] = ['label'=>'Alamat Lengkap','name'=>'alamat_lengkap','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>'User','name'=>'user_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'users,name'];
        //$this->form[] = ['label'=>'No Inv','name'=>'no_inv','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Jenis Inv','name'=>'jenis_inv','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Metode Pembayaran','name'=>'metode_pembayaran','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Biaya Pengiriman','name'=>'biaya_pengiriman','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Admin Pembayaran','name'=>'admin_pembayaran','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Metode Pengiriman','name'=>'metode_pengiriman','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Payment At','name'=>'payment_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Sub Total','name'=>'sub_total','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Pay Code','name'=>'pay_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Expired Time','name'=>'expired_time','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Fee Customer','name'=>'fee_customer','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Payment Name','name'=>'payment_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Total Harga Barang','name'=>'total_harga_barang','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Diskon','name'=>'diskon','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Reference','name'=>'reference','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'City Id','name'=>'city_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Province Id','name'=>'province_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'city,id'];
        //$this->form[] = ['label'=>'Subdistrict Id','name'=>'subdistrict_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'province,id'];
        //$this->form[] = ['label'=>'Alamat Lengkap','name'=>'alamat_lengkap','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10','datatable'=>'subdistrict,id'];
        # OLD END FORM

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key 	  = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
        */
        $this->sub_module = array();


        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color 	   = Default is primary. (primary, warning, succecss, info)
        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
        |
        */
        $this->addaction = array();
        $this->addaction[] = ['label'=>'Kirim','url'=>CRUDBooster::mainpath('set-status/dikirim/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status] == 'PAID'"];


        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon 	   = Icon from fontawesome
        | @name 	   = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
        */
        $this->button_selected = array();


        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
        */
        $this->alert        = array();



        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
        */
        $this->index_button = array();



        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
        */
        $this->table_row_color = array();


        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
        */
        $this->index_statistic = array();



        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
        */
        $this->script_js = null;


        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
        */
        $this->pre_index_html = null;



        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
        */
        $this->post_index_html = null;



        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
        */
        $this->load_js = array();



        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
        */
        $this->style_css = null;



        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
        */
        $this->load_css = array();
    }


    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
    */
    public function actionButtonSelected($id_selected, $button_name)
    {
        //Your code here
    }


    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
    */
    public function hook_query_index(&$query)
    {
        //Your code here
        $query->where('status', '!=', 'create');
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
    */
    public function hook_row_index($column_index, &$column_value)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
    */
    public function hook_before_add(&$postdata)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
    */
    public function hook_after_add($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
    */
    public function hook_before_edit(&$postdata, $id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_edit($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_before_delete($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
    */
    public function hook_after_delete($id)
    {
        //Your code here
    }



    //By the way, you can still create your own method in here... :)
    public function getSetStatus($status, $id)
    {
        $transaksi = DB::table('transaksis')->find($id);

        return view('admin.update-resi', [
            'item' => $transaksi
        ]);
    }

    public function updateResi(HttpRequest $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'resi' => 'required|string',
            'metode_pengiriman' => 'required|string'
        ]);

        DB::table('transaksis')->where('id', $id)->update([
            'resi' => $request->resi,
            'metode_pengiriman' => $request->metode_pengiriman,
            'status' => 'dikirim'
        ]);

        return redirect('/admin/transaksis')->with('message', "Update resi berhasil")->with('message_type', 'success');
        // CRUDBooster::redirect($_SERVER['HTTP_REFERER'], "Resi berhasil di update", "info");
    }
}
