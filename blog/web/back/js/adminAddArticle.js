/**
 * Created by Administrator on 2017/5/22.
 */
var cag_flag = false;
function fill_cag_text() {
    var elements = document.getElementsByName("checkbox");
    var art_cag = document.getElementById("article_category");
    art_cag.value = "";
    for(var i=0;i<elements.length;i++){
        if(elements[i].checked){
            var text = elements[i].value;
            art_cag.value =art_cag.value+text+",";
        }
    }
}
function art_add_check() {
    var title = document.getElementById('article_title').value;
    var category = document.getElementById('article_category').value;
    var content =  ue.getContent();
    if(title == null || title ==''){
        alert("文章标题不能为空");
        return false;
    }
    else if(category == null || category ==''){
        alert("文章类别不能为空");
        return false;
    }
    else if(content == null || content ==''){
        alert("文章内容不能为空");
        return false;
    }
    return true;
}



