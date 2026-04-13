@if(session()->hasAny(['success', 'error', 'info', 'warning']))
    <div class="flash-wrap" id="flash-wrap">
        @foreach(['success', 'error', 'info', 'warning'] as $type)
            @if(session($type))
                <div class="flash flash-{{ $type }}" role="alert">
                    <span>{{ session($type) }}</span>
                </div>
            @endif
        @endforeach
    </div>
@endif
