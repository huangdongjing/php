/**
 * Created by Administrator on 2017/5/31.
 */
var flag = true;
var text = "";
function editCag(e) {
    if(flag) {
        var e1 = e.children[0];
        text = e1.innerHTML;
        e1.innerHTML = "";
        //alert(text);
        window.cag_id = e.children[1].children[0].value;

        var str = "<form action='index.php?p=back&c=Articles&a=edit_cag'  method='post' onsubmit='return check_reg_null();'> <input id='recag' type='text' name='cag_rename' value='" + text + "'> <input type='submit' value='保存'> <input type='button' onclick='cancel(this.parentNode.parentNode)' value='取消'></form>"
        e1.innerHTML += str;

        flag = false;
    }
}
function cancel(ecancel) {
    ecancel.innerHTML = text;
    flag = true;
}
function check_null() {
    var cag = document.getElementById("category");
    if(cag.value == null || cag.value == ""){
        cag.focus();
        return false;
    }
    else return true;
}
function check_reg_null(){
    var text_recag = document.getElementById('recag').value;
    if(text_recag == null || text_recag == ""){
        document.getElementById('recag').focus();
        return false;

    }
    else
    {
       document.getElementById('recag').value = window.cag_id+","+text_recag;
       // alert(document.getElementById('recag').value);
        return true;
    }
}
