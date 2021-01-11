<?php


namespace App\Services\Authentication;


use App\Models\Patient;
use Illuminate\Support\Collection;

class RegistrationService
{
    public function reg(string $mode, Collection $options)
    {
        switch ($mode) {
            case 'administrator':
                self::createNewAdministrator($options);
                break;
            case 'doctor':
                self::createNewDoctor($options);
                break;
            case 'patient':
                self::createNewPatient($options);
                break;
            default:
                throw new \Exception('Unknown type of user. Available values: administrator, doctor, patient.');

        }
    }

    private function createNewAdministrator($options)
    {
        throw new \Exception('Method createNewAdministrator() in RegistrationService is not implemented.');
    }

    private function createNewDoctor($options)
    {
        throw new \Exception('Method createNewDoctor() in RegistrationService is not implemented.');
    }

    private function createNewPatient($options)
    {
        if (Patient::byPhone($options->get('phone_code') . $options->get('phone'))->get()->count() !== 0) {
            throw new \Exception('Этот номер уже зарегистрирован в системе.');
        }

        $data = [];

        foreach ($options->all() as $key => $item) {
            if ($item !== '') {
                $data[$key] = $item;
            }
        }

        Patient::create($data);
    }
}
