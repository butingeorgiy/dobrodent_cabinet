<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\UncategorizedApiException;
use App\Facades\SafeVar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SmsCodeController extends Controller
{
    public function send(Request $request)
    {
        require app_path('/Services/smsCenter.php');

        $code = rand(0, 9) . rand(0, 9) . rand(0, 9). rand(0, 9);

        $phoneUuid = SafeVar::add($request->post('phone'));
        $codeUuid = SafeVar::add($code);

        $codeSendStatus = send_sms(
            $request->post('phone'),
            'Код для входа в систему: ' . $code
        );

        if ($codeSendStatus[1] < 0) {
            return response()->json([
                'error' => true,
                'message' => 'Не удалось отправить код-подтверждения! Повторите попытку снова!'
            ]);
        }

        return response()->json([
            'code_uuid' => encrypt($codeUuid, false),
            'phone_uuid' => encrypt($phoneUuid, false)
        ]);
    }

    public function check(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'bail|required'
            ],
            [
                'code.required' => 'Необходимо указать код!'
            ]
        );

        if ($validator->fails()) {
            throw new UncategorizedApiException($validator->errors()->first());
        }

        $code = SafeVar::get($request->cookie('code'));

        if (!$code) {
            throw new UncategorizedApiException('Код не определен!');
        }

        return response()->json([
            'confirmed' => $code !== $request->post('code')
        ]);
    }
}
