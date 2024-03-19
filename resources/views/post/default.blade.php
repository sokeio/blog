<div class="container mt-2">
    @if ($post->name)
        <h1><a href="{{ $post->getSeoCanonicalUrl() }}" title="{{ $post->name }}">{{ $post->name }}</a></h1>
    @endif
    {!! $post->content !!}
    <div class="d-flex ms-1">
        <livewire:comment::action :model="$post" />
        <livewire:comment::action :model="$post" type="favorites" />
        <livewire:comment::view-count :model="$post" />
    </div>
    <div class="my-2 py-2 bg-white rounded border">
        <livewire:comment::rate :model="$post" />
    </div>
    <livewire:comment::comments :model="$post">
        <div class="mt-4">
            [blog::posts postId='{{ $post->id }}' title='@lang('Post Related')']
        </div>
</div>
