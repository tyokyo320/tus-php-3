function kaitouSeisei(item){
    // HTML要素 (要素ID = question)に、問題文(item["question"])を内挿
    document.getElementById("question").innerHTML = item["question"];
    // 選択肢配列の取得
    let choices = item["choices"];
    // HTML要素 (要素ID = choices) を取得
    let choice_area = document.getElementById("choices");

    // HTMLの選択肢領域 (choice_area) に選択肢要素を追加
    for (let c = 0; c < choices.length; c++) {
        choice_area.appendChild(sentakushi(c, choices[c]));
        // let e = sentakushi(c, choices[c]);
        // console.log(c, e);
        // choice_area.appendChild(e);
    }
}

function sentakushi(c, choice){
    let input = document.createElement("input");
    input.required = true;
    input.checked = c === 0;
    input.type = "radio";
    input.name = "choices";
    input.value = c + 1;

    let label = document.createElement("label");
    label.innerHTML = choice;
    
    let div = document.createElement("div");
    div.appendChild(input);
    div.appendChild(label);

    return div;
}
