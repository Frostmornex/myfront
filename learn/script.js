var popup = document.querySelector('.video-popup');
var iframeVideo = document.querySelector('.video-popup_iframe');
var innerVideo = document.querySelector('.video-popup_inner');

var btnOpen = document.querySelector('openVideo');
var btnClose = document.querySelector('closeVideo');

var openPopup = function (argument) {
	var link = this.getAttribute('date-link');
	var settings = '?autoplay=0&rel=0&enablejsapi=1&playerapiid=ytplayer';
	var id = \w+$/i.exec(link)[0];

	iframeVideo.setAttribute('src', 'https://www.youtube.com/embed/' + id + settings);

	popup.style.display = 'block';

	var width = innerVideo.offsetWidth;

	console.log(width);

	innerVideo.style.height = widht * 9/ 16 + 'px';
};
var closePopup = function (argument) {
		iframeVideo.setAttribute('src', '');
	popup.style.display = 'none';

};

btnOpen.addEventListener('click', openPopup);
btnClose.addEventListener('click', closePopup);


/* домашная работа

function myFirstApp(name,age) {

	alert("Привет, меня зовут " + name + "! И это моя первая программа!");	

	function showSkills() {
		let skills = [],
		questions1 = ["Какими навыками ты обладаешь?"]
	    let exp = []
	    questions2 = ["Сколько лет опыта?"]

		for (let i = 0; i < slills.length; i++) {
			skills[i] = prompt(questions1[i]);
			document.write("Я владею " + skills + "! ");
		for (let e = 0; e < exp.length; e++){
			exp[e] = prompt(questions2[e]);
			document.write("Стаж опыта "+ exp);
		}
		}
	}

	showSlills();

	function checkAge() {
		if (age >= 18) {
			alert ("Вы можете войти!")
		} else {
			alert ("Рановато тебе еще")
		}
	}

	function calcPow(num) {
		console.log(num*num)
	}
	calcPow(4)
}
myFirstApp("Denis", 25);

//

function calc(a,b) {
	console.log(a + b)
};

calc(4,5);
calc(5,5);
calc(5,15);

 function humanSayHello(obj) {
	document.write("Hello " + obj + "! ")
}

humanSayHello("Ivan");
humanSayHello("Anna");
humanSayHello("Egor");

let age = prompt("Сколько Вам лет?");

	if (age >= 18) {
	alert("Вы можете войти!")
}
	else {
		alert("Рановато еще!")
	}


	let answers = [],
	questions = [
	"Как ваше имя?",
	"Как ваша фамилия?",
	"Сколько вам лет?"
	];



for (let i = 0; i < questions.length; i++) {
	answers[i] = prompt(questions[i])
}
document.write(answers);


let number = 5;

// console.log("Hello world");

// alert("Вход воспрещён!")

// let answer = confirm("Есть ли вам 18 лет?");
let answer = prompt("Есть ли вам 18 лет?");

console.log(answer);*/