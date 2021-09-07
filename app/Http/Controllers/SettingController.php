<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use App\User;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function settingIndex()
    {
        $setting = GeneralSetting::first();

        return view('settings.app-setting', compact('setting'));
    }

    public function appSettingUpdate(Request $request, GeneralSetting $setting)
    {
        $data = $request->all();
        $update = $setting->update($data);

        if ($update) {
            $notify = updateNotify('App setting');
        }else{
            $notify = errorNotify('App setting');
        }

        return redirect()->back()->with($notify);

    }

    public function emailSetting()
    {
        $setting = GeneralSetting::first();

        return view('settings.emailconfig',compact('setting'));
    }

    public function emailSettingUpdate(Request $request, GeneralSetting $setting)
    {
        $this->validate($request, [
            'from_name' => 'required',
            'from_email' => 'required',
            'mail_driver' => 'required',
        ]);

        $data = $request->except(['test_mail']);
        $update = $setting->update($data);

        if ($update) {
            //send test email
            if($request->test_mail){

                $res = $this->testMail($request);
                if ($res === '') {
                    $notify = mailNotify('Email setting updated & Test Email Sent');
                }else{
                    $notify = mailWarning('Email setting updated & Test Email send fail!: ' . $res);
                }
                return redirect()->back()->with($notify);
            }else{
                $notify = updateNotify('Email setting');
                return redirect()->back()->with($notify);
            }

        }else{
            $notify = errorNotify('Email setting');
            return redirect()->back()->with($notify);
        }
    }

    public function testMail($email)
    {
//        return Mail::to(User::find(4))->send(new TestEmail());

        $app = GeneralSetting::first();
        $subject = 'Test email';
        $emailHeader = '<html>
                           <div style="width: 35%; color: #333333; font-family: Helvetica; margin:auto; font-size: 125%; padding-bottom: 10px;">
                               <div style="text-align:center; padding-top: 10px; padding-bottom: 10px;">
                                   <h1>'.$app->app_name.'</h1>
                               </div>
                               <div style="padding: 35px;padding-left:20px; border-bottom: 1px solid #cccccc; border-top: 1px solid #cccccc;">';
        $emailFooter = '        </div>
                           </div>
                       </html>';

        $mailText = $emailHeader.'This is a test email. Your email config working'.$emailFooter;
        $mailer = new AppMailer;

        // try {
            $settingSendEmail = [
                'mailText' => $mailText,
                'user' => $email,
                'subject' => $subject,
                'status' => 'test',
            ];
            
            return $mailer->sendEmail($settingSendEmail);
        //     return true;
        // } catch (\Throwable $th) {
        //     return false;
        // }

    }
}
