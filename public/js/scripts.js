function replyToComment(id)
{
    document.getElementById('parent_id').value = id;
    window.location.hash = 'parent_id';
}

function submitSearch()
{
    var form = document.getElementById('searchform');
    form.submit();
}

$(document).ready(function() {
	
	$("#menu ul li a").hover(
		function() {
			$(this).animate({ backgroundColor: '#434b57' }, 400)
		},
		function() {
			if($(this).hasClass("selected")) {
				$(this).animate({ backgroundColor: '#333333' }, 400)
			} else {
				$(this).animate({ backgroundColor: '#383d44' }, 400)
			}	
		}
	);
    	
});