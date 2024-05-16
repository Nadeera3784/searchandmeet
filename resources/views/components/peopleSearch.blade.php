{!! Form::label('person_id', isset($label) ? $label : 'Person', ['class' =>  "'".$labelClass."'" ]); !!}
<select class="person-search {{ $selectClass }}" name="person_id" id="person_select"></select>

@push('bottom-scripts')

    <script type="text/javascript">

        $("document").ready(function(){

            let selectedPersonID = {{ $personID }};

            $('.person-search').select2({
                placeholder: "Select a person",
                ajax: {
                    url: "/api/v1/people/search",
                    data: function (params) {
                        return {
                            q: params.term ? params.term : '', // search term
                            limit_to_agent: {{ $limitToAgent ?? 0 }}
                        };
                    },
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: `${item.name} | ${item.business.name}`,
                                    id: item.id,
                                }
                            })
                        };
                    },
                    cache: false,
                    allowClear:true
                }
            });

            $('.person-search').val(selectedPersonID).trigger('change');
        });


    </script>

@endpush
