@component('mail::message')
    #Hello {{$user->name}}
    Our records shows that you changed your email! Please verify your new email using the button:
    @component('mail::button', ['url' => route('verify', $user->verification_token)])
        Verify account
    @endcomponent
    Thanks,
    {{config('app.name')}}
@endcomponent

