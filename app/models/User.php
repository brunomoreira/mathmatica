<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use App\Classes\Session;
use App\Classes\Helpers;
use App\Classes\Mail;
use Valitron\Validator;
use Carbon\Carbon;

class User extends Eloquent
{
    protected $table = 'users';
    protected $fillable = ['email', 'username', 'password', 'activationCode', 'avatar_id'];
    protected $hidden = ['password'];

    public function register($data)
    {
        $sanitizedData = Helpers::sanitize($data);
        
        // Validate Data Before Hitting the DB
        $rules = [
            'required' => [
                ['email'], ['username'], ['password'], ['re_password'], ['avatar']
            ],
            'email' => 'email',
            'integer' => 'avatar',
        ];

        $validator = new Validator([
            'email' => $sanitizedData['email'],
            'username' => $sanitizedData['username'],
            'password' => $sanitizedData['password'],
            're_password' => $sanitizedData['re_password'],
            'avatar' => $sanitizedData['avatar']
        ]);

        $validator->rules($rules);
        $validator->rule('equals', 'password', 're_password');
        $validator->rule('in', [1,2,3,4,5,6,7,8,9,10], 'avatar');

        if(!$validator->validate()) {
            return [
                'status' => 403,
                'error' => Helpers::error('Formulário mal preenchido!')
            ];
        }

        // Check if user has not activated his account yet
        $user = $this->where('email', $sanitizedData['email'])->get()->first();
        
        if($user && $user->active == 0) {
            return [
                "status" => 403,
                "error" => Helpers::error('Já se encontra registado! Active a sua conta.')
            ];
        }
    
        // Check if user already exists
        if($user) {
            return [
                "status" => 403,
                "error" => Helpers::error('Já se encontra registado!')
            ];
        }

        // If everything is OK - Create User and Send Activation Email
        $password = Helpers::hash($sanitizedData['password']);
        $activationCode = md5(microtime());

        $this->email = $sanitizedData['email'];
        $this->username = $sanitizedData['username'];
        $this->password = $password;
        $this->activationCode = $activationCode;
        $this->avatar_id = $sanitizedData['avatar'];

        $mail = new Mail;

        // Set Mode to 'production' as the first argument when on production
        if(!$this->save() || !$mail->activate('development', $this->email, $this->username, $activationCode)) {
            return [
                'status' => 500,
                'error' => Helpers::error()
            ];
        }

        return [
            'status' => 200,
            'message' => 'Registo Concluído! Verifique o seu email.'
        ];

    }

    public static function activate($email, $activationCode)
    {
        $email = Helpers::sanitize($email);
        $activationCode = Helpers::sanitize($activationCode);

        // Find user
        $user = self::where('email', $email)->where('activationCode', $activationCode)->get()->first();

        if($user) {

             // Activate User
            $user->active = true;

            if($user->save()) {
                return true;
            }

        }

        return false;

    }

    public function login($data)
    {
        $sanitizedData = Helpers::sanitize($data);
        $user = $this->join('avatars', 'users.avatar_id', '=', 'avatars.id')->where('email', $sanitizedData['email'])->get()->first();

        // Validate Data Before Hitting the DB
        $rules = [
            'required' => [
                ['email'], ['password']
            ],
            'email' => 'email'
        ];

        $validator = new Validator([
            'email' => $sanitizedData['email'],
            'password' => $sanitizedData['password']
        ]);

        $validator->rules($rules);

        if(!$validator->validate()) {
            return [
                'status' => 403,
                'error' => Helpers::error('Formulário mal preenchido!')
            ];
        }

        // Check if user exists
        if(!$user) {
            return [
                'status' => 403,
                'error' => Helpers::error('Este utilizador não existe!')
            ];
        }

        // Check if user is active
        if($user && !$user->active) {
            return [
                'status' => 403,
                'error' => Helpers::error('Active a sua conta! Verifique o seu email.')
            ];
        }

        // Check if user password is right
        if($user && !Helpers::check($sanitizedData['password'], $user->password)) {
            return [
                'status' => 403,
                'error' => Helpers::error('Credenciais Erradas!')
            ];
        }

        // Everything is OK - Log in the user
        Session::set('user', $user);

        return [
            'status' => 200,
            'user' => $user
        ];
    }

    // Recover Password
    public function recover_password($data)
    {
        $email = Helpers::sanitize($data);

        // Find User
        $user = $this->where('email', $email)->get()->first();

        if(!$user) {
            return [
                'status' => 403,
                'message' => 'Utilizador Não Existe!'
            ];
        }

        // Is user active?
        if(!$user->active) {
            return [
                'status' => 403,
                'message' => 'Active primeiro a sua conta! Verifique o seu email.'
            ];
        }

        // Check the last attempt to reset the password
        // Any new requests from this user is blocked for 3h after a request 
        $lastAttempt = Carbon::parse($user->last_forgot_password_attempt);
        $nextAvailableAttempt = 180 - (Carbon::now('Europe/Lisbon')->diffInMinutes($lastAttempt));

        if($user->last_forgot_password_attempt != NULL && Carbon::now('Europe/Lisbon')->diffInHours($lastAttempt) < 3) {
            return [
                'status' => 403,
                'message' => 'Disponível daqui a ' . $nextAvailableAttempt . ' minutos.'
            ];
        }

        // Mail user with a new temporary password
        $temporaryPassword = bin2hex(openssl_random_pseudo_bytes(8));
        $user->password = Helpers::hash($temporaryPassword);

        // Update the last_forgot_password_attempt
        $user->last_forgot_password_attempt = Carbon::now();

        $mail = new Mail;

        if(!$user->save() || !$mail->reset_password($user->email, $user->username, $temporaryPassword)) {
            return [
                'status' => 500,
                'message' => Helpers::error()
            ];
        }

        return [
            'status' => 200,
            'message' => 'Palavra-Passe foi alterada! Verifique o seu email.'
        ];
    }

    public function resend_activation($data)
    {
        $data = Helpers::sanitize($data);

        // Get user
        $user = $this->where('email', $data)->get()->first();

        if(!$user) {
            return [
                'status' => 403,
                'message' => 'Utilizador Não Existe!'
            ];
        }

        // Check if user has activated his/her account already
        if($user->active == 1) {
            return [
                'status' => 403,
                'message' => 'A sua conta já se encontra activa!'
            ];
        }

        // Check the last attempt to reset the password
        // Any new requests from this user is blocked for 3h after a request 
        $lastAttempt = Carbon::parse($user->last_resend_activation_attempt);
        $nextAvailableAttempt = 180 - (Carbon::now('Europe/Lisbon')->diffInMinutes($lastAttempt));

        if($user->last_resend_activation_attempt != NULL && Carbon::now('Europe/Lisbon')->diffInHours($lastAttempt) < 3) {
            return [
                'status' => 403,
                'message' => 'Disponível daqui a ' . $nextAvailableAttempt . ' minutos.'
            ];
        }

        // If everything is OK - Email the user a new activation email
        $mail = new Mail;
        $activationCode = md5(microtime());

        $user->activationCode = $activationCode;

        // Update the last_forgot_password_attempt
        $user->last_resend_activation_attempt = Carbon::now();

        if(!$user->save() || !$mail->resend_activation('development', $user->email, $user->username, $activationCode)) {
            return [
                'status' => 500,
                'message' => Helpers::error()
            ];
        }

        return [
            'status' => 200,
            'message' => 'Sucesso! Verifique o seu email.'
        ];
    }

    public function contact($data, $container)
    {
        $data = Helpers::sanitize($data);
        $ip = Helpers::get_ip();

        // Check if the ip address is allowed to use the contact form
        $contacted = $container->db::table('contacts')->where('ip', $ip)->first();

        if($contacted != NULL) {
            
            $lastAttempt = Carbon::parse($contacted->last_contact);
            $nextAvailableAttempt = 180 - (Carbon::now('Europe/Lisbon')->diffInMinutes($lastAttempt));

            if(Carbon::now('Europe/Lisbon')->diffInHours($lastAttempt) < 3) {
                return [
                    'status' => 403,
                    'message' => 'Disponível daqui a ' . $nextAvailableAttempt . ' minutos.'
                ];
            }
        }

        // If Everything is OK - Let the email pass through
        $mail = new Mail;

        if(!$mail->contact($data['email'], $data['name'], $data['subject'], $data['text'])) {
            return [
                'status' => 500,
                'message' => Helpers::error()
            ];
        }

        // Delete the previous record then add a new one
        $container->db->table('contacts')->where('ip', $ip)->delete();

        $container->db->table('contacts')->insert(
            [
                'ip' => $ip,
                'last_contact' => Carbon::now()
            ]
        );

        return [
            'status' => 200,
            'message' => 'Mensagem Enviada!'
        ];
    }

    public function edit($data)
    {
        $data = Helpers::sanitize($data);
        
        $field = $data['field'];
        $value = $data['value'];

        $session = Session::get('user');

        // Check if user is logged in
        $user = $this->where('id', $session->id)->orWhere('email', $session->email)->get()->first();

        if($user) {

            switch($field) {
                case 'avatar':
                    $user->avatar_id = $value;
                    break;
                case 'email':
                    $user->email = $value;
                    break;
                case 'username':
                    $user->username = $value;
                    break;
                case 'password':
                    $user->password = Helpers::hash($value);
                    break;
                default:
                    return [
                        'status' => 403,
                        'message' => Helpers::error()
                    ];
            }

            if($user->save()) {

                // Reset user session with the new data
                $user = $this->join('avatars', 'users.avatar_id', '=', 'avatars.id')->where('users.id', $session->id)->orWhere('users.email', $session->email)->get()->first();

                Session::set('user', $user);

                // Send user data to update the state
                return [
                    'status' => 200,
                    'message' => 'Perfil Editado!',
                    'user' => $user
                ];

            }
        
        }

        return [
            'status' => 403,
            'message' => $session->id
        ];
    }

}