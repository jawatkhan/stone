@lang('general.to-verify-email') <a href="{{route('sendEmailDone',[ 'email' => $user->email, 'verifyToken' => $user->verifyToken ]) }}">@lang('general.click-here')</a><br>