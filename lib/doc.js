function init() {
	$('.btn-danger.openmodal').on('click', function() {
		$('#modalDelete span#target').text(this.parentNode.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.firstElementChild.textContent);
		$('#modalDelete span#target2').text(this.parentNode.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.firstElementChild.textContent);
		$('#modalDelete span#target3').text(this.parentNode.previousElementSibling.previousElementSibling.previousElementSibling.firstElementChild.textContent);
		$('#modalDelete span#target4').text(this.parentNode.previousElementSibling.previousElementSibling.firstElementChild.textContent);
		$('#modalDelete input[name=doc_id]').val(this.classList[0]);
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
		name = name.parentNode.previousElementSibling.firstElementChild;
		name.style.display = 'none';
		name.nextElementSibling.style.display = 'initial';
		name.nextElementSibling.disabled = false;
		name = name.parentNode.previousElementSibling.firstElementChild;
		name.style.display = 'none';
		name.nextElementSibling.style.display = 'initial';
		name.nextElementSibling.disabled = false;
	});

	$('#modalForm select[name=subcategory_id]').change(function() {
		$('#modalForm select[name=category_id]').val(this.options[this.selectedIndex].classList[0]);
	});
	$('#modalForm select[name=category_id]').change(function() {
		$('#modalForm select[name=subcategory_id]').val('');
		$('#modalForm select[name=subcategory_id] > option').prop('disabled', true);
		$('#modalForm select[name=subcategory_id] > option.'+this.value).prop('disabled', false);
	});
	$('.selectsub').change(function() {
		$('.selectcat.'+this.classList[1]).val(this.options[this.selectedIndex].classList[0]);
	});
	$('.selectcat').change(function() {
		$('.selectsub').val('');
		$('.selectsub.'+this.classList[1]+' > option').prop('disabled', true);
		$('.selectsub.'+this.classList[1]+' > option.'+this.value).prop('disabled', false);
	});
}

function resetEdits(){
	$('.editbtn').prop("disabled", false);
	$('.originalName').css('display', 'initial');
	$('.originalDesc').css('display', 'initial');
	$('.originalCatName').css('display', 'initial');
	$('.originalSubName').css('display', 'initial');
	$('.grid-item .form').css('display', 'none');
	$('.grid-item .descform').css('display', 'none');
	$('.grid-item .Catform').css('display', 'none');
	$('.grid-item .Subform').css('display', 'none');

	let inputs = document.getElementsByClassName('inputname');
	for(let item of inputs) {
		item.value = item.parentNode.parentNode.previousElementSibling.textContent;
	}
	inputs = document.getElementsByClassName('inputdesc');
	for(let item of inputs) {
		item.value = item.parentNode.parentNode.previousElementSibling.textContent;
	}
	inputs = document.getElementsByClassName('selectcat');
	for(let item of inputs) {
		item.value = item.previousElementSibling.value;
	}
	inputs = document.getElementsByClassName('selectsub');
	for(let item of inputs) {
		item.value = item.previousElementSibling.value;
	}
	$('.selectsub > option').prop('disabled', false);
}

function submitDocumentForm() {
    let name = $.trim($("#modalForm input[name='name']").val());
    let desc = $.trim($("#modalForm textarea[name='desc']").val());
    let subcategory_id = $.trim($("#modalForm select[name='subcategory_id']").val());
    if(name == '' || name.length < 5 || name.length > 120) {
		$('#statusMsg').text('Please fill the name input field with at least 5 characters and a maximum of 50');
		$("#modalForm input[name='name']").focus();
        return false;
    } else if (subcategory_id == '' || !isNumeric(subcategory_id)) {
		console.log(subcategory_id);
		$('#statusMsg').text('Please select a subcategory in order to create a new document');
		$("#modalForm select[name='subcategory_id']").focus();
        return false;
	} else {
        $.ajax({
            type:'POST',
            url:'/php/newdocument.php',
            data:'name='+name+'&desc='+desc+'&subcategory_id='+subcategory_id,
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
					} else if(msg == 'subcategory_id') {
						$('#statusMsg').html('This Subcategory id is not a number! Please select from the dropdown');
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

function submitDocumentUpdate(id) {
    let name = $.trim($(".inputname."+id).val());
    let desc = $.trim($(".inputdesc."+id).val());
    let subcategory_id = $.trim($(".selectsub."+id).val());
    if(name.trim() == '' || name.length < 3 || name.length > 50) {
		alert('Please fill the name input field with at least 3 characters and a maximum of 50');
		$("#modalForm input[name='name']").focus();
        return false;
    } else if (subcategory_id == '' || !isNumeric(subcategory_id)) {
		alert('Both category and subcategory are necessary to continue, please select in order to create a new document');
		$("#modalForm select[name='subcategory_id']").focus();
        return false;
	} else {
        $.ajax({
            type:'POST',
            url:'/php/newdocument.php',
            data:'name='+name+'&desc='+desc+'&subcategory_id='+subcategory_id+'&id='+id,
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