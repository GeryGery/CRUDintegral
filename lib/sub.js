function init() {
	$('.btn-danger.openmodal').on('click', function() {
		$('#modalDelete span#target').text(this.parentNode.previousElementSibling.previousElementSibling.previousElementSibling.firstElementChild.textContent);
		$('#modalDelete span#target2').text(this.parentNode.previousElementSibling.previousElementSibling.firstElementChild.textContent);
	});
	$('.editbtn').on('click', function() {
		resetEdits();
		$(this).prop("disabled", true);
		let name = this.parentNode.previousElementSibling.firstElementChild;
		name.style.display = 'none';
		name.nextElementSibling.style.display = 'initial';
		name.nextElementSibling.disabled = false;
		name = name.parentNode.previousElementSibling.firstElementChild;
		name.style.display = 'none';
		name.nextElementSibling.style.display = 'initial';
		name.nextElementSibling.disabled = false;
	});
}

function resetEdits(){
	$('.editbtn').prop("disabled", false);
	$('.originalName').css('display', 'initial');
	$('.originalCatName').css('display', 'initial');
	$('.grid-item .form').css('display', 'none');
	$('.grid-item .Catform').css('display', 'none');
	
	let inputs = document.getElementsByClassName('inputname');
	for(let item of inputs) {
		item.value = item.parentNode.parentNode.previousElementSibling.textContent;
	}
	inputs = document.getElementsByClassName('selectcat');
	for(let item of inputs) {
		item.value = item.previousElementSibling.value;
	}
}

function submitSubcategoryForm() {
    let name = $.trim($("#modalForm input[name='name']").val());
    let category_id = $.trim($("#modalForm select[name='category_id']").val());
    if(name.trim() == '' || name.length < 3 || name.length > 50) {
		$('#statusMsg').text('Please fill the name input field with at least 3 characters and a maximum of 50');
		$("#modalForm input[name='name']").focus();
        return false;
    } else if (category_id == '' || !isNumeric(category_id)) {
		$('#statusMsg').text('Please select a category in order to create a new subcategory');
		$("#modalForm select[name='category_id']").focus();
        return false;
	} else {
        $.ajax({
            type:'POST',
            url:'/php/newsubcategory.php',
            data:'name='+name+'&category_id='+category_id,
            beforeSend:function () {
                $('#modalForm .submitBtn').attr("disabled","disabled");
                $('#modalForm .modal-body').css('opacity', '.5');
            },
            success:function(msg){
                if(msg == 'ok'){
                    $("#modalForm input[name='name']").val('');
					$('#modalForm .submitBtn').removeAttr("disabled");
					$('#modalForm .modal-body').css('opacity', '');
					location.reload();
                } else {
					if(msg == 'length') {
						$('#statusMsg').html('Please fill the name input field with at least 3 characters and a maximum of 50');
					} else if(msg == 'notunique') {
						$('#statusMsg').html('This Subcategory is already inserted, please fill the name field with a new value');
					} else if(msg == 'nonexistent') {
						$('#statusMsg').html("This Subcategory doesn't exist, please select a value");
					} else {
						$('#statusMsg').html('Please fill the name input field with a correct value'+msg);
					}
					$("#modalForm input[name='name']").focus();
					$('#modalForm .submitBtn').removeAttr("disabled");
					$('#modalForm .modal-body').css('opacity', '');
				}
            }
        });
    }
}

function submitSubcategoryUpdate(id) {
    let name = $.trim($(".inputname."+id).val());
    let category_id = $.trim($(".selectcat."+id).val());
    if(name.trim() == '' || name.length < 3 || name.length > 50) {
		alert('Please fill the name input field with at least 3 characters and a maximum of 50');
		$("#modalForm input[name='name']").focus();
        return false;
    } else if (category_id == '' || !isNumeric(category_id)) {
		alert('Please select a category in order to create a new subcategory');
		$("#modalForm select[name='category_id']").focus();
        return false;
	} else {
        $.ajax({
            type:'POST',
            url:'/php/newsubcategory.php',
            data:'name='+name+'&category_id='+category_id+'&id='+id,
            beforeSend:function () {
                $('#modalForm .submitBtn').attr("disabled","disabled");
                $('#modalForm .modal-body').css('opacity', '.5');
            },
            success:function(msg){
                if(msg == 'ok'){
                    $("#modalForm input[name='name']").val('');
					$('#modalForm .submitBtn').removeAttr("disabled");
					$('#modalForm .modal-body').css('opacity', '');
					location.reload();
                } else {
					if(msg == 'length') {
						alert('Please fill the name input field with at least 3 characters and a maximum of 50');
					} else if(msg == 'notunique') {
						alert('This Subcategory is already inserted, please fill the name field with a new value');
					} else {
						alert('Please fill the name input field with a correct value'+msg);
					}
					$("#modalForm input[name='name']").focus();
					$('#modalForm .submitBtn').removeAttr("disabled");
					$('#modalForm .modal-body').css('opacity', '');
				}
            }
        });
    }
}