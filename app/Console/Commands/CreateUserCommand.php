<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user['name'] = $this->ask('Name of new user');
        $user['email'] = $this->ask('Email of new user');
        $user['password'] = $this->secret('Password of new user');

        // validate data, since we don't have access to the global request class, we can't use form requests here
        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', 'unique:'.User::class],
            'password' => ['required', Password::defaults()]
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return -1;
        }
        $user['password'] = Hash::make($user['password']);
        $newUser = User::create($user);
        $this->info('User '.$newUser['email'].' created successfully');

        // return error message at index 0
        return 0;
    }
}
