<div class="row">
    @foreach ($dataItems as $post)
        <div class="{{ $classItem }}">
            <livewire:blog::post-item wire:key="post-{{ $post->id }}" :post="$post" />
        </div>
    @endforeach
</div>
