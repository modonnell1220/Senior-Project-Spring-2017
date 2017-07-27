
function dynInput(rb) {
    if (document.getElementById('raadio').checked == true) {
        var box = document.getElementById('landlordBox');
        box.style.display = "block";
        var input = document.createElement("input");
        input.type = "text";
        input.className = "form-control";
        input.name = "cname";
        input.maxLength = "100";
        input.required = "true";
        var div = document.createElement("div");
        div.id = rb.name.id;
        div.innerHTML = "Company Name or Personal Name: ";
        div.appendChild(input);
        document.getElementById("insertinputs").appendChild(div);

        var input2 = document.createElement("input");
        input2.type = "number";
        input2.className = "form-control";
        input2.name = "keys";
        input2.maxLength = "5";
        input2.required = "true";
        var div2 = document.createElement("div");
        div2.id = rb.name.id;
        div2.innerHTML = "Keys Furnished: ";
        div2.appendChild(input2);
        document.getElementById("insertinputs2").appendChild(div2);

        var input3 = document.createElement("input");
        input3.type = "number";
        input3.className = "form-control";
        input3.name = "repKey";
        input3.maxLength = "5";
        input3.required = "true";
        var div3 = document.createElement("div");
        div3.id = rb.name.id;
        div3.innerHTML = "Replacement Key Fee: ";
        div3.appendChild(input3);
        document.getElementById("insertinputs3").appendChild(div3);

        var input4 = document.createElement("input");
        input4.type = "number";
        input4.className = "form-control";
        input4.name = "lateFee";
        input4.maxLength = "5";
        input4.required = "true";
        var div4 = document.createElement("div");
        div4.id = rb.name.id;
        div4.innerHTML = "Late Fee: ";
        div4.appendChild(input4);
        document.getElementById("insertinputs4").appendChild(div4);

        var input5 = document.createElement("input");
        input5.type = "number";
        input5.className = "form-control";
        input5.name = "checkFee";
        input5.maxLength = "5";
        input5.required = "true";
        var div5 = document.createElement("div");
        div5.id = rb.name.id;
        div5.innerHTML = "Check Fee: ";
        div5.appendChild(input5);
        document.getElementById("insertinputs5").appendChild(div5);

        var input6 = document.createElement("input");
        input6.type = "number";
        input6.className = "form-control";
        input6.name = "lateDays";
        input6.maxLength = "2";
        input6.required = "true";
        var div6 = document.createElement("div");
        div6.id = rb.name.id;
        div6.innerHTML = "Days before late fee charged: ";
        div6.appendChild(input6);
        document.getElementById("insertinputs6").appendChild(div6);
    }
    if (document.getElementById('raadio').checked == false) {
        var box = document.getElementById('landlordBox');
        box.style.display = "none";
        document.getElementById(rb.name.id).remove();
        document.getElementById(rb.name.id).remove();
        document.getElementById(rb.name.id).remove();
        document.getElementById(rb.name.id).remove();
        document.getElementById(rb.name.id).remove();
        document.getElementById(rb.name.id).remove();
    }
    if (document.getElementById('raadio2').checked == false) {
        document.getElementById(rb.name).remove();
        document.getElementById(rb.name).remove();
        document.getElementById(rb.name).remove();
        document.getElementById(rb.name).remove();
        document.getElementById(rb.name).remove();
        document.getElementById(rb.name).remove();
    }
}
