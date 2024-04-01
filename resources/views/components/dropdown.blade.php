@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'dropdown-menu-start';
            break;
        case 'top':
            $alignmentClasses = 'dropdown-menu-top';
            break;
        case 'right':
        default:
            $alignmentClasses = 'dropdown-menu-end';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
    }
@endphp

<div class="dropdown" x-data="{ open: false }" @click.outside="open = false">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open" class="dropdown-menu show {{ $alignmentClasses }}" style="display: none;">
        <div class="dropdown-menu-content rounded-3 shadow-lg {{ $width }} {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
