@component('mail::message')

Mabini Health Center

Hello {{ $user->name }},

@component('mail::button',['url' => url('reset/'.$user->remember_token)])
  Reset Your Password
@endcomponent

<p>In case you have any issues recovering your password, please contact us.</p>

Thanks,<br>
{{ config('app.name') }}

@endcomponent