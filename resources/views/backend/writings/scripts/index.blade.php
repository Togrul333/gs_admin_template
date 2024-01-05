<script>
    let table = $('#datatable').DataTable(
        {
            oLanguage:
                {
                    sProcessing: '{{ trans("backend.datatables.loading") }}',
                    sSearch:     '{{ trans("backend.datatables.search") }}'
                },
            ajax:
                {
                    url:  '{{ route("backend.writings.index") }}',
                    data: function (d) {
                    },
                    type: 'GET'
                },
            serverSide: false,
            processing: true,
            searching: false,
            pageLength: 20,

            aaSorting : [[0, false]],
            columns:
                [
                    {data: 'id',             name: 'id'},
                    {data: 'title',          name: 'title'},
                    // {data: 'content',           name: 'content'},
                    {data: 'actions',        name: 'actions'}
                ],
            columnDefs:
                [
                    {
                        'orderable': false
                    }
                ],
            language:
                {
                    'emptyTable': '{{ trans("backend.datatables.empty") }}'
                }
        });

    $('.filter-input').keypress(function () {
        table.search($(this).val())
            .draw();
    });


    $('.filter-select').on('change',function(){
        table.search($(this).val())
            .draw();
    });

    $(document).ready(function() {
        let select2 = $('.select2');

        select2.select2({
            theme: 'bootstrap4',
            minimumResultsForSearch: 5,
            placeholder: 'Axtardığınız'
        });

    });

    $(document).on('click', '.btn-delete', function(e)
    {
        e.preventDefault();

        {!! confirm() !!}.then((result) =>
        {
            if (result.isConfirmed)
            {
                var url  = $(this).prop('href');
                var type = 'POST';
                var data = {_method: 'DELETE', _token: '{{ csrf_token() }}'};

                $.ajax(
                    {
                        url:  url,
                        type: type,
                        data: data,
                        success: function (result)
                        {
                            if (result.status == 1)
                            {
                                {!! notify('success', trans('backend.messages.success.delete')) !!}
                                table.row($(this).parents('tr')).remove().draw();
                            }

                            else
                            {
                                {!! notify('error', trans('backend.messages.error.delete')) !!}
                            }
                        }
                    });
            }
        });
    });
</script>
