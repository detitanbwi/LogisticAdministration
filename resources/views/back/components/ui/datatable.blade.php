@props([
    'id' => 'dataTable',
    'header' => [],
    'ajax' => '',
    'data' => [],
    'order' => [[0, 'asc']],
])

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('back/assets/vendors/css/dataTables.bs5.min.css') }}" />
@endpush

<div class="row">
    <div class="col-lg-12">
        <div class="card stretch stretch-full">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover" id="{{ $id }}">
                        <thead>
                            <tr>
                                @foreach ($header as $th)
                                    <th>{!! $th !!}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('back/assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('back/assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'none';
            $('#{{ $id }}').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ $ajax }}',
                    data: function(d) {
                        $('.dt-filter').each(function() {
                            d[$(this).attr('name')] = $(this).val();
                        });
                    }
                },
                columns: [
                    @foreach ($data as $key => $config)
                        @php
                            $name = is_string($key) ? $key : $config;
                            $isAssoc = is_array($config);
                            $searchable = $isAssoc ? $config['searchable'] ?? true : true;
                            $orderable = $isAssoc ? $config['orderable'] ?? true : true;
                            $className = $isAssoc ? $config['className'] ?? '' : '';
                            $width = $isAssoc ? $config['width'] ?? '' : '';
                        @endphp {
                            data: '{{ $name }}',
                            name: '{{ $name }}',
                            searchable: {{ $searchable ? 'true' : 'false' }},
                            orderable: {{ $orderable ? 'true' : 'false' }},
                            @if ($className)
                                className: '{{ $className }}',
                            @endif
                            @if ($width)
                                width: '{{ $width }}',
                            @endif
                        },
                    @endforeach
                ],
                order: @json($order),
                language: {
                    paginate: {
                        previous: '<i class="bi bi-arrow-left"></i>',
                        next: '<i class="bi bi-arrow-right"></i>',
                    }
                }
            });
        });
    </script>
@endpush
