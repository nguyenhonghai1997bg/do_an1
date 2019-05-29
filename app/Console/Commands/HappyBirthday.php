<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class HappyBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'happy:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Happy birthay users';

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
     * @return mixed
     */
    public function handle()
    {
        $users = \App\User::whereMonth('birth_day', date('m'))->whereDay('birth_day', date('d'))->get();

        foreach($users as $user) {
            Mail::send('emails.happybirthday', ['user'=> $user], function($message) use ($user)
            {
                $message->to($user->email)
                    ->subject('Masha life Chúc mừng sinh nhật!');
            }); 
        }
    }
}
