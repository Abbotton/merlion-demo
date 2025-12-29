@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $colors = $self->colors;
    $label_position = $self->getContext('label_position') ?? null;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <div class="row g-2">
        @foreach ($colors as $color)
            <div class="col-auto">
                <label class="form-colorinput @if($self->isLightColor($color)) form-colorinput-light @endif">
                    <input
                        type="checkbox"
                        name="{{ $name }}[]"
                        value="{{ $color }}"
                        class="form-colorinput-input"
                        @if($self->isChecked($color)) checked @endif
                    >
                    <span class="form-colorinput-color bg-{{ $color }}"></span>
                </label>
            </div>
        @endforeach
    </div>
</x-merlion::form.field>
