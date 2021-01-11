<?php


namespace App\Services\Authentication;


use App\Exceptions\Api\AuthorizationException;
use App\Facades\SafeVar;
use App\Models\Administrator;
use App\Models\AuthTokens\AdministratorToken;
use App\Models\AuthTokens\DoctorToken;
use App\Models\AuthTokens\PatientToken;
use App\Models\Doctor;
use App\Models\Patient;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthorizationService
{
    public function auth(string $mode, Collection $options, string $authType = 'password', bool $needToSave = false)
    {
        switch ($mode) {
            case 'administrator':
                return self::authorizeAdministrator($options, $needToSave);
            case 'doctor':
                return self::authorizeDoctor($options, $needToSave);
            case 'patient':
                return self::authorizePatient($options, $authType, $needToSave);
            default:
                throw new \Exception('Unknown type of user. Available values: administrator, doctor, patient.');
        }
    }

    private function authorizeAdministrator($options, $needToSave)
    {
        if (!$options->get('phone')) throw new AuthorizationException('Необходимо указать телефон');
        if (!$options->get('password')) throw new AuthorizationException('Необходимо указать пароль');

        $administrator = Administrator::where('login', $options->get('phone'))
            ->where('password', hash('sha256', $options->get('password')))
            ->get()->first();

        if (!$administrator) throw new AuthorizationException('Введенные данные неверные');

        return AdministratorToken::add($administrator, $needToSave);
    }

    private function authorizeDoctor($options, $needToSave)
    {
        if (!$options->get('login')) throw new AuthorizationException('Необходимо указать логин');
        if (!$options->get('password')) throw new AuthorizationException('Необходимо указать пароль');

        $doctor = Doctor::where('login', $options->get('login'))
            ->where('password', hash('sha256', $options->get('password')))
            ->get()->first();

        if (!$doctor) throw new AuthorizationException('Введенные данные неверные');

        return DoctorToken::add($doctor, $needToSave);
    }

    private function authorizePatient($options, $authType, $needToSave)
    {
        if ($authType === 'password') {
            if (!$options->get('phone')) throw new AuthorizationException('Необходимо указать телефон');
            if (!$options->get('password')) throw new AuthorizationException('Необходимо указать пароль');

            $patient = Patient::where(DB::raw('CONCAT(`phone_code`, `phone`)'), $options->get('phone'))
                ->where('password', hash('sha256', $options->get('password')))
                ->get()->first();

            if (!$patient) throw new AuthorizationException('Введенные данные неверные');

            return PatientToken::add($patient, $needToSave);
        } else if ($authType === 'code') {
            $phoneUuid = request()->cookie('phone');
            $codeUuid = request()->cookie('code');
            $codeFromUser = $options->get('code');

            if (!$phoneUuid) { throw new AuthorizationException('Не удалось распознать UUID номера телефона'); }
            if (!$codeUuid) { throw new AuthorizationException('Не удалось распознать UUID секретного кода'); }
            if (!$codeFromUser) { throw new AuthorizationException('Необходимо указать секретный код'); }

            $patientPhone = SafeVar::get($phoneUuid);
            $patientSecureCode = SafeVar::get($codeUuid);

            if ($codeFromUser !== $patientSecureCode) { throw new AuthorizationException('Код неверный'); }

            $patient = Patient::byPhone($patientPhone)->get()->first();

            if (!$patient) { throw new AuthorizationException('Пользователь не найден'); }

            return PatientToken::add($patient, $needToSave);
        } else {
            throw new Exception('Unknown type of authorize for patient.');
        }
    }

    public function check()
    {
        $request = request();

        if (!$request->cookie('id') or !$request->cookie('token') or !$request->cookie('entityName')) return false;

        $id = decrypt($request->cookie('id'));
        $token = decrypt($request->cookie('token'));
        $entityName = decrypt($request->cookie('entityName'));

        if (class_exists($entityName)) {
            $user = $entityName::find($id);

            if (!$user) return false;

            $availableUserTokens = $user->tokens()
                ->where(
                    DB::raw('CURRENT_TIMESTAMP() - `created_at`'),
                    '<',
                    DB::raw('`time_valid`')
                )->get();

            foreach ($availableUserTokens as $dbToken) {
                $tokenFromDb = hash('sha256', Str::limit($user->password, 10) . $_SERVER['HTTP_USER_AGENT'] . $dbToken->token);
                if ($tokenFromDb === $token) return true;
            }
        } else {
            throw new \Exception('Token class is not exist.');
        }

        return false;
    }

    public function user()
    {
        $request = request();

        if (!$request->cookie('id') or !$request->cookie('token') or !$request->cookie('entityName')) return null;

        $id = decrypt($request->cookie('id'));
        $entityName = decrypt($request->cookie('entityName'));

        if (class_exists($entityName)) {
            return $entityName::find($id);
        }

        return null;
    }
}
