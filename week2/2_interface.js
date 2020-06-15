function kaitouSeisei(item){
    // HTML要素 (要素ID = question)に、問題文(item["question"])を内挿
    document.getElementById("question").innerHTML = item["question"];
    // 選択肢配列の取得
    let choices = item["choices"];
    // HTML要素 (要素ID = choices) を取得
    let choice_area = document.getElementById("choices");

    // HTMLの選択肢領域 (choice_area) に選択肢要素を追加
    for (let c = 0; c < choices.length; c++) {
        choice_area.appendChild(sentakushi(c + 1, choices[c], 'choices'));
        
        // let e = sentakushi(c, choices[c]);
        // console.log(c, e);
        // choice_area.appendChild(e);
    }

    // 分からない選択肢の追加
    choice_area.appendChild(sentakushi("分からない", "分からない", 'choices'));
}

function questionnaire(item){
    let questionnaire = item["questionnaire"];
    // HTML要素 (要素ID = questionnaire) を取得
    let questionnaire_area = document.getElementById("questionnaire");

    // HTMLの選択肢領域 (questionnaire_area) に選択肢要素を追加
    for (let c = 0; c < questionnaire.length; c++) {
        questionnaire_area.appendChild(sentakushi(c + 1, questionnaire[c], 'questionnaire'));
    }
}

function sentakushi(c, choice, name){
    let input = document.createElement("input");
    input.required = true;
    input.checked = c === 1;
    input.type = "radio";
    input.name = name;
    input.value = c;

    let label = document.createElement("label");
    label.innerHTML = choice;
    
    let div = document.createElement("div");
    div.appendChild(input);
    div.appendChild(label);

    return div;
}
