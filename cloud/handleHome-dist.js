$(function() {
	if ($.cookie("name") != null) {
		var username = $.cookie("name");
		var nameSection = document.createElement('h1');
		nameSection.setAttribute('id', 'nameSection');
		nameSection.appendChild(document.createTextNode('Welcome, ' + username));
		document.getElementById('loginName').appendChild(nameSection);
		
		$.post('account.php', {username : username}, function(data) {
			console.log(data);
			var myJSON = $.parseJSON(data);

			var storageStatus = document.createElement('h1');
			storageStatus.setAttribute('id', 'statusSection');
			storageStatus.appendChild(document.createTextNode('Currently used ' + myJSON[0] + ' % out of ' + myJSON[1]));
			storageStatus.appendChild(document.createElement('br'));
			document.getElementById('status').appendChild(storageStatus);
/*
			var sizeInFile = document.createElement('h1');
			sizeInFile.setAttribute('id', 'fileType');
			//sizeInFile.appendChild(document.createTextNode('(In file)'));
			sizeInFile.appendChild(document.createElement('br'));
			$.each(myJSON[2], function(key, value) {
				var type = value.split(':');
				sizeInFile.appendChild(document.createTextNode(type[1]));
				
			});
			sizeInFile.appendChild(document.createElement('br'));
			$.each(myJSON[3], function(key, value){
				sizeInFile.appendChild(document.createTextNode(value[0]));
				sizeInFile.appendChild(document.createElement('br'));
			});
			document.getElementById('status').appendChild(sizeInFile);
*/
			var sizeInStorage = document.createElement('h1');
			sizeInStorage.setAttribute('id', 'fileType');
			sizeInStorage.appendChild(document.createTextNode('Storage Percentage (In Storage)'));
			sizeInStorage.appendChild(document.createElement('br'));
			$.each(myJSON[3], function(key, value){
				sizeInStorage.appendChild(document.createTextNode(key + ': (' + value[0] + ')'));
				sizeInStorage.appendChild(document.createElement('br'));
			});
			document.getElementById('status').appendChild(sizeInStorage);
		});
	}
});

$('ul.gn-menu').on('click', '.gn-icon', function() {
	$('div#status').hide();
	if($(this).text() == 'Upload'){
		$('#pageTitle').text(fileType);
		var someText = document.createElement('p');
		someText.appendChild(document.createTextNode("someText in here"));

	} else {
	var userRole = $.cookie("name");
	var fileType = ($(this).text().substring($(this).text().length - 1) == 's') ? $(this).text().substring(0, $(this).text().length - 1) : $(this).text();
	if($(this).text() == 'Programmes') fileType = 'Program';
	$.post('account.php', {userRole : userRole, fileType : fileType}, function(data) {
		//console.log(data);
		var myJSON = $.parseJSON(data);
		
		if ($('#file').has('div').length > 0) {
			$('.file-block').remove();
			$('#pageTitle').text(fileType);
			for (var i = 0; i < myJSON.name.length; i++) {
				var fileNode = document.createElement('div');
				fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
				fileNode.setAttribute('id', 'nodeId_' + i);
				document.getElementById('file').appendChild(fileNode);

				var nodeSection = document.createElement('section');
				nodeSection.setAttribute('class', 'file-link');
				nodeSection.setAttribute('id', 'sectionId_' + i);
				document.getElementById('nodeId_' + i).appendChild(nodeSection);
				
				
				var fileLabel = document.createElement('label');
				fileLabel.setAttribute('id', 'fileLabel_' + i);
				fileLabel.setAttribute('for', 'file' + i);
				document.getElementById('sectionId_' + i).appendChild(fileLabel);
				
				var boldSection = document.createElement('p');
				boldSection.setAttribute('id', 'boldId_' + i);
				boldSection.appendChild(document.createTextNode((i + 1) + '. '));
				boldSection.appendChild(document.createTextNode('Name: ' + myJSON.name[i]));
				boldSection.appendChild(document.createTextNode('____________'));
				boldSection.appendChild(document.createTextNode(' Last Modified: ' + myJSON.time[i]));
				boldSection.appendChild(document.createTextNode('______'));
				document.getElementById('fileLabel_' + i).appendChild(boldSection);
				
				var fileSelect = document.createElement('input');
				fileSelect.setAttribute('id', 'file' + i);
				fileSelect.setAttribute('class', 'checkboxClass');
				fileSelect.setAttribute('name', 'chkbx');
				fileSelect.setAttribute('value', myJSON.name[i]);
				fileSelect.setAttribute('type', 'checkbox');
				document.getElementById('boldId_' + i).appendChild(fileSelect);
			}
		} else {
			$('#pageTitle').text(fileType);
			for (var i = 0; i < myJSON.name.length; i++) {
				var fileNode = document.createElement('div');
				fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
				fileNode.setAttribute('id', 'nodeId_' + i);
				document.getElementById('file').appendChild(fileNode);

				var nodeSection = document.createElement('section');
				nodeSection.setAttribute('class', 'file-link');
				nodeSection.setAttribute('id', 'sectionId_' + i);
				document.getElementById('nodeId_' + i).appendChild(nodeSection);
				
				var fileLabel = document.createElement('label');
				fileLabel.setAttribute('id', 'fileLabel_' + i);
				fileLabel.setAttribute('for', 'file' + i);
				document.getElementById('sectionId_' + i).appendChild(fileLabel);
				
				var boldSection = document.createElement('p');
				boldSection.setAttribute('id', 'boldId_' + i);
				boldSection.appendChild(document.createTextNode((i + 1) + '. '));
				boldSection.appendChild(document.createTextNode('Name: ' + myJSON.name[i]));
				boldSection.appendChild(document.createTextNode('____________'));
				boldSection.appendChild(document.createTextNode(' Last Modified: ' + myJSON.time[i]));
				boldSection.appendChild(document.createTextNode('______'));
				document.getElementById('fileLabel_' + i).appendChild(boldSection);
				
				var fileSelect = document.createElement('input');
				fileSelect.setAttribute('id', 'file' + i);
				fileSelect.setAttribute('class', 'checkboxClass');
				fileSelect.setAttribute('name', 'chkbx');
				fileSelect.setAttribute('value', myJSON.name[i]);
				fileSelect.setAttribute('type', 'checkbox');
				document.getElementById('boldId_' + i).appendChild(fileSelect);
			}
		}
	});
}
});

$('div#file').on('click', '.file-block', function(){
/*	
	var file = $(this).text().trim().split('_');
	var nameonly = file[0].split(':');
	var targetname = nameonly[1].trim();
	window.open('download_V2.php?f=' + targetname);
*/
	
	$(this).prop('checked', true);
	if ($(this).prop('checked') == true){ 
		$('#op1').text('Select All');
		$('#op2').text('Download Selected');
    }
	
});

$('#op1').click(function(e){
	e.preventDefault();
	if($('#op1').text() == 'Select All') {
		$('.checkboxClass').prop('checked', true);
		$('#op1').text('Disselect All');
	} else {
		$('.checkboxClass').prop('checked', false);
		$('#op1').text('Select All');
	}
	return false;
});

$('#op2').on('click', function(){
	//e.preventDefault();
	var myArray= new Array();
	for(var i = 0; i < $('input[name="chkbx"]:checked').length; i++) {
		myArray[i] = $('input[name="chkbx"]:checked')[i].value;
	}
	$.cookie("fileList", myArray);
});


