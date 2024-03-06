<div class="row">
    @foreach ($dataItems as $post)
        <div class="{{ $class_item }}">
            <livewire:blog::post-item wire:key="post-{{ $post->id }}" :post="$post" />
        </div>
    @endforeach
</div>
