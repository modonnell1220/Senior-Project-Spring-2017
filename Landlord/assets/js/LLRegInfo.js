/**
 * Created by clinton on 4/11/17.
 */
/*
function hi() {
    ////alert("hello");
}


function Myfun(){
    var catchName ="Catcher";
    var calling = document.getElementById("callname").value;
    var type = document.getElementById("reqType").value;
    var table = document.getElementById('math').value;
    var Othertype = document.getElementById("othertype").value;
}

function loadrequest() {

    if(document.getElementById("storage").innerText ===null)
        return;
    var temp = document.getElementById("storage").innerText;
    document.getElementById("storage").innerText = "";
    reqInfo(temp);
}
*/
function request1(llname){
    reqInfo("Catcher=select FileName,CASE WHEN Property.tenant IS NULL THEN 'True' ELSE 'False' END, DATEDIFF(current_date, NextDueDate) as 'date', concat(PAddress, ', ', PCity,', ', PState,' ', PZip),Property.PropertyID from Property,MoneyTransaction where Owner = \'"+ llname+"\' ORDER BY 'date' asc");
//
}

function  reqInfo(request) {
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxPOSTTestRequest = new XMLHttpRequest();
    } catch (e) {
        // Something went wrong
        ////alert("Your browser broke!");
    }
    ajaxPOSTTestRequest.onreadystatechange = ajaxCalled_POSTTest;
    var url = "barebones.php";

    var params =request;
    //////alert("1 "+params);
    ajaxPOSTTestRequest.open("POST", url, true);
    ajaxPOSTTestRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxPOSTTestRequest.send(params);
    function ajaxCalled_POSTTest() {
        if (ajaxPOSTTestRequest.readyState === 4) {
            //document.getElementById("output").innerText ="";
            parserlord(ajaxPOSTTestRequest.responseText);
            //parser(ajaxPOSTTestRequest.responseText);
        } else{
            return("error");
        }
    }
}



function defaultimage(){
    this.src = "http://rentingfromme.com/Landlord/UserPics/error.jpg";
}


function  parserlord(table) {
    //////alert(table);
    var options = [" county", " zip", " rent", " bed", " bath", " error"];
    var RowNum = (table.match(/<tr>/g) || []).length;
    //document.getElementById("headerSubTitle").innerText = "Showing "+ RowNum+" properties";
    var ColNumTotal = (table.match(/<td>/g) || []).length;
    var colNum = ColNumTotal/RowNum;
    colNum-=3;
    table = table.replace("<tr></tr>"," ").trim();
    //////alert(RowNum  + "    |||    " + colNum);
    var temp =0;

    var row = document.createElement('div');
    row.className = "row flex-wrap";


    for(i=0; i<RowNum; i++){





        var col = document.createElement('div');
        col.className ="property-card-container card-tile col-lg-3 col-md-4 col-sm-6 col-xs-12 ";
        //col.className ="property-card-container card-tile";
        var img;
        var p;// p changed to address
        var address;
        var text;
        //////alert("| "+ table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"))+ " |");
        if(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpeg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("png")) {
            img = document.createElement('IMG');
            img.src = "http://rentingfromme.com/Landlord/UserPics/" + table.substring(table.indexOf("<td>") + 4, table.indexOf("</td>"));
        }else{
            img = document.createElement('IMG');
            img.src = "http://rentingfromme.com/Landlord/UserPics/error.jpg";
        }
        img.addEventListener("error", defaultimage);
        img.setAttribute("width", 258);
        img.setAttribute("height", 180);
        img.addEventListener("click",function() {
            //////alert("hello " + this.id);
            var url = "property.php";
            var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="PropertyID" value="' + this.id + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        });
        col.appendChild(img);
        table = table.substr(table.indexOf("</td>")+5).trim();

        //////alert("| "+ table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"))+ " |");

        if(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("True")){
            text = document.createTextNode("Property is ");
            var p2 = document.createElement('p');
            p2.appendChild(text);
            text = document.createTextNode("Vacant");
            p = document.createElement('label');
            p.className ="label label-default";
            p.appendChild(text);
            p2.appendChild(p);
            p = p2;
            table = table.substr(table.indexOf("</td>")+5).trim();
            table = table.substr(table.indexOf("</td>")+5).trim();
        }else{
            var temp;
            text = document.createTextNode("Property is Active and ");
            var p2 = document.createElement('p');
            p2.appendChild(text);
            p = document.createElement('label');
            p.className ="label label";

            table = table.substr(table.indexOf("</td>")+5).trim();
            //////alert("| "+ table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"))+ " |");
            if(parseInt(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")))>5){
            text =document.createTextNode("Good standing");
            p.className ="label label-success";
            p.appendChild(text);

            }else if(parseInt(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")))>0){
                text =document.createTextNode("Okay standing");
                p.className ="label label-success";
                p.appendChild(text);
            }else{
                text =document.createTextNode("Bad standing");
                p.className ="label label-danger";
                p.appendChild(text);

            }
            p2.appendChild(p);
            p =p2;
            table = table.substr(table.indexOf("</td>")+5).trim();
        }
        text = document.createTextNode(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")));
        address = document.createElement('p');
        address.appendChild(text);
        if(alreadyadd(text.nodeValue)) {
            table = table.substr(table.indexOf("</td>")+5);
            table = table.substr(table.indexOf("</td>")+5);
            continue;
        }else{
            temp++;
        }
        address.className = text.nodeValue;
        table = table.substr(table.indexOf("</td>")+5); // delete address

        img.id = table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"));
        table = table.substr(table.indexOf("</td>")+5); // delete id
        col.appendChild(address);
        col.appendChild(p);
        //insertbutton(col);

        //////alert(table.substr(table.indexOf("</td>")+5));
        row.appendChild(col);
        document.getElementById("contentContainer").appendChild(row);
        //////alert(table);

    }
    document.getElementById("headerSubTitle").innerText = "Showing "+ temp+" properties";
    //////alert("done");

}

function alreadyadd(addr){
    //////alert(addr.toString());
    var temp = document.getElementsByClassName(addr.toString());
    if(temp.length > 0){
        return true;
    }
    return false;

}

function insertbutton(location) {
    var butt1 = document.createElement('BUTTON');
    var butt2 = document.createElement('BUTTON');
    var t1 = document.createTextNode("edit");
    var t2 = document.createTextNode("delete");

    butt1.onclick = function() {edit(this.id)};
    butt2.onclick = function() {del(this.id)};

    butt1.appendChild(t1);
    butt2.appendChild(t2);

    location.appendChild(butt1);
    location.appendChild(butt2);

}


function edit(name){

    ////alert("edit");
}


function  del(name) {
    ////alert("delete");
}



function  parser(table) {
    ////alert(table);

    var RowNum = (table.match(/<tr>/g) || []).length;
    //document.getElementById("headerSubTitle").innerText = "Showing "+RowNum+" properties";
    var ColNumTotal = (table.match(/<td>/g) || []).length;
    var colNum = ColNumTotal/RowNum;
    table = table.replace("<tr></tr>"," ").trim();
    var elem = document.createElement('table');
    //////alert(RowNum  + "    |||    " + colNum);
    for(i=0; i<RowNum; i++){
        var row = document.createElement('tr');
        for(j=0;j<colNum;j++){
            var col = document.createElement('td');
            var text = document.createTextNode("| "+ table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"))+ " |");
            table = table.substr(table.indexOf("</td>")+5).trim();
            col.appendChild(text);
            row.appendChild(col);
        }
        elem.appendChild(row);
    }
    document.getElementById("contentContainer").appendChild(elem);
    ////alert("done");

}

function listview(){
    ////alert("list " + document.getElementById("contentContainer").childElementCount );

    if(document.getElementById("contentContainer").childElementCount <1)
        return;
    if(document.getElementById("contentContainer").lastElementChild.className==="row"){
        ////alert("nothing to do");
        return;
    }else{
        ////alert(document.getElementById("contentContainer").lastElementChild.className);


        if(document.getElementById("contentContainer").lastElementChild.className==="row flex-wrap"){

            ////alert(document.getElementById("contentContainer").lastElementChild.className);

            document.getElementById("contentContainer").lastElementChild.className = "row";
            //////alert("that duck " +document.getElementById("contentContainer").firstElementChild.className +" |");
            //////alert("that duck " +document.getElementById("contentContainer").firstElementChild.childElementCount +" |");
            for(i=0;i<document.getElementById("contentContainer").lastElementChild.childElementCount;i++) {
               //alert("loop");
                document.getElementById("contentContainer").lastElementChild.childNodes[i].className = "property-card-container card-list col-md-12 flex";

            }


        }

        ////alert("wtf");
    }

}




function cardview(){
    ////alert("card " + document.getElementById("contentContainer").childElementCount );

    if(document.getElementById("contentContainer").childElementCount <1)
        return;

    if(document.getElementById("contentContainer").lastElementChild.className==="row flex-wrap"){
        ////alert("nothing to do");
        return;
    }else{

        if(document.getElementById("contentContainer").lastElementChild.className==="row"){
            document.getElementById("contentContainer").lastElementChild.className = "row flex-wrap";
            ////alert("break");
            for(i=0;i<document.getElementById("contentContainer").lastElementChild.childElementCount;i++) {
                //alert("loop");
                document.getElementById("contentContainer").lastElementChild.childNodes[i].className ="property-card-container card-tile col-lg-3 col-md-4 col-sm-6 col-xs-12";
            }

        }
        ////alert("wtf");
    }
}
/*
function listview(){
    ////alert("list " + document.getElementById("contentContainer").lastChild.className);

    if(document.getElementById("contentContainer").lastElementChild.className==="row"){
        //////alert("nothing to do");
        return;
    }
    else{
        while(document.getElementById("contentContainer").getElementsByClassName("row flex-wrap").length >0) {
            var short = document.getElementById("contentContainer").getElementsByClassName("row flex-wrap")[0];
            short.className = "row";
            short.firstElementChild.className ="property-card-container col-md-12 flex";
            if(document.getElementById("contentContainer").getElementsByClassName("row flex-wrap").length ===0)
                break;
        }

    }


}

function cardview(){
    ////alert("card " + document.getElementById("contentContainer").lastElementChild.className);


    if(document.getElementById("contentContainer").lastElementChild.className==="row flex-wrap"){
        ////alert("nothing to do");
        return;
    }else{

        var x = document.getElementById("contentContainer").querySelectorAll(".row");
        var i;
        for (i = 0; i < x.length; i++) {
            x[i].className = "row flex-wrap";
            x[i].firstElementChild.className ="property-card-container col-lg-3 col-md-4 col-sm-6 col-xs-12 ";;
        }

    }

}
*/

