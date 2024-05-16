 {!! Form::label('category_id', isset($label) ? $label : 'Category', ['class' => $labelClass ]); !!}
<select class="category-search {{ $selectClass }}" name="category_id" id="category_search">
	@if(isset($selectedCategory))
		<option selected="selected" value="{{$selectedCategory->id}}">{{$selectedCategory->treeName}}</option>
	@endif
</select>

@section('custom-js')

<script type="text/javascript">

	$("document").ready(function(){

	    $('#category_search').select2({
	       placeholder: "Pick a Category",
	       ajax: {
	        url: "/api/v1/search_categories",
	        dataType: 'json',
	        processResults: function (data) {
	            return {
	                results: $.map(data, function (item) {
	                    return {
	                        text: item.treeName,
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

@endsection
