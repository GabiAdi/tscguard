let questionNumber = 0;
let answerNumber = [];

function add_question() {
	console.log("test");

	let btn = document.getElementById("add_question_btn");
	let form = document.getElementById("test_form");
	
	let submit = document.getElementById("submitBtn");
	let div = document.createElement("div");
	div.id = "question_" + questionNumber;
	form.insertBefore(div, submit);
	form.insertBefore(document.createElement("br"), submit);

	let question = document.createElement("textarea");
	question.name = "questions["+ questionNumber +"][question]";
	question.type = "text";
	question.required = true;
	question.id = "question_text_"+questionNumber;

	let labelQuestion = document.createElement("label");
	labelQuestion.for = "question_text_"+questionNumber;
	labelQuestion.textContent = "Pitanje"+questionNumber;

	let answersDiv = document.createElement("div");
	answersDiv.id = "answers_" + questionNumber;
	answersDiv.classList.add("answersDiv");

	let newBtn = document.createElement("button");
	newBtn.id = "answer_btn_" + questionNumber;
	newBtn.onclick = function() {
		add_answer(this);	
	};
	newBtn.textContent = "Dodaj Odgovor";
	newBtn.type = "button";

	let labelHint = document.createElement("label");
	labelHint.for = "hint_text_"+questionNumber;
	labelHint.textContent = "Hint";
	
	let hint = document.createElement("textarea");
	hint.name = "questions["+ questionNumber +"][hint]";
	hint.type = "text";
	hint.required = true;
	hint.id = "hint_text_"+questionNumber;

	let labelPoints = document.createElement("label");
	labelPoints.for = "points_"+questionNumber;
	labelPoints.textContent = "Bodovi";
	
	let points = document.createElement("input");
	points.name = "questions[" + questionNumber + "][points]";
	points.type = "text";
	points.required = true;
	points.id = "points_"+questionNumber;

	answerNumber.push(0);

	let category = document.createElement("select");
	category.name = "questions[" + questionNumber + "][category]";
	category.required = true;
	
	let rawData = document.getElementById("categories").textContent;
	let categories = JSON.parse(rawData);	

	categories.categories.forEach(cat => {
		let option = document.createElement("option");
		option.value = cat.id;
		option.textContent = cat.name;
		category.append(option);
	});

	div.append(labelQuestion);
	div.append(document.createElement("br"));
	div.append(question);
	div.append(document.createElement("br"));
	div.append(labelHint);
	div.append(document.createElement("br"));
	div.append(hint);	
	div.append(document.createElement("br"));
	div.append(labelPoints);
	div.append(document.createElement("br"));
	div.append(points);
	div.append(document.createElement("br"));
	div.append(category);	
	div.append(document.createElement("br"));
	div.append(newBtn);
	div.append(document.createElement("br"));
	div.append(document.createElement("br"));
	div.append(answersDiv);

	questionNumber++;
}

function add_answer(button) {
	let id = parseInt(button.id.split("_")[2]);
	let answersDiv = document.getElementById("answers_" + id);

	let answer = document.createElement("textarea");
	answer.name = "questions[" + id + "][answers][" + answerNumber[id] + "][text]";
	answer.type = "text";
	answer.required = true;

	let answerLabel = document.createElement("label");
	answerLabel.textContent = "Odgovor";

	let explanation = document.createElement("input");
	explanation.name = "questions[" + id + "][answers][" + answerNumber[id] + "][explanation]";
	explanation.type = "text";
	explanation.required = true;

	let explanationLabel = document.createElement("label");
	explanationLabel.textContent = "Objasnjenje";
	
	let hidden = document.createElement("input");
	hidden.name = "questions[" + id + "][answers][" + answerNumber[id] + "][correct]";
	hidden.value = "off";	
	hidden.type = "hidden";
	
	let correct = document.createElement("input");
	correct.name = "questions[" + id + "][answers][" + answerNumber[id] + "][correct]";
	correct.value = "on";	
	correct.type = "checkbox";

	let correctLabel = document.createElement("label");
	correctLabel.textContent = "Tocno";
	
	let answerDiv = document.createElement("div");
	answerDiv.classList.add("answerDiv");
	
	//let div = document.getElementById("question_"+id); 
	
	answersDiv.append(answerDiv);
	answerDiv.append(answerLabel);
	answerDiv.append(answer);
	answerDiv.append(explanationLabel);
	answerDiv.append(explanation);
	answerDiv.append(hidden);
	answerDiv.append(correctLabel);
	answerDiv.append(correct);
	
	answerNumber[id]++;
}
