function init() {
	$('.btn-danger.openmodal').on('click', function() {
		$('#modalDelete span#target').text(this.parentNode.previousElementSibling.previousElementSibling.firstElementChild.textContent);
	});
	$('.editbtn').on('click', function() {
		resetEdits();
		$(this).prop("disabled", true);
		let name = this.parentNode.previousElementSibling.firstElementChild;
		name.style.display = 'none';
		name.nextElementSibling.style.display = 'initial';
		name.nextElementSibling.disabled = false;
	});
}

function resetEdits(){
	$('.editbtn').prop("disabled", false);
	$('.originalName').css('display', 'initial');
	$('.grid-item .form').css('display', 'none');

	let inputs = document.getElementsByClassName('inputname');
	for(let item of inputs) {
		item.value = item.parentNode.parentNode.previousElementSibling.textContent;
	}
}

function submitCategoryForm(){
    let name = $("#modalForm input[name='name']").val();
    if(name.trim() == '' || name.length < 3 || name.length > 50){
		$('#statusMsg').text('Please fill the name input field with at least 3 characters and a maximum of 50');
		$("#modalForm input[name='name']").focus();
        return false;
    } else {
        $.ajax({
            type:'POST',
            url:'/php/newcategory.php',
            data:'name='+name,
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
						$('#statusMsg').html('This Category is already inserted, please fill the name field with a new value');
					} else {
						$('#statusMsg').html('Please fill the name input field with a correct value');
					}
					$("#modalForm input[name='name']").focus();
					$('#modalForm .submitBtn').removeAttr("disabled");
					$('#modalForm .modal-body').css('opacity', '');
				}
            }
        });
    }
}

function submitCategoryUpdate(id) {
    let name = $(".inputname."+id).val();
    if(name.trim() == '' || name.length < 3 || name.length > 50){
		alert('Please fill the name input field with at least 3 characters and a maximum of 50');
		$("#editForm input[name='name']").focus();
        return false;
    } else {
        $.ajax({
            type:'POST',
            url:'/php/newcategory.php',
            data:'id='+id+'&name='+name,
            beforeSend:function () {
                $('#editForm .submitBtn').attr("disabled","disabled");
                $('#editForm .modal-body').css('opacity', '.5');
            },
            success:function(msg){
                if(msg == 'ok'){
					location.reload();
                } else {
					if(msg == 'length') {
						alert('Please fill the name input field with at least 3 characters and a maximum of 50');
					} else if(msg == 'notunique') {
						alert('This Category is already inserted, please fill the name field with a new value');
					} else if(msg == 'nonexistent') {
						alert("Please don't change any parameter that isn't intended to, only the name is permitted");
					} else {
						alert('Please fill the name input field with a correct value');
					}
					$("#editForm input[name='name']").focus();
					$('#editForm .submitBtn').removeAttr("disabled");
					$('#editForm .modal-body').css('opacity', '');
				}
            }
        });
    }
}