$(document).ready(function(){
	$(window).load(function(){
		$("#first_column").animate({height:83},1500);
		$("#second_column").animate({height:44},1500);
		$("#third_column").animate({height:160},1500);
		$("#fourth_column").animate({height:300},1500);
		$("#fifth_column").animate({height:80},1500);
	});
});

function one(num) {
		var ele = $('#one');
		var clr = null;
		var rand = 0;
		loop();
		function loop() {
			ele.html(rand += 1);
			while (rand == num) { return; }
			clr = setTimeout(loop, 7);
		}
}

function two(num) {
		var ele = $('#two');
		var clr = null;
		var rand = 0;
		loop();
		function loop() {
			ele.html(rand += 1);
			while (rand == num) { return; }
			clr = setTimeout(loop, 15);
		}
}

function three(num) {
		var ele = $('#three');
		var clr = null;
		var rand = 0;
		loop();
		function loop() {
			ele.html(rand += 2);
			while (rand == num) { return; }
			clr = setTimeout(loop, 7); 
		}
}

function four(num) {
		var ele = $('#four');
		var clr = null;
		var rand = 0;
		loop();
		function loop() {
			ele.html(rand += 7);
			while (rand == num) { return; }
			clr = setTimeout(loop, 15);
		}
}

function five(num) {
		var ele = $('#five');
		var clr = null;
		var rand = 0;
		loop();
		function loop() {
			ele.html(rand += 1);
			while (rand == num) { return; }
			clr = setTimeout(loop, 7);
		}
}
