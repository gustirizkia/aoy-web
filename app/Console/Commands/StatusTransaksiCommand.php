<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StatusTransaksiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaksi:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merubah Status Transaksi';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        $data = DB::table('transaksis')->get();
        foreach($data as $item){

            if($item->status === 'UNPAID'){
                if($item->expired_time < $now){
                    DB::table('transaksis')->where('id', $item->id)->update([
                        'status' => 'expired'
                    ]);
                }
            }

            if($item->status === 'penilaian'){
                $dateP = Carbon::parse($item->updated_at)->addDay(3);
                if($now > $dateP){
                    DB::table('transaksis')->where('id', $item->id)->update([
                        'status' => 'selesai'
                    ]);
                }
            }

            if($item->status === 'create'){
                $date = Carbon::parse($item->created_at)->addHour(4);
                if($now > $date){
                    DB::table('transaksis')->where('id', $item->id)->delete();
                }
            }
        }

        $this->info('command ubah status transaksi successfully');

    }
}
