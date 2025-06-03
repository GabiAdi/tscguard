const form = document.getElementById("form");
let divs = form.querySelectorAll(":scope > div");

let question_number = divs.length;
let answer_numbers = [];

for(let i=0; i<divs.length; i++) {
	div = divs[i];
	let answer_div = div.querySelectorAll(".answersDiv")[0];
	answer_numbers[i] = answer_div.querySelectorAll(".answerDiv").length;
}

//console.log(question_number);
//console.log(answer_numbers);

function add_question() {
		
}

function remove_question() {

} 
