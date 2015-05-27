var osseparator = (navigator.appVersion.indexOf('Mac') != -1)?'/':'\\';
$(function() {
	if ($.cookie("name") != null) {
		var username = $.cookie("name");
		var nameSection = document.createElement('h1');
		nameSection.setAttribute('id', 'nameSection');
		nameSection.appendChild(document.createTextNode('Welcome, ' + username));
		document.getElementById('loginName').appendChild(nameSection);
		
		$.post('account.php', {username : username}, function(data) {
			console.log('Init: '+data);
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
	$('div#share').hide();
	if($(this).text() == 'Shared With Me'){
		$('div#status').hide();
		$('div#share').show();
		$('.file-block').remove();
		var sharedUserRole = $.cookie("name");
		var fileType = ($(this).text().substring($(this).text().length - 1) == 's') ? $(this).text().substring(0, $(this).text().length - 1) : $(this).text();
		$('#pageTitle').text(fileType);
		$.post('account.php', {sharedUserRole : sharedUserRole}, function(data){
			var myJSON = $.parseJSON(data);
			var filteredFileName = Array();
			var filteredUserName = Array();
			var trueFilePath = Array();
			console.log(myJSON);
			for (var i = 0; i < myJSON.path.length; i++) {
				trueFilePath[i] = myJSON.path[i];
				filteredFileName[i] = myJSON.path[i].substring(myJSON.path[i].lastIndexOf('/')).split('/')[1]; //to trim the file
				var fileNode = document.createElement('div');
				fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
				fileNode.setAttribute('id', 'nodeId_' + i);
				document.getElementById('share').appendChild(fileNode);

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
				boldSection.appendChild(document.createTextNode('Shared by: ____'+myJSON.shareBy[i]+'____Shared file name: ____________' + filteredFileName[i]));
				boldSection.appendChild(document.createTextNode('____________'));
				document.getElementById('fileLabel_' + i).appendChild(boldSection);
				
				var fileSelect = document.createElement('input');
				fileSelect.setAttribute('id', 'file' + i);
				fileSelect.setAttribute('class', 'checkboxClass');
				fileSelect.setAttribute('name', 'chkbx');
				fileSelect.setAttribute('value', myJSON.shareId[i] + ';' + trueFilePath[i]);
				fileSelect.setAttribute('type', 'checkbox');
				document.getElementById('boldId_' + i).appendChild(fileSelect);
			}
		});
	} else if($(this).text() == 'Upgrade'){
		$('div#status').hide();
		$('div#share').hide();
		$('.file-block').remove();
		//$('div#upgrade').show();
		console.log($(this).text());
		//var upgradebtn = document.getElementById("op1");
		//upgradebtn.style.display = "block";
		var fileType = ($(this).text().substring($(this).text().length - 1) == 's') ? $(this).text().substring(0, $(this).text().length - 1) : $(this).text();
		$('#pageTitle').text(fileType);

		var fileNode = document.createElement('div');
		fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
		fileNode.setAttribute('id', 'upBtn');
		fileNode.appendChild(document.createTextNode('Select the storage capacity you want:'));
		document.getElementById('upgradeSection').appendChild(fileNode);

		var normalSize = document.createElement("input");
	    normalSize.setAttribute("type", "button");
	    normalSize.setAttribute("value", "5MB");
	    normalSize.setAttribute("name", "normalSizeBtn");
	    document.getElementById("upBtn").appendChild(normalSize);


		var premiumSizeBtn = document.createElement("input");
	    premiumSizeBtn.setAttribute("type", "button");
	    premiumSizeBtn.setAttribute("value", "10MB");
	    premiumSizeBtn.setAttribute("name", "premiumSizeBtn");
	    document.getElementById("upBtn").appendChild(premiumSizeBtn);

		var platiumSizeBtn = document.createElement("input");
	    platiumSizeBtn.setAttribute("type", "button");
	    platiumSizeBtn.setAttribute("id", "platium");
	    platiumSizeBtn.setAttribute("value", "20MB");
	    platiumSizeBtn.setAttribute("name", "platiumSizeBtn");
	    document.getElementById("upBtn").appendChild(platiumSizeBtn);

	}else if($(this).text() == 'Folders') {
		console.log($(this).text());
		var createFolderbtn = document.getElementById("op1");
		createFolderbtn.style.display = "block";
		$('#op1').text('Create new folder');
		$('#op2').text('');
		$('#path').text((navigator.appVersion.indexOf('Mac') != -1)?'/':'\\');
		$('#file').text('');
		$('#pageTitle').text($(this).text());
		createFolderList();
	} else {
		$('#path').text('');
		var userRole = $.cookie("name");
		var fileType = ($(this).text().substring($(this).text().length - 1) == 's') ? $(this).text().substring(0, $(this).text().length - 1) : $(this).text();
		if($(this).text() == 'Programmes') fileType = 'Program';
		$.post('account.php', {userRole : userRole, fileType : fileType}, function(data) {
			var myJSON = $.parseJSON(data);
			//console.log(myJSON.name);
			var fileName = Array();
			var filePath = Array();
			if ($('#file').has('div').length > 0) {
				$('.file-block').remove();
				$('#pageTitle').text(fileType);
				for (var i = 0; i < myJSON.name.length; i++) {
					filePath[i] = myJSON.name[i];
					fileName[i] = myJSON.name[i].substring(myJSON.name[i].lastIndexOf("/"));
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
					boldSection.appendChild(document.createTextNode('Name: ' + fileName[i]));//myJSON.name[i]));
					boldSection.appendChild(document.createTextNode('____________'));
					boldSection.appendChild(document.createTextNode(' Last Modified: ' + myJSON.time[i]));
					boldSection.appendChild(document.createTextNode('______'));
					document.getElementById('fileLabel_' + i).appendChild(boldSection);
					var fileSelect = document.createElement('input');
					fileSelect.setAttribute('id', 'file' + i);
					fileSelect.setAttribute('class', 'checkboxClass');
					fileSelect.setAttribute('name', 'chkbx');
					fileSelect.setAttribute('value', filePath[i]);
					fileSelect.setAttribute('type', 'checkbox');
					document.getElementById('boldId_' + i).appendChild(fileSelect);
				}
			} else {
				$('#pageTitle').text(fileType);
				for (var i = 0; i < myJSON.name.length; i++) {
					filePath[i] = myJSON.name[i];
					fileName[i] = myJSON.name[i].substring(myJSON.name[i].lastIndexOf("/"));
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
					boldSection.appendChild(document.createTextNode('Name: ' + fileName[i]));//myJSON.name[i]));
					boldSection.appendChild(document.createTextNode('____________'));
					boldSection.appendChild(document.createTextNode(' Last Modified: ' + myJSON.time[i]));
					boldSection.appendChild(document.createTextNode('______'));
					document.getElementById('fileLabel_' + i).appendChild(boldSection);
					var fileSelect = document.createElement('input');
					fileSelect.setAttribute('id', 'file' + i);
					fileSelect.setAttribute('class', 'checkboxClass');
					fileSelect.setAttribute('name', 'chkbx');
					fileSelect.setAttribute('value', filePath[i]);
					fileSelect.setAttribute('type', 'checkbox');
					document.getElementById('boldId_' + i).appendChild(fileSelect);
				}
			}
		});
	}
});

$('div#share').on('click', '.file-block', function(){
	$(this).prop('checked', true);
	if($(this).prop('checked') == true){
		var opbtn1 = document.getElementById("op1");
		var opbtn2 = document.getElementById("op2");
		var opbtn3 = document.getElementById("op3");
		var opbtn4 = document.getElementById("op4");
		$('#op1').text('Select All');
		$('#op2').text('Download Selected');
		$('#op3').text('Unshare Selected');
		$('#op4').text('Share to');
		opbtn1.style.display = "block";
		opbtn2.style.display = "block";
		opbtn3.style.display = "block";
		opbtn4.style.display = "block";
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
		var opbtn1 = document.getElementById("op1");
		var opbtn2 = document.getElementById("op2");
		var opbtn3 = document.getElementById("op3");
		var opbtn4 = document.getElementById("op4");
		$('#op1').text('Select All');
		$('#op2').text('Download Selected');
		$('#op3').text('Delete Selected');
		$('#op4').text('Share to');
		opbtn1.style.display = "block";
		opbtn2.style.display = "block";
		opbtn3.style.display = "block";
		opbtn4.style.display = "block";
    }
});

$('#op1').click(function(e){
	e.preventDefault();
	if($('#op1').text() == 'Select All') {
		$('.checkboxClass').prop('checked', true);
		$('#op1').text('Disselect All');
	} else if($('#op1').text() == 'Disselect All') {
		$('.checkboxClass').prop('checked', false);
		$('#op1').text('Select All');
	} else if($('#op1').text() == 'Create new folder') {
		createFolderItem();
	}
	return false;
});

$('#op2').on('click', function(){
	var myArray= new Array();
	for(var i = 0; i < $('input[name="chkbx"]:checked').length; i++){
		myArray[i] = $('input[name="chkbx"]:checked')[i].value;
}
	console.log(myArray);
	$.cookie("fileList", myArray);
});
$('#op3').on('click', function(){
	if($('#op3').text() == 'Delete Selected'){
		var selectedDelFiles= new Array();
		var userRole = $.cookie("name");
		for(var i = 0; i < $('input[name="chkbx"]:checked').length; i++)
			selectedDelFiles[i] = $('input[name="chkbx"]:checked')[i].value;
		$.post('account.php', {selectedDelFiles : selectedDelFiles, userRole : userRole}, function(data){
			console.log(data);
			location.reload();
		});
	}else if($('#op3').text() == 'Unshare Selected'){
		unShareFile();
	}
});

$('#op4').on('click', function(){
	shareTo();
});
$('#premiumSizeBtn').on('click', function(){
	sizeUpgrade();
});
function createFolderItem() {
	var createFolder = true;
	var userRole = $.cookie("name");
	var currentpath = $('#path').text().toLowerCase();
	console.log('Current path: ' + currentpath);
	$('#foldernameform').dialog({
		autoOpen: true,
		buttons: {
			"Create": function() {
				var foldername = $('#foldername').val();	
      			console.log('Create folder: ' + foldername);
      			$(this).dialog("close");
      			$.post('account.php', {userRole : userRole , createFolder : createFolder, foldername : foldername, currentpath : currentpath}, function(data){
      				console.log(data);
      				//location.reload();
      				//$('#path').text(currentpath);
				});
        	}
        }
	});
}

function sizeUpgrade() {
	alert("clicked!");
}
function shareTo() {
	var userRole = $.cookie("name");
	$('#shareToForm').dialog({
	autoOpen: true,
		buttons: {
			"Share": function() {
				var shareToName = $('#shareToName').val();	
	  			var selectedFiles= new Array();
				var userRole = $.cookie("name");
				for(var i = 0; i < $('input[name="chkbx"]:checked').length; i++)
					selectedFiles[i] = $('input[name="chkbx"]:checked')[i].value;
					$.post('account.php', {selectedFiles : selectedFiles, userRole : userRole, shareToName : shareToName}, function(data){
						console.log("Shared to: "+shareToName);
						console.log('Return status: ' + data);
		    			location.reload();
					});
	    	}
	    }
	});
	 	var selectedFilesAnother = new Array();
	for (var i = 0; i < $('input[name="chkbx"]:checked').length;i++){
		selectedFilesAnother[i] = $('input[name="chkbx"]:checked')[i].value;
		selectedFilesAnother[i] = selectedFilesAnother[i].substring(selectedFilesAnother[i].lastIndexOf("/")+1);
		//selectedfilesAnother[i] = btoa(selectedFilesAnother[i]);
		var test=document.getElementById('shareToURL').innerText="http://localhost/backupscloud/cloud_login/cloud/download_V2.php?f="+btoa(selectedFilesAnother[i]);
	}
}
function unShareFile() {
	var userRole = $.cookie("name");;
	var unShareFileID = Array();
	var unShareFilePath = Array();
	var selectedValue = Array();
	for(var i = 0; i < $('input[name="chkbx"]:checked').length; i++){
		selectedValue[i] = $('input[name="chkbx"]:checked')[i].value;
	}
	for (var i = 0; i < selectedValue.length; i++) {
		unShareFileID[i] = selectedValue[i].split(';')[0];
		unShareFilePath[i] = selectedValue[i].split(';')[1];
		console.log(unShareFileID[i]);
		console.log(unShareFilePath[i]);
	};
	$.post('account.php',{unShareFileID : unShareFileID, userRole : userRole}, function(data){
		console.log(data);
		location.reload();
	});
}
function createFolderList() {
	var selectedFolder = osseparator;
	var currentpath = osseparator;
	var userRole = $.cookie("name");
	$.post('account.php', {userRole : userRole, selectedFolder : selectedFolder, currentpath : currentpath}, function(data){
		console.log('Returned File list: ' + data);
		var myJSON = $.parseJSON(data);
		
		$('#path').text(myJSON.backLink[0]);
		if($('#folderlist').has('div').length > 0) {
			$('.file-block').remove();

			for (var i = 0; i < myJSON.visableLink.length; i++) {
				var foldernameonly = myJSON.visableLink[i].split('upload' + osseparator + userRole + osseparator);
				//console.log(foldernameonly[1]);
				// Check directory that contains a subdirectory
				if(foldernameonly[1].match('/')) {
					console.log('This is a subdirectory: ' + myJSON.visableLink[i]);
				} else {
					var fileNode = document.createElement('div');
					fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
					fileNode.setAttribute('id', 'nodeId_' + i);
					document.getElementById('folderlist').appendChild(fileNode);

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
					boldSection.appendChild(document.createTextNode(foldernameonly[1]));
					document.getElementById('fileLabel_' + i).appendChild(boldSection);
				}
			}
		} else {
			for (var i = 0; i < myJSON.visableLink.length; i++) {
				var foldernameonly = myJSON.visableLink[i].split('upload' + osseparator + userRole + osseparator);
				console.log(foldernameonly[1]);
				// Check directory that contains a subdirectory
				if(foldernameonly[1].match('/')) {
					console.log('This is a subdirectory: ' + myJSON.visableLink[i]);
				} else {
					var fileNode = document.createElement('div');
					fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
					fileNode.setAttribute('id', 'nodeId_' + i);
					document.getElementById('folderlist').appendChild(fileNode);

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
					boldSection.appendChild(document.createTextNode(foldernameonly[1]));
					document.getElementById('fileLabel_' + i).appendChild(boldSection);
				}
			}
		}
	});
}


$('div#folderlist').on('click', '.file-block', function(){
	var goinner = true;
	var userRole = $.cookie("name");
	var selected = $(this).text();
	var currentpath = $('#path').text().split(userRole)[1];

	$.post('account.php', {userRole : userRole, goinner : goinner, selected : selected, currentpath : currentpath}, function(data){
		console.log(data);
		var myJSON = $.parseJSON(data);

		$('#path').text(myJSON.backLink[0]);
		if($('#folderlist').has('div').length > 0) {
			$('.file-block').remove();
			for (var i = 0; i < myJSON.visableLink.length; i++) {
					var foldernameonly = myJSON.visableLink[i].split('upload' + osseparator + userRole + osseparator);
					var fileNode = document.createElement('div');
					fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
					fileNode.setAttribute('id', 'nodeId_' + i);
					document.getElementById('folderlist').appendChild(fileNode);

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
					boldSection.appendChild(document.createTextNode(foldernameonly[1].split('/')[1]));
					document.getElementById('fileLabel_' + i).appendChild(boldSection);
			}
		} else {
			for (var i = 0; i < myJSON.visableLink.length; i++) {
				var foldernameonly = myJSON.visableLink[i].split('upload' + osseparator + userRole + osseparator);
				var fileNode = document.createElement('div');
				fileNode.setAttribute('class', 'file-block prefix-10 mobile-grid-100 micro-grid-100');
				fileNode.setAttribute('id', 'nodeId_' + i);
				document.getElementById('folderlist').appendChild(fileNode);

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
				boldSection.appendChild(document.createTextNode(foldernameonly[1].split('/')[1]));
				document.getElementById('fileLabel_' + i).appendChild(boldSection);
			}
		}
	});
});

$('div#upgradeSection').on('click', function(){
	$.cookie("changedMem", 20971520);
});





