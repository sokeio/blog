<div>
    @if ($title)
        <h3>{{ $title }}</h3>
    @endif
    <div class="row">
        @foreach ($dataItems as $post)
            <div class="{{ $classItem }} mb-4">
                <livewire:blog::post-item wire:key="post-{{ $post->id }}" :post="$post" />
            </div>
        @endforeach
    </div>
</div>
