@use(Betta\Terms\Enums\Source)

@if($source === Source::Pdf)
    <embed src="{{ $url }}" class="w-full rounded" height="500" type="application/pdf">
@endif

@if($source === Source::Image)
    <img alt="{{ $name }}" src="{{ $url }}" class="w-full rounded"/>
@endif

@if($source === Source::Iframe)
    <iframe src="{{ $url }}" title="{{ $name }}" class="w-full rounded" height="500"></iframe>
@endif
