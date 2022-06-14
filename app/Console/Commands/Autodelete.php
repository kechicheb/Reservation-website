<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\reservation;
use App\Models\Reservation_materiel;
use Carbon\Carbon;

class Autodelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservation:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Reservation after end_time';

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
          $d=Carbon::today();
        $h=Carbon::now()->format('H:i:s');
        $reservations=Reservation::all();
        foreach($reservations as $item) {

            if($d>=($item->date_reservation)){
                if(($item->creneau->end)<=$h)
                 {
                     $id = $item->id;
                     $reserv_materiel=Reservation_materiel::where('code_reservation',$id)->get();


                     foreach($reserv_materiel as $item) {
                         $item->delete();
                     }
                    $reservation =Reservation::find($id);
                    $reservation->delete();}
            }
        }
        // return 0;
    }
}