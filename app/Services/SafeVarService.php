<?php


namespace App\Services;


use App\Models\SafeVar;
use Illuminate\Support\Str;

class SafeVarService
{
    public function add($value = null, $destroyTime = null)
    {
        if (!$value) {
            throw new \Exception('`value` must be specified.');
        }

        if (strlen($value) > 32) {
            throw new \Exception('`value` must be contain less than 32 characters.');
        }

        while (true) {
            $uuid = Str::random();

            if (self::checkAvailableOfUuid($uuid)) {
                break;
            }
        }

        $data = [
            'uuid' => $uuid,
            'value' => $value
        ];

        if ($destroyTime) {
            $data['destroy_time'] = $destroyTime;
        }

        $newSafeVar = SafeVar::create($data);

        return $newSafeVar->uuid;
    }

    public function get($uuid = null)
    {
        if (!$uuid) {
            throw new \Exception('`uuid` must be specified.');
        }

        $var = SafeVar::available()->select(['value'])->find($uuid);

        if ($var) {
            return $var->value;
        } else {
            return null;
        }
    }

    public function destroy($uuid = null)
    {
        if (!$uuid) {
            throw new \Exception('`uuid` must be specified.');
        }

        SafeVar::destroy($uuid);
    }

    public function destroyUnused()
    {
        SafeVar::notAvailable()->delete();
    }

    private function checkAvailableOfUuid($uuid)
    {
        return SafeVar::find($uuid) === null;
    }
}
