
{{route('verify', $user->verification_token)}}
@component('mail::message')
#Hello {{$user->name}}
Thank you for joining us! Please verify your email using the button below:
    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify account
    @endcomponent
Thanks,
    {{config('app.name')}}
@endcomponent

