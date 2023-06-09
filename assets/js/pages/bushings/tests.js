$(document).ready(function() {
	$('#modalTest').on('show.bs.modal', function (event) {
		$.ajax({
			url: '/tests/test_ajax',
			data: {'test_id': event.relatedTarget.dataset.id},
			method: "POST",
			success: function(data) {
				const d = data.data;
				const html = `
					<dl class="row">
						<dt class="col-5">ID</dt>
						<dd class="col-7">${d.id ? d.id : '&nbsp;'}</dd>
						<dt class="col-5">Підрозділ</dt>
						<dd class="col-7">${d.filial ? d.filial : '&nbsp;'}</dd>
						<dt class="col-5">Підстанція</dt>
						<dd class="col-7">${d.stantion ? d.stantion : '&nbsp;'}</dd>
						<dt class="col-5">Диспетчерстке найменування</dt>
						<dd class="col-7">${d.disp ? d.disp : '&nbsp;'}</dd>
						<dt class="col-5">Фаза</dt>
						<dd class="col-7">${d.phase ? d.phase : '&nbsp;'}</dd>
						<dt class="col-5">Тип вимірювань</dt>
						<dd class="col-7">${d.type_test ? d.type_test : '&nbsp;'}</dd>
						<dt class="col-5">Дата вимірювань</dt>
						<dd class="col-7">${d.test_date_format ? d.test_date_format : '&nbsp;'}</dd>
						<dt class="col-5">Температура повітря, &deg;C</dt>
						<dd class="col-7">${d.t_okr ? d.t_okr : '&nbsp;'}</dd>
						<dt class="col-5">ТС1, &deg;C</dt>
						<dd class="col-7">${d.t_vsm1 ? d.t_vsm1 : '&nbsp;'}</dd>
						<dt class="col-5">ТС2, &deg;C</dt>
						<dd class="col-7">${d.t_vsm2 ? d.t_vsm2 : '&nbsp;'}</dd>
						<dt class="col-5">Температура вводу, &deg;C</dt>
						<dd class="col-7">${d.t_bushing ? d.t_bushing : '&nbsp;'}</dd>
						<dt class="col-5">Погода</dt>
						<dd class="col-7">${d.weather ? d.weather : '&nbsp;'}</dd>
						<dt class="col-5">Додаткова інформація про вимірювання</dt>
						<dd class="col-7">${d.more ? d.more : '&nbsp;'}</dd>
						<dt class="col-5">R1, МОм</dt>
						<dd class="col-7">${d.r1 ? d.r1 : '&nbsp;'}</dd>
						<dt class="col-5">R3, МОм</dt>
						<dd class="col-7">${d.r3 ? d.r3 : '&nbsp;'}</dd>
						<dt class="col-5">Tg&delta;1, %</dt>
						<dd class="col-7">${d.tg1 ? d.tg1 : '&nbsp;'}</dd>
						<dt class="col-5">Tg&delta;3, %</dt>
						<dd class="col-7">${d.tg3 ? d.tg3 : '&nbsp;'}</dd>
						<dt class="col-5">C1, пФ</dt>
						<dd class="col-7">${d.capacity1 ? d.capacity1 : '&nbsp;'}</dd>
						<dt class="col-5">С3, пФ</dt>
						<dd class="col-7">${d.capacity3 ? d.capacity3 : '&nbsp;'}</dd>
						<dt class="col-5">Прилади для вимірювань</dt>
						<dd class="col-7">${d.device ? d.device : '&nbsp;'}</dd>
						<dt class="col-5">Керівник робіт</dt>
						<dd class="col-7">${d.tests_conducted ? d.tests_conducted : '&nbsp;'}</dd>
						<dt class="col-5">Висновок</dt>
						<dd class="col-7">${d.conclusion ? d.conclusion : '&nbsp;'}</dd>

					</dl>
				`;
				$('#modalTest .modal-body').html(html);
			}
		})
	});

	$('#modalTest').on('hidden.bs.modal', function (event) {
		$(this).find('.modal-body').html('');
	});

	$.ajax({
		url: '/tests/tests_section_c1_ajax',
		data: {'passport_id': location.pathname.split('/', 4)[3]},
		method: "POST",
		success: function(json) {
			const d = json.data;		
			const labelsChart = [];
			const dataTg1 = [];
			const dataCapacity1 = [];
			d.forEach(function(item, i, array) {
				labelsChart.push(item.test_date_format);
				dataTg1.push(item.tg1);
				dataCapacity1.push(item.capacity1);	
			});
			var ctx = document.getElementById('tg1').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labelsChart,
					datasets: [
						{
							label: 'Tg1 , %',
							backgroundColor: 'rgb(0, 0, 0, 0)',
							borderColor: 'rgb(30, 14, 255)',
							data: dataTg1,
							lineTension: 0
						}
					]
				}
			});

			var ctx = document.getElementById('capacity1').getContext('2d');
			var chart = new Chart(ctx, {
				type: 'line',
				data: {
					labels: labelsChart,
					datasets: [
						{
							label: 'Ємність С1, пФ',
							backgroundColor: 'rgb(0, 0, 0, 0)',
							borderColor: 'rgb(30, 144, 255)',
							data: dataCapacity1,
							lineTension: 0
						}
					]
				}
			});
		}
	});

	if ($('#message')) {
		setTimeout(() => $('#message').slideUp(1000), 1000);	
	}
	
});
