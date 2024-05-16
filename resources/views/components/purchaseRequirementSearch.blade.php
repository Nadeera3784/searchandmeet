 {!! Form::label('purchase_requirement_id', 'Purchase requirement', ['class' =>  "'".$labelClass."'" ]); !!}
 <select class="pr-search {{ $selectClass }}" name="purchase_requirement_id" id="pr_select"></select>

@push('bottom-scripts')

<script type="text/javascript">

	$("document").ready(function(){

		let selectedPrID = {{ $prID }};

	    $('.pr-search').select2({
	       placeholder: "Pick a purchase requirement",
	       ajax: {
				url: "/api/v1/purchase_requirements",
				dataType: 'json',
				data: function (params) {
				   return {
					   q: params.term ? params.term : '', // search term
					   limit_to_agent: {{ $limitToAgent ?? 0 }}
				   };
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								text: item.name + item.person,
								id: item.id
							}
						})
					};
				},
	        cache: false,
	        allowClear:true
	      }
	    });
	 });


</script>

@endpush
