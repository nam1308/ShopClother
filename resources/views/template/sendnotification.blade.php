@component('mail::layout', ['title' => $title, 'img' => asset("Shop_clothes/public/storage/$logo")])
    {{-- Header --}}
    @lang('Xin Chào!')
    @slot('header')
        @component('mail::header', ['web' => 'http://localhost/Shop_clothes/public/', 'logo' => asset("storage/$logo")])
        @endcomponent
    @endslot

    {{ $messenger }}
    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset
    @lang('Cảm ơn bạn đã quan tâm đến cửa hàng của chúng tôi, rất mong có thể phục vụ bạn nhiều hơn.')
    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
