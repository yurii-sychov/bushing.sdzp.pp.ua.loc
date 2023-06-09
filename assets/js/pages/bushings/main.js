$(document).ready(function() {
	$('#buttonMailModal').click(function(event) {
		event.preventDefault();
		const form = $('#formMailModal')[0];
		const name = form.name.value;
		const subject = form.subject.value;
		const message = form.message.value;

		const data = {
			name: name,
			subject: subject,
			message: message,
		};

		toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

		$.ajax({
			url: '/main/submit_message_ajax',
			type: 'POST',
			data: data,
			cache: false,
			dataType: 'json',
			success: function(response, status, jqXHR) {
				if (response.status === 'SUCCESS') {
					$('#mailModal').modal('hide');
					form.reset();
					toastr["success"]("Повідомлення відправлено.", "Успіх!");
				}
				else {
					let message = '';
					response.message.forEach(function(item, key) {
						message += `
							<span>${item.message}</span><br>						
						`;
					});
					toastr["error"](message, "Помилка!");
				}
			},
			error: function(jqXHR, status, errorThrown ){
				console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
			}
		});
	});

	$.ajax({
		url: '/passports/get_count_passports_year_ajax',
		method: "POST",
		success: function(json) {
			const d = json.data;		
			const labels = [];
			const data = [];
			d.forEach(function(item, i, array) {
				labels.push(item.year_made_format);
				data.push(item.count);
			});
			var ctx = document.getElementById('countPassportsYear').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [
						{
							label: 'Кількість, шт.',
							data: data,
							backgroundColor: 'rgb(173, 255, 47, 0.5)',
							borderColor: 'rgb(255, 255, 255)',
							borderWidth: 1
						}
					]
				}
			});
		}
	});

	$.ajax({
		url: '/passports/get_count_passports_tip_ajax',
		method: "POST",
		success: function(json) {
			const d = json.data;		
			const labels = [];
			const data = [];
			d.forEach(function(item, i, array) {
				labels.push(item.tip);
				data.push(item.count);
			});
			var ctx = document.getElementById('countPassportsTip').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: labels,
					datasets: [
						{
							label: 'Кількість, шт.',
							data: data,
							backgroundColor: 'rgb(54, 255, 235, 0.5)',
							borderColor: 'rgb(255, 255, 255)',
							borderWidth: 1
						}
					]
				}
			});
		}
	});

	// setInterval(() => {
	// 	$.ajax({
	// 		url: '/passports/get_count_passports_ajax',
	// 		type: 'POST',
	// 		cache: false,
	// 		dataType: 'json',
	// 		success: function(response, status, jqXHR) {
	// 			if (response.status === 'SUCCESS') {
	// 				$('#widget1').text(response.data);
	// 				console.log(response);
	// 			}
	// 			else {
	// 				console.log(response.message);
	// 			}
	// 		},
	// 		error: function(jqXHR, status, errorThrown ){
	// 			console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
	// 		}
	// 	});
	// }, 5000);

	// if (!JSON.parse(localStorage.getItem('news'))) {
	// 	toastr.options = {
	// 		"closeButton": true,
	// 		"debug": false,
	// 		"newestOnTop": true,
	// 		"progressBar": true,
	// 		"positionClass": "toast-top-right",
	// 		"preventDuplicates": false,
	// 		"onclick": null,
	// 		"showDuration": "300",
	// 		"hideDuration": "1000",
	// 		"timeOut": "5000",
	// 		"extendedTimeOut": "1000",
	// 		"showEasing": "swing",
	// 		"hideEasing": "linear",
	// 		"showMethod": "fadeIn",
	// 		"hideMethod": "fadeOut"
	// 	};
	// 	toastr["warning"]("14.04.2021 року додано можливість заборони редашувати дані випробувань.", "Новина");
		
	// 	setTimeout(() => {
	// 		toastr["warning"]("13.04.2021 року в протокол додано дані про сертифікат.", "Новина");
	// 		toastr["warning"]("12.04.2021 року додана можливість змінювати колір сайту.", "Новина");
	// 	}, 6000);

	// 	localStorage.setItem('news', true);
	// }
		
});

