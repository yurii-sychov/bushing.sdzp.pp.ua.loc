function changeFilial(event) {
	$('#selectStantion').find('option:not(option:first)').remove();
	$('#selectDisp').find('option:not(option:first)').remove();

	if (event.target.value) {
		$.ajax({
			url: '/api/stantions/get_stantions/'+event.target.value,
			type: 'GET',
			data: {'filial_id': event.target.value},
			cache: false,
			dataType: 'json',
			success: function(response, status, jqXHR) {
				if (response.status === 'SUCCESS') {
					let option = '';
					response.data.forEach(function(item, key) {
						option += `<option value="${item.id}">${item.name}</option>`;
					});
					$('#selectStantion').find('option').after(option);
					$('#selectStantion').prop('disabled', false);
				}
				else {
					
				}
			},
			error: function(jqXHR, status, errorThrown ){
				console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
			}
		});
	}
	else {
		$('#selectStantion').prop('disabled', true);
		$('#selectDisp').prop('disabled', true);
		$('#selectPhase').prop('disabled', true).val('');
	}
}

function changeStantion(event) {
	$('#selectDisp').find('option:not(option:first)').remove();

	if (event.target.value) {	
		$.ajax({
			url: '/api/disps/get_disps/'+event.target.value,
			type: 'GET',
			data: {'stantion_id': event.target.value},
			cache: false,
			dataType: 'json',
			success: function(response, status, jqXHR) {
				if (response.status === 'SUCCESS') {
					let option = '';
					response.data.forEach(function(item, key) {
						option += `<option value="${item.id}">${item.name}</option>`;
					});
					$('#selectDisp').find('option').after(option);
					$('#selectDisp').prop('disabled', false);
				}
				else {
					
				}
			},
			error: function(jqXHR, status, errorThrown ){
				console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
			}
		});
	}
	else {
		$('#selectDisp').prop('disabled', true);
		$('#selectPhase').prop('disabled', true).val('');
	}
}

function changeDisp(event) {
	if (event.target.value) {	
		$('#selectPhase').prop('disabled', false);
	}
	else {
		$('#selectPhase').prop('disabled', true).val('');
	}
}