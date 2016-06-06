{{ Asset::queue('typeahead', 'sanatorium/typehead::typeahead/typeahead.bundle.js', 'jquery') }}
{{ Asset::queue('handlebars', 'sanatorium/typehead::handlebars/handlebars-latest.js', 'jquery') }}


@section('styles')
@parent
<style type="text/css">
.typeahead,
.tt-query,
.tt-hint {
  outline: none;
}

.typeahead {
}

.typeahead:focus {
}

.tt-query {
}

.tt-hint {
  color: #999;
}

.tt-menu {
  left: 0;
  right: 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
}

.tt-menu .row {
	margin-left: 0;
	margin-right: 0;
	display: table;
	width: 100%;
	table-layout: fixed;
}

.tt-menu .image {
	width: 60px;
	display: table-cell;
	vertical-align: middle;
}

.tt-menu .content {
	display: table-cell;
	vertical-align: middle;
	text-align: left;
	width: 100%;
}

.tt-suggestion {
  padding: 3px 0px;
}

.tt-suggestion:hover {
  cursor: pointer;
  background-color: #f2f2f2;
}

.tt-suggestion.tt-cursor {

}

.tt-suggestion p {
  margin: 0;
}

.twitter-typeahead .empty-message {
	padding: 10px 20px;
	text-align: left;
}
.input-group .twitter-typeahead {
	width: 100%;
}
.input-group .twitter-typeahead {
	display: table-cell!important;
}

.navbar-form .input-group .twitter-typeahead>.form-control, .navbar-form .input-group .twitter-typeahead>input {
	width: 100%;
}
</style>
@stop

@section('scripts')
@parent
<script type="text/javascript">
var suggestedProducts = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '{{ route('sanatorium.typehead.products') }}?reworked=1',
	remote: {
		url: '{{ route('sanatorium.typehead.products.live') }}?{{ trans('sanatorium/shop::general.search.input') }}=%QUERY',
		wildcard: '%QUERY'
	}
});

$(function(){
	$('.product-search').typeahead(null, {
		name: 'best-pictures',
		display: 'title',
		source: suggestedProducts,
		templates: {
			empty: [
			'<div class="empty-message">',
			'{{ trans('sanatorium/typehead::messages.no_results') }}',
			'</div>'
			].join('\n'),
			pending: [
				'<div class="empty-message">',
				'{{ trans('sanatorium/typehead::messages.pending') }}',
				'</div>'
			].join('\n'),
			suggestion: Handlebars.compile('@include('sanatorium/typehead::hooks/partials/typehead')')
		}
	}).bind('typeahead:selected', function (obj, data) {
    	window.location.href = data.url;
    });
});
</script>
@stop