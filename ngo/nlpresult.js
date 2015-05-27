$(document).ready(function(){
	if($.cookie('district') != null) {
		var myJSON = $.parseJSON($.cookie('district'));
		
		if($('div#content').has('div').length > 0) {
			$('div#eachContent').remove();
			$.each(myJSON, function(key, value){
				var ngoDetail = value.split(/[\n]/);
				var eachContent = document.createElement('div');
				eachContent.setAttribute('id', 'eachContent');
				eachContent.setAttribute('class', 'ngoName-block grid-100 mobile-grid-100 micro-grid-100');
				document.getElementById('content').appendChild(eachContent);
				var ngoTitle = document.createElement('div');
				ngoTitle.setAttribute('id', 'ngoTitle_' + key);
				ngoTitle.setAttribute('class', 'titleClass ngoTitle');
				ngoTitle.appendChild(document.createTextNode(ngoDetail[0]));
				document.getElementById('eachContent').appendChild(ngoTitle);
				var ngoDesc = document.createElement('div');
				ngoDesc.setAttribute('id', 'ngoDesc_' + key);
				ngoDesc.setAttribute('class', 'descClass_');
				ngoDesc.appendChild(document.createTextNode(ngoDetail[1]));
				document.getElementById('eachContent').appendChild(ngoDesc);
				var ngoContact = document.createElement('div');
				ngoContact.setAttribute('id', 'ngoContent_' + key);
				ngoContact.setAttribute('class', 'contactClass');
				ngoContact.appendChild(document.createTextNode(ngoDetail[2]));
				document.getElementById('eachContent').appendChild(ngoContact);
				var ngoTel = document.createElement('div');
				ngoTel.setAttribute('id', 'ngoTel_' + key);
				ngoTel.setAttribute('class', 'telClass');
				ngoTel.appendChild(document.createTextNode(ngoDetail[3]));
				document.getElementById('eachContent').appendChild(ngoTel);
				var ngoMail = document.createElement('div');
				ngoMail.setAttribute('id', 'ngoMail_' + key);
				ngoMail.setAttribute('class', 'mailClass ngoLink');
				ngoMail.appendChild(document.createTextNode(ngoDetail[4]));
				document.getElementById('eachContent').appendChild(ngoMail);
				var ngoWeb = document.createElement('div');
				ngoWeb.setAttribute('id', 'ngoWeb_' + key);
				ngoWeb.setAttribute('class', 'webClass ngoLink');
				ngoWeb.appendChild(document.createTextNode(ngoDetail[5]));
				ngoWeb.appendChild(document.createElement('hr'));
				document.getElementById('eachContent').appendChild(ngoWeb);
			});
		}
	}
});