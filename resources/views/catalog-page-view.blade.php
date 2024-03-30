<div class="container mt-2">
    @if ($catalog->name)
        <h1><a href="{{ $catalog->getSeoCanonicalUrl() }}" title="{{ $catalog->name }}">{{ $catalog->name }}</a></h1>
    @endif
    {!! $catalog->content !!}
    <div class="mt-4">
        [blog::posts catalogId='{{ $catalog->id }}' isLoadMore='true' title='@lang('Post Related')']
    </div>
</div>
