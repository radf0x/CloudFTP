$('.cbp_tmlabel').on('click', '.year', function() {
	var ngo = $(this).text().substring(4).trim();
	$.post('GetData.php', {
		ngo : ngo
	}, function(data) {
		var myJSON = $.parseJSON(data);
		
		$.each(myJSON[0], function(key, value) {
			if ($('div#dialog').has('div').length > 0) {
				$('div#ngoNode_0').remove();
				var ngoDetail = value.split(/[\n]/);
				var ngoNode = document.createElement('div');
				ngoNode.setAttribute("class", "modal");
				ngoNode.setAttribute("id", 'ngoNode_0');
				document.getElementById('dialog').appendChild(ngoNode);
				var infoNode = document.createElement('section');
				infoNode.setAttribute('class', 'infoNodeClass');
				infoNode.setAttribute('id', 'infoNode');
				document.getElementById('ngoNode_0').appendChild(infoNode);
				var ngoInfo = document.createElement('b');
				ngoInfo.appendChild(document.createTextNode(ngoDetail[0]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[1]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[2]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[3]));
				ngoInfo.setAttribute('id', 'ngoInfo');
				document.getElementById('infoNode').appendChild(ngoInfo);
				var notifyBtn = document.createElement('div');
				notifyBtn.appendChild(document.createTextNode('Join volunteer!'));
				notifyBtn.setAttribute('id', 'notifyBtn');
				document.getElementById('ngoInfo').appendChild(notifyBtn);
				
			} else {
				var ngoDetail = value.split(/[\n]/);
				var ngoNode = document.createElement('div');
				ngoNode.setAttribute("class", "modal");
				ngoNode.setAttribute("id", 'ngoNode_0');
				document.getElementById('dialog').appendChild(ngoNode);
				var infoNode = document.createElement('section');
				infoNode.setAttribute('class', 'infoNodeClass');
				infoNode.setAttribute('id', 'infoNode');
				document.getElementById('ngoNode_0').appendChild(infoNode);
				var ngoInfo = document.createElement('b');
				ngoInfo.appendChild(document.createTextNode(ngoDetail[0]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[1]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[2]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[3]));
				ngoInfo.setAttribute('id', 'ngoInfo');
				document.getElementById('infoNode').appendChild(ngoInfo);
				var notifyBtn = document.createElement('div');
				notifyBtn.appendChild(document.createTextNode('Join volunteer!'));
				notifyBtn.setAttribute('id', 'notifyBtn');
				document.getElementById('ngoInfo').appendChild(notifyBtn);
			}
		});
		$('div.overlay').show();
		$('div.modal').show();
	});
});

$('div.modal').on('click', function() {
	$(this).hide(1000);
	$('div.overlay').hide();
});