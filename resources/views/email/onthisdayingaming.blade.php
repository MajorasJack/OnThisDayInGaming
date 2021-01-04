@component('mail::message')
Vidya Gamez 4 2day from Jack

@foreach ($data as $key => $emailData)
@component('mail::panel')
{{ $key }}
@foreach ($emailData as $title => $link)
@component('mail::button', ['url' => $link, 'color' => 'success'])
{{ $title }}
@endcomponent
@endforeach

@endcomponent
@endforeach

@endcomponent
