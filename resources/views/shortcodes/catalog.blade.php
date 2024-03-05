<div class="row">
    @for ($i = 0; $i < 10; $i++)
        <div class="col-12 col-md-4 col-lg-3 mb-4">
            <livewire:blog::post-item wire:key="post-{{ $i }}" />
        </div>
    @endfor
</div>
