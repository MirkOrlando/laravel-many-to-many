@component('mail::message')
    # A New Post Has Just Been Written

    Ciao Admin,
    il post {{ $postSlug }} è stato modificato.

    @component('mail::button', ['url' => '{{ $postUrl }}'])
        Button Text
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
