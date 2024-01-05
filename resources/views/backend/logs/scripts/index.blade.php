<script>
    let lang = '{{ config('app.locale') }}',
        pageLength = {{ isset($pageLength) ? json_encode($pageLength) : 10 }};

    lang === 'az'
        ? langUrl = '{{ asset('/backend/js/datatables/langs/az_az.json') }}'
        : langUrl = '';
    var table = $('#datatable').DataTable(
        {
            oLanguage:
                {
                    url: langUrl,
                },
            ajax:
                {
                    url: '{{ route("backend.logs.index") }}',
                    type: 'GET'
                },
            serverSide: true,
            processing: true,
            "pageLength":pageLength,
            "lengthMenu": [10, 50, 100, 150, 200],

            columns:
                [
                    {data: 'id', name: 'id'},
                    {data: 'log_name', name: 'log_name'},
                    {data: 'description', name: 'description'},
                    {data: 'subject_type', name: 'subject_type'},
                    {data: 'subject_id', name: 'subject_id'},
                    {data: 'causer_id', name: 'causer_id'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false},
                    {data: 'properties', name: 'properties'},

                ],
            language:
                {
                    'emptyTable': '{{ trans("backend.datatables.empty") }}'
                },
            responsive: {
                details: {
                    type: 'column'
                }
            },
            columnDefs: [ {
                className: 'dtr-control',
                orderable: false,
                targets:   0
            } ],
            order: [ 1, 'asc' ],
        });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();

        {!! confirm() !!}.then((result) => {
            if (result.isConfirmed) {
                var url = $(this).prop('href');
                var type = 'POST';
                var data = {_method: 'DELETE', _token: '{{ csrf_token() }}'};

                $.ajax(
                    {
                        url: url,
                        type: type,
                        data: data,
                        success: function (result) {
                            if (result.status == 2) {
                                {!! notify('warning', trans('backend.messages.warning.role')) !!}
                            } else if (result.status == 1) {
                                {!! notify('success', trans('backend.messages.success.delete')) !!}
                                table.row($(this).parents('tr')).remove().draw();
                            } else {
                                {!! notify('error', trans('backend.messages.error.delete')) !!}
                            }
                        }
                    });
            }
        });
    });
</script>
