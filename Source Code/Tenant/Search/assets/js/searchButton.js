/**
 * Created by clinton on 4/14/17.
 */


function Get(){
    var option = document.getElementById("fun").value;
}

function Stay(elm){
    var element = document.getElementById(elm);
    var value = element.options[element.selectedIndex].value;
    return value;
}

function hi() {
    //alert("hi");
}

function del_old() {
    var element = document.getElementById("insertlocation");
    element = element.parentNode;
    var i =0;
    var j =0;
    while(element.childNodes[i].id != "insertlocation" ){
        ////alert(element.childNodes[i].id);
        i++;
        //element.remove(element.childNodes[2]);
    }
    while(element.childNodes[j].id != "fun"){
     j++
    }
    j++;
    i--;

    for(var k=j,x=(j-i);x<i;x++){
        if(element.childNodes[k].id =="insertlocation")
            break;
        element.removeChild(element.childNodes[k]);
    }
}

function changeName(){
    var element = document.getElementById("fun");
    var value = element.options[element.selectedIndex].value;
    element.className = value;
    changeDisplay(element.selectedIndex);
}
//
function  changeDisplay(indexNum) {
    del_old();
    switch(indexNum){
        case 1:
            country();
            break;
        case 2:
            zip();
            break;
        case 3:
            rent_rate();
            break;
        case 4:
            bed();
            break;
        case 5:
            bath();
            break;
        case 0:
            Blank();
            break;
        default:
            //alert("you broke the code!");

    }
    ////alert("words");

    /*
     case 6:
     Added_search();
     break;
     */

}
function run(){
    document.getElementById("headerSubTitle").innerText = "Showing "+0+" properties";
    //alert("sup!");
    clearPerviousSearch();

    //alert("fuck");
    var text = document.getElementById("uniquenametext").value;
    var attribute = capitalizeFirstLetter(Stay("fun"));
    var attrinumber = document.getElementById("fun").selectedIndex;
    //alert(attrinumber);
    if(attrinumber <=2) {
        attribute = "P" + attribute;
        if(text.trim() !=="") {
            var command = ("Catcher=select FileName,PCounty,PZip,MonthlyRent,Bed,Bath,PropertyID from Property where tenant IS NULL and " + attribute + " " + Stay("sel") + " '" + text + "' ");
        }else{
            var command = ("Catcher=select FileName,PCounty,PZip,MonthlyRent,Bed,Bath,PropertyID from Property where tenant IS NULL");
        }
    }else{
        var command = ("Catcher=select FileName,PCounty,PZip,MonthlyRent,Bed,Bath,PropertyID from Property where tenant IS NULL and " + attribute + " " + Stay("sel") + " " + text + " ");
    }

    //alert(command);
    reqInfo(command);
}

function clearPerviousSearch() {
    //alert("2");
    listview();
    //alert("3");
    for(i=0;i<=document.getElementById("contentContainer").childElementCount;i++) {
    //alert(i);
        if(document.getElementById("contentContainer").childNodes[i].className==="row"){
            //alert(i);
            document.getElementById("contentContainer").childNodes[i].remove(document.getElementById("contentContainer").childNodes[i]);
            i=0;
        }
    }
}


function country() {

    var element = document.getElementById("sendReg");
    var select = document.createElement('SELECT');
    select = addequals(select);
    select.id = "sel";
    element.insertBefore(select,element.childNodes[2]);
}

function zip() {
    var element = document.getElementById("sendReg");
    var select = document.createElement('SELECT');
    select = addequals(select);
    select.id = "sel";
    element.insertBefore(select,element.childNodes[2]);
}

function rent_rate() {
    var element = document.getElementById("sendReg");
    var select = document.createElement('SELECT');
    select = addcomp(select);
    select.id = "sel";
    element.insertBefore(select,element.childNodes[2]);
}

function bed() {
    var element = document.getElementById("sendReg");
    var select = document.createElement('SELECT');
    select = addcomp(select);
    select.id = "sel";
    element.insertBefore(select,element.childNodes[2]);

}
function bath() {
    var element = document.getElementById("sendReg");
    var select = document.createElement('SELECT');
    select = addcomp(select);
    select.id = "sel";
    element.insertBefore(select,element.childNodes[2]);
}
function addcomp(sel) {// testing only
    var option = document.createElement("option");
    option.text = "=";
    sel.add(option);
    option = document.createElement("option");
    option.text = "!=";
    sel.add(option);
    option = document.createElement("option");
    option.text = "<";
    sel.add(option);
    option = document.createElement("option");
    option.text = "<=";
    sel.add(option);
    option = document.createElement("option");
    option.text = ">=";
    sel.add(option);
    option = document.createElement("option");
    option.text = ">";
    sel.add(option);

    return sel;
}

function addequals(sel) {
    var option = document.createElement("option");
    option.text = "=";
    sel.add(option);
    return sel;
}

/*
function Added_search(){
    var element = document.getElementById("sendReg");
    var but = document.createElement('button');
    but.addEventListener("click", function() {remove();});
    but.appendChild(document.createTextNode("delete search"));
    var select = document.createElement('SELECT');
    select = addsearchs(select);
    select.id = "sel";
    element.insertBefore(but,element.childNodes[2]);
    element.insertBefore(select,element.childNodes[3]);

}

function addTo() {

    var what = Stay("fun");
    var cmp = Stay("sel");
    if(cmp ==="select one") {
        //alert("dum");
        return;
    }
    var some= Stay("sel2");
    var text = document.getElementById("change").value ;
    if(document.getElementById("added").innerText.length === 0) {
        if(some ===""){
            document.getElementById("added").innerText = what+" "+ cmp + " '"+text+"' ";
        }else{
            document.getElementById("added").innerText = what+" "+some + " "+ cmp + " '"+text+"' ";
        }

    }else{
        if(some ===""){
            document.getElementById("added").innerText = what+" "+ cmp + " '"+text + "', "+document.getElementById("added").innerText;
        }else{
            document.getElementById("added").innerText = what+" "+some + " "+ cmp + " '"+text + "', "+document.getElementById("added").innerText;
        }
    }

    resetSelectElement("fun");
}
 */
function resetSelectElement(ID) {
    var selectElement = document.getElementById(ID);
    var options = selectElement.options;

    // Look for a default selected option
    for (var i=0, iLen=options.length; i<iLen; i++) {

        if (options[i].defaultSelected) {
            selectElement.selectedIndex = i;
            return;
        }
    }

    // If no option is the default, select first or none as appropriate
    selectElement.selectedIndex = 0; // or -1 for no option selected
    changeName();
}


function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

/*
function remove() {//broken funtion do not use delete value to the hidden type
    var str = Stay("sel");//value select to be delected
    if(str ==="") {
        return;
    }
    var current =document.getElementById("added").innerText;
    var outgoing ="";

    var text =document.getElementById("added").innerText;
    while(text.indexOf("'") !== -1){text = text.replace("'","");}
    while(text.length !==0){
        if(text.includes(",")){
           if(text.substring(0,text.indexOf(",")).trim() === str){
               text = text.substring(text.indexOf(",") + 1);
           }else {
               outgoing += current.substring(text.indexOf(",")+1);
               text = text.substring(text.indexOf(",") + 1).trim();
           }
        }else{
            if(text.trim()===str){
                text ="";
                current = current.substr(0,current.length-1);
            }else{
                outgoing += current;
                text ="";
            }
        }
    }



    //alert(outgoing +" |||| " +str);
    document.getElementById("added").innerText= outgoing;
    resetSelectElement("fun");
}
*/

function Blank() {

}
/*
function addsearchs(sel) {
    var option = document.createElement("option");
    option.text = "";
    sel.add(option);
  var text =document.getElementById("added").innerText;
  while(text.indexOf("'") !== -1){text = text.replace("'","");}
  while(text.length !==0){
      if(text.includes(",")){
          option = document.createElement("option");
          option.text = text.substring(0,text.indexOf(","));
          sel.add(option);
          text = text.substring(text.indexOf(",")+1);
      }else{
          option = document.createElement("option");
          option.text = text;
          sel.add(option);
          text ="";
      }
  }

  return sel;
}
*/
/*
function cmp(sel) {
    var option = document.createElement("option");
    option.text = "";
    sel.add(option);
    var option = document.createElement("option");
    option.text = "not";
    sel.add(option);
    if(document.getElementById("added").innerText.length >0) {
        var option = document.createElement("option");
        option.text = "or";
        sel.add(option);
        var option = document.createElement("option");
        option.text = "and";
        sel.add(option);
    }
    return sel;
}
*/




/*
 var element = document.getElementById("sendReg");

 var but = document.createElement('button');
 but.addEventListener("click", function() {addTo();});
 but.appendChild(document.createTextNode("add another search"));

var select = document.createElement('SELECT');
select = addequals(select);
//var select2 = document.createElement('SELECT');
//select2 = cmp(select2);
select.id = "sel";
//select2.id ="sel2";
element.insertBefore(but,element.childNodes[2]);
//element.insertBefore(select2,element.childNodes[3]);
element.insertBefore(select,element.childNodes[3]);



 */