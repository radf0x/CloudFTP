$('input#newMember-submit').on('click', function() {
	var role = $('input[name="role"]:checked').val();
	var userName = $('input#userName').val();
	var pwd = $('input#pwd').val();
	var name = $('input#fullname').val();
	var phone = $('input#phone').val();
	var address = $('textarea#address').val();
	if ($.trim(userName) != '' && $.trim(pwd) != ''&& $.trim(name) != '' && $.trim(phone) != '' && $.trim(address) != '') {
		$.post('account.php', {role : role, userName : userName, pwd : pwd, name : name, phone : phone, address : address}, function(data) {
			$.cookie("name", $('input#userName').val());
			$(location).attr('href', "home.html");
		});
	}
});

$('input#oldMember-submit').on('click', function() {
	var oldUserName = $('input#oldUserName').val().trim();
	var oldPwd = $('input#oldPwd').val().trim();
	if ($.trim(oldUserName) != '' && $.trim(oldPwd) != '') {
		$.post('account.php', {oldUserName : oldUserName, oldPwd : oldPwd}, function(data) {
			$.cookie("name", $('input#oldUserName').val());
			$(location).attr('href', "home.html");
		});
	}
});

$('div#ngo').on('click', function(){
	$(location).attr('href', "../ngo/home.html");
});
