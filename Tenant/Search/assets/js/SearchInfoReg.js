/**
 * Created by clinton on 4/11/17.
 */

function GetSelectedItem(){
    var option = document.getElementById("locale").value;
}
function StayOnSelectedItem(){
    var element = document.getElementById("locale");
    var value = element.options[element.selectedIndex].value;
}




/*
 function hi() {
 //alert("hello");
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

function  reqInfo(request) {
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxPOSTTestRequest = new XMLHttpRequest();
    } catch (e) {
        // Something went wrong
        //alert("Your browser broke!");
    }
    ajaxPOSTTestRequest.onreadystatechange = ajaxCalled_POSTTest;
    var url = "barebones.php";

    var params =request;
    ////alert("1 "+params);
    ajaxPOSTTestRequest.open("POST", url, true);
    ajaxPOSTTestRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxPOSTTestRequest.send(params);
    function ajaxCalled_POSTTest() {
        if (ajaxPOSTTestRequest.readyState === 4) {
            ////alert(ajaxPOSTTestRequest.responseText);
            parserEmpty(ajaxPOSTTestRequest.responseText);
        } else{
            return("error");
        }
    }
}


function defaultimage(){
    this.src = "http://rentingfromme.com/Landlord/UserPics/error.jpg";
}


function  parserEmpty(table) {
    //alert(table);
    var options = [" county", " zip", " monthly rent", " bed", " bath", " error"];
    var RowNum = (table.match(/<tr>/g) || []).length;
    document.getElementById("headerSubTitle").innerText = "Showing "+RowNum+" properties";
    ////alert("Showing "+RowNum+" properties");
    var ColNumTotal = (table.match(/<td>/g) || []).length;
    var colNum = ColNumTotal/RowNum;
    colNum-=1;
    table = table.replace("<tr></tr>"," ").trim();
    ////alert(RowNum  + "    |||    " + colNum);
    var row = document.createElement('div');
    row.className = "row flex-wrap";

    for(i=0; i<RowNum; i++){


        //row.style.display = " inline-block";

        var col = document.createElement('div');
        col.className ="property-card-container card-tile col-lg-3 col-md-4 col-sm-6 col-xs-12 ";
        var btn = document.createElement('button');
        btn.className = "application-button";
        btn.appendChild(document.createTextNode("apply to property"));
        btn.addEventListener("click",function() {
            //alert("hello " + this.id);
            var url = "apply_property.php";
            var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="PropertyID" value="' + this.id + '" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        });

        var img;
        if(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpeg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("png")) {
            img = document.createElement('IMG');
            img.src = "http://rentingfromme.com/Landlord/UserPics/" + table.substring(table.indexOf("<td>") + 4, table.indexOf("</td>"));
            //alert(img.src);
            img.addEventListener("error", defaultimage);
            img.setAttribute("width", 258);
            img.setAttribute("height", 180);
            col.appendChild(img);

        }else{
            img = document.createElement('IMG');
            img.src = "http://rentingfromme.com/Landlord/UserPics/error.jpg";
            img.addEventListener("error", defaultimage);
            img.setAttribute("width", 258);
            img.setAttribute("height", 180);
            col.appendChild(img);
        }
        table = table.substr(table.indexOf("</td>")+5).trim();
        for(j=0;j<(colNum-1);j++){
            var text = document.createTextNode(options[j] + ": "+ table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")));
            table = table.substr(table.indexOf("</td>")+5);
            var p = document.createElement('p');
            //p.className ="label";
            //alert(text.nodeValue);
            p.appendChild(text);
            col.appendChild(p);
            if(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("jpeg") ||table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")).includes("png")) {break;}
        }
        btn.id = table.substring(table.indexOf("<td>")+4,table.indexOf("</td>"));
        table = table.substr(table.indexOf("</td>")+5);
        col.appendChild(btn);
        row.appendChild(col);
        document.getElementById("contentContainer").appendChild(row);

    }

    ////alert("done");

}

function listview(){
    if(document.getElementById("contentContainer").childElementCount <1)
        return;
    if(document.getElementById("contentContainer").firstElementChild.className==="row"){
        return;
    }else{

        if(document.getElementById("contentContainer").firstElementChild.className==="row flex-wrap"){
            document.getElementById("contentContainer").firstElementChild.className = "row";
            for(i=0;i<document.getElementById("contentContainer").firstElementChild.childElementCount;i++) {
                document.getElementById("contentContainer").firstElementChild.childNodes[i].className = "property-card-container card-list col-md-12 flex";

            }
        }
    }

}




function cardview(){
    if(document.getElementById("contentContainer").childElementCount <1)
        return;
    if(document.getElementById("contentContainer").firstElementChild.className==="row flex-wrap"){
        return;
    }else{
        if(document.getElementById("contentContainer").firstElementChild.className==="row"){
            document.getElementById("contentContainer").firstElementChild.className = "row flex-wrap";
            for(i=0;i<document.getElementById("contentContainer").firstElementChild.childElementCount;i++) {
                document.getElementById("contentContainer").firstElementChild.childNodes[i].className ="property-card-container card-tile col-lg-3 col-md-4 col-sm-6 col-xs-12 ";
            }
        }
    }
}


/*
 tile
 <div class="row flex-wrap">
 <div class="property-card-container col-lg-3 col-md-4 col-sm-6 col-xs-12 ">
 <!--    ECHO PROPERTY INFO HERE-->
 </div>
 </div>
 */

/*
 list
 <div class="row">
 <div class="property-card-container col-md-12 flex">
 <!--    ECHO PROPERTY INFO HERE-->
 </div>
 </div>
 */

function  parser(table) {
    ////alert(table);

    var RowNum = (table.match(/<tr>/g) || []).length;
    var ColNumTotal = (table.match(/<td>/g) || []).length;
    var colNum = ColNumTotal/RowNum;
    table = table.replace("<tr></tr>"," ").trim();
    ////alert(RowNum  + "    |||    " + colNum);
    for(i=0; i<RowNum; i++){
        var row = document.createElement('tr');
        for(j=0;j<colNum;j++){
            var col = document.createElement('td');
            var text = document.createTextNode(table.substring(table.indexOf("<td>")+4,table.indexOf("</td>")));
            table = table.substr(table.indexOf("</td>")+5).trim();
            col.appendChild(text);
            row.appendChild(col);
        }
        elem.appendChild(row);
    }
    document.getElementById("output").appendChild(elem);
    //alert("done");

}




reqInfo("Catcher=select FileName,PCounty,PZip,MonthlyRent,Bed,Bath,PropertyID from Property where tenant is null");
