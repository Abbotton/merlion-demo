@php
    $name = $self->getName();
    $id = $self->getId();
    $label = $self->getLabel();
    $label_position = $self->getContext('label_position') ?? null;
    $options = $self->options;
@endphp

<x-merlion::form.field :$label :$id :$full :$label_position>
    <div>
        @foreach ($options as $value => $text)
            <label class="form-check">
                <input
                    class="form-check-input"
                    type="radio"x
                    name="{{ $name }}"
                    value="{{ $value }}"
                    @if($self->isChecked((string) $value)) checked @endif
                    @if($self->isDisabled((string) $value)) disabled @endif
                >
                <span class="form-check-label">{{ $text }}</span>
            </label>
        @endforeach
    </div>
    </x-merlion::form.field>
