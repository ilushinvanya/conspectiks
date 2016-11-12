function formatDate(date) {
	var diff = new Date() - date;

	if (diff < 1000) {
		return 'только что';
	}

	var sec = Math.floor(diff / 1000); 
	if (sec < 60) {
		return sec + ' сек назад';
	}

	var min = Math.floor(diff / 60000); 
	if (min < 60) {
		return min + ' мин назад';
	}

	var hour = Math.floor(diff / 3600000); 
	if (hour < 24) {
		return hour + ' час назад';
	}

	var days = Math.floor(diff / 86400000);
	if (days < 30) {
		return days + ' дней назад';
	}

	
	var d = date;
	d = [
	d.getDate(),
	nameMonth(d.getMonth()),
	d.getFullYear(),
	d.getHours(),
	d.getMinutes()
	];

	return d.slice(0, 3).join(' ');
}

function nameMonth(num){
	if(num == 0) return 'января';
	else if(num == 1) return 'февраля';
	else if(num == 2) return 'марта';
	else if(num == 3) return 'апреля';
	else if(num == 4) return 'мая';
	else if(num == 5) return 'июня';
	else if(num == 6) return 'июля';
	else if(num == 7) return 'августа';
	else if(num == 8) return 'сетября';
	else if(num == 9) return 'октября';
	else if(num == 10) return 'ноября';
	else if(num == 11) return 'декабря';
}


function funbg(){
	var array = ['http://static.tumblr.com/ubmlcww/LfQloqnhc/stars.gif',
				'http://www.hotwallpapersforfree.com/images/preview/Seamless-Pattern-Bananas-Green-Background-98206.jpg',
				'https://avatanplus.com/files/resources/small/579cb12247b091563c13edf6.jpg',
				'http://media.istockphoto.com/vectors/seamless-pattern-strawberry-vector-id467263718?s=235x235',
				'http://www.abbiecranegraphics.ca/wp-content/uploads/2015/03/cc90a0107e9ffecfb64673405361bc6c.jpg',
				''];


	var numb = Math.floor(Math.random() * (array.length - 0)) + 0;
	var targetBg = array[numb];
	return targetBg;
}

$(document).ready(function(){
	$('body').attr('style', 'background-image: url( '+funbg()+');');

	$maintable = $('#table').DataTable({
		"language": {
			"url": "js/plugins/ru.lang"
		},
		searching: true,
		"paging":   false,
		"ordering": true,
		"info":     false,
		"initComplete": function () {
			var api = this.api();
			api.$('td').click(function () {
				api.search($(this).text()).draw();
			});
		}
	});

	if(typeof $hiddenColumn != 'undefined'){
		for(i=0;i<$hiddenColumn.length;i++){
			var column = $maintable.column( $hiddenColumn[i] );
			column.visible( ! column.visible() );
		}
	};


	if(typeof $orderColumn != 'undefined') {
		$maintable.order($orderColumn).draw();
	}

	$('.js_date').each(function(){
		$(this).attr('data-order', (new Date($(this).text()).getTime()));
		$(this).text(formatDate(new Date($(this).text())));
	});
});