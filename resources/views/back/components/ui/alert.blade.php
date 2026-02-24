@push('scripts')
    <script>
        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session()->has($type))
                Swal.fire({
                    icon: '{{ $type }}',
                    title: '{{ ucfirst($type) }}',
                    text: @json(session($type)),
                    showConfirmButton: true,
                });
            @endif
        @endforeach
    </script>
@endpush
