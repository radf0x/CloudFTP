$(document).ready(function() {
	var showIndexTable = 'fire';
	$.post('GetData.php', {
		showIndexTable : showIndexTable
	}, function(data) {
		var myJSON = $.parseJSON(data);
		$.each(myJSON, function(key, value) {
			var alphaIndex = value.substring(0,1);
			var indexNum = value.substring(2);
			var indexNode = document.createElement('div');
			indexNode.setAttribute('class', 'indexLink grid-10 mobile-grid-20 micro-grid-50');
			indexNode.setAttribute('id', 'indexNode_' + key);
			indexNode.setAttribute("value", value);
			document.getElementById("indexTable").appendChild(indexNode);
			var alphaNode = document.createElement('section');
			alphaNode.setAttribute('class', 'link-block');
			alphaNode.setAttribute('id', 'alphaNode_' + key);
			document.getElementById('indexNode_' + key).appendChild(alphaNode);
			var index = document.createElement('b');
			index.appendChild(document.createTextNode(alphaIndex));
			index.setAttribute('id', 'index_' + key);
			document.getElementById('alphaNode_' + key).appendChild(index);
			var exponent = document.createElement('span');
			exponent.setAttribute('class', 'exponentStyle');
			exponent.appendChild(document.createTextNode(indexNum));
			document.getElementById('index_' + key).appendChild(exponent);
		});
	});
});

$('div#indexTable').on('click', '.indexLink', function() {
	var index = $(this).text().substring(0, 1);
	var numOfIndex = $(this).text().substring(2);
	$.post('GetData.php', {
		index : index
	}, function(data) {
		var myJSON = $.parseJSON(data);
		if ($('#resultList').has('div').length > 0) {
			$('#blankNode').remove();
			$('.resultChild').remove();
			for (var i = 0; i < myJSON.length; i++) {
				var ngoNameNode = document.createElement('div');
				ngoNameNode.setAttribute("class", " resultChild grid-50 mobile-grid-50 micro-grid-100 indexLink");
				ngoNameNode.setAttribute("name", "result_" + i);
				ngoNameNode.setAttribute("id", 'ngoNameNode_' + i);
				document.getElementById("resultList").appendChild(ngoNameNode);
				var nameNode = document.createElement('section');
				nameNode.setAttribute('class', 'ngoName-block');
				nameNode.setAttribute('id', 'nameNode_' + i);
				document.getElementById('ngoNameNode_' + i).appendChild(nameNode);
				var ngoName = document.createElement('b');
				ngoName.appendChild(document.createTextNode(myJSON[i]));
				ngoName.setAttribute('id', 'ngoName_' + i);
				document.getElementById('nameNode_' + i).appendChild(ngoName);
				if(i == myJSON.length - 1 && (myJSON.length % 2) != 0) {
					var blankNode = document.createElement('div');
					blankNode.setAttribute('class', 'grid-50 mobile-grid-50 micro-grid-100');
					blankNode.setAttribute('id', 'blankNode');
					document.getElementById('resultList').appendChild(blankNode);
					var blankSection = document.createElement('section');
					blankSection.setAttribute('class', 'ngoName-block');
					blankSection.setAttribute('id', 'blankSectionId');
					document.getElementById('blankNode').appendChild(blankSection);
					var blankText = document.createElement('b');
					blankText.appendChild(document.createTextNode('Total ' + myJSON.length + ' result(s).'));
					document.getElementById('blankSectionId').appendChild(blankText);
				}
			}
		} else {
			for (var i = 0; i < myJSON.length; i++) {
				var ngoNameNode = document.createElement('div');
				ngoNameNode.setAttribute("class", " resultChild grid-50 mobile-grid-50 micro-grid-100 indexLink");
				ngoNameNode.setAttribute("name", "result_" + i);
				ngoNameNode.setAttribute("id", 'ngoNameNode_' + i);
				document.getElementById("resultList").appendChild(ngoNameNode);
				var nameNode = document.createElement('section');
				nameNode.setAttribute('class', 'ngoName-block');
				nameNode.setAttribute('id', 'nameNode_' + i);
				document.getElementById('ngoNameNode_' + i).appendChild(nameNode);
				var ngoName = document.createElement('b');
				ngoName.appendChild(document.createTextNode(myJSON[i]));
				ngoName.setAttribute('id', 'ngoName_' + i);
				document.getElementById('nameNode_' + i).appendChild(ngoName);
				if(i == myJSON.length - 1 && (myJSON.length % 2) != 0) {
					var blankNode = document.createElement('div');
					blankNode.setAttribute('class', 'grid-50 mobile-grid-50 micro-grid-100');
					blankNode.setAttribute('id', 'blankNode');
					document.getElementById('resultList').appendChild(blankNode);
					var blankSection = document.createElement('section');
					blankSection.setAttribute('class', 'ngoName-block');
					blankSection.setAttribute('id', 'blankSectionId');
					document.getElementById('blankNode').appendChild(blankSection);
					var blankText = document.createElement('b');
					blankText.appendChild(document.createTextNode('Total ' + myJSON.length + ' result(s).'));
					document.getElementById('blankSectionId').appendChild(blankText);
				}
			}
		}
	});
});

$('div#resultList').on('click', '.resultChild', function(){
	var ngo = $(this).text().trim();
	var currentId = this.id.substring(this.id.length - 1);
	$.post('GetData.php', {
		ngo : ngo
	}, function(data){
		var myJSON = $.parseJSON(data);
		$.each(myJSON[0], function(key, value){
			var ngoDetail = value.split(/[\n]/);
			if($('#ngoResult').has('div').length > 0) {
				$('.ngodesc').remove();
				var ngoNode = document.createElement('div');
				ngoNode.setAttribute("class", "ngodesc grid-50 mobile-grid-100 micro-grid-100 indexLink");
				ngoNode.setAttribute("id", 'ngoNode_0');
				document.getElementById('ngoResult').appendChild(ngoNode);
				var  infoNode = document.createElement('section');
				infoNode.setAttribute('class', 'ngoName-block');
				infoNode.setAttribute('id', 'infoNode_' + currentId);
				document.getElementById('ngoNode_0').appendChild(infoNode);
				var ngoInfo = document.createElement('b');
				ngoInfo.appendChild(document.createTextNode(ngoDetail[0]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[1]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[2]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[3]));
				ngoInfo.setAttribute('id', 'ngoInfo_' + currentId);
				document.getElementById('infoNode_' + currentId).appendChild(ngoInfo);
			} else {
				var ngoNode = document.createElement('div');
				ngoNode.setAttribute("class", "ngodesc grid-50 mobile-grid-100 micro-grid-100 indexLink");
				ngoNode.setAttribute("id", 'ngoNode_0');
				document.getElementById('ngoResult').appendChild(ngoNode);
				var  infoNode = document.createElement('section');
				infoNode.setAttribute('class', 'ngoName-block');
				infoNode.setAttribute('id', 'infoNode_' + currentId);
				document.getElementById('ngoNode_0').appendChild(infoNode);
				var ngoInfo = document.createElement('b');
				ngoInfo.appendChild(document.createTextNode(ngoDetail[0]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[1]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[2]));
				ngoInfo.appendChild(document.createElement('br'));
				ngoInfo.appendChild(document.createTextNode(ngoDetail[3]));
				ngoInfo.setAttribute('id', 'ngoInfo_' + currentId);
				document.getElementById('infoNode_' + currentId).appendChild(ngoInfo);
			}
		});
	});
});


