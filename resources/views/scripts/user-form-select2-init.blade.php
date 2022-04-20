<script>
    $(document).ready(function(){
        $('#nationality_id').select2({
            placeholder: 'Vyberte'
        });

        $('#municipality').select2({
            placeholder: 'Vyberte',
            allowClear: true,
            minimumResultsForSearch: -1
        })

        $('#is-family-input').click(function(){
            var val = $(this).attr("value");
            $("#is-family-div").toggle();
        });

        $('#family_membership_parent_id').select2({
            placeholder: 'Vyhľadať (aspoň 3 znaky)',
            width: '100%',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: '{{ route('select2-owners-ajax') }}',
                data: function (params) {
                    return {
                        search: params.term
                    }
                }, processResults: function (data) {
                    let results = [];
                    $.each(data, (i, item) => {
                        results.push({
                            id: item.id,
                            text: item.text
                        });
                    })

                    return {
                        results
                    };
                }
            }
        })
    });
</script>