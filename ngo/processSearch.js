$('button#nl-submit-btn').on('click', function() {
	var district = $('#location').val().trim();
	if ($.trim(district) != null) {
		$.post('GetData.php', {district : district}, function(data) {
			$.cookie('district', data);
			$(location).attr('href', 'result.html');
		});
	}
});
/*
$('input#search-submit').on('click', function(){
	var searchQuery = $('input#search').val().trim();
	if ($.trim(searchQuery) != null) {
		$.post('GetData.php', {searchQuery: searchQuery}, function(data) {
			$.cookie('searchQuery', data);
			$(location).attr('href', 'result.html');
		});
	}
});
*/