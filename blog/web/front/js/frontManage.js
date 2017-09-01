/**
 * Created by Administrator on 2017/6/8.
 */

window.onload =  function () {
    loadPage('index.php?p=front&c=Articles&a=getAllArts');
}

//用于实例化编辑器的全局变量
 var loadArtById_ue;
var loadMsgForm_ue;
//加载首页container--》所有文章
function loadPage(url) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;
        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);

}


//根据文章id加载文章
function loadArtById(art_id,art_com_absolute) {
    var xmlhttp = new XMLHttpRequest();
    var url = "?p=front&c=Articles&a=showArtById&art_id="+art_id;

    xmlhttp.onreadystatechange = function () {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;
            if(art_com_absolute==1){
                window.location.hash = "#showArtById_comment_bar";
            }
            else  if(art_com_absolute==0 || art_com_absolute==2){
                window.location.hash = "#container";
            }
            <!-- 实例化编辑器 -->
            if(loadArtById_ue==null){
                loadArtById_ue = UE.getEditor('showArtById_comment_com', {
                    toolbars: [
                        ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                            'insertcode', 'inserthtml', 'link', 'unlink', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                            'touppercase', 'tolowercase', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', 'selectall',
                            'horizontal', 'fontfamily', 'fontsize', 'backcolor', 'forecolor', 'emotion'
                        ]
                    ],
                    // initialFrameWidth: 450,//设置编辑器宽度
                    // initialFrameHeight: 300,//设置编辑器高度
                    scaleEnabled: true    //滚动条
                });
            }
            else{
                loadArtById_ue.render('showArtById_comment_com');
            }

        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);
}


//提交评论表单动作

function submitCommentForm() {
    var com_art_id = document.getElementById('hid_art_id').value;
    var com_uname = document.getElementById('showArtById_comment_uname').value;
    var com_content = loadArtById_ue.getContent();

    if(com_content == null || com_content==''){
        alert("请输入评论内容！");
        document.getElementById('showArtById_comment_com').focus();
        return;
    }
    var postData = "com_art_id="+com_art_id+"&com_uname="+encodeURIComponent(com_uname)+"&com_content="+encodeURIComponent(com_content);
    var xmlhttp2 = new XMLHttpRequest();
    var url2 = "?p=front&c=Articles&a=insert_com";
    xmlhttp2.onreadystatechange = function () {

        if(xmlhttp2.readyState == 4 && xmlhttp2.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp2.responseText;
            if(loadArtById_ue==null){
                loadArtById_ue = UE.getEditor('showArtById_comment_com', {
                    toolbars: [
                        ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                            'insertcode', 'inserthtml', 'link', 'unlink', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                            'touppercase', 'tolowercase', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', 'selectall',
                            'horizontal', 'fontfamily', 'fontsize', 'backcolor', 'forecolor', 'emotion'
                        ]
                    ],
                    // initialFrameWidth: 450,//设置编辑器宽度
                    // initialFrameHeight: 300,//设置编辑器高度
                    scaleEnabled: true    //滚动条
                });
            }
            else{
                loadArtById_ue.render('showArtById_comment_com');
            }

        }
    }
    xmlhttp2.open('post',url2,false);
    xmlhttp2.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xmlhttp2.send(postData);
}



//最新评论之根据文章id获取文章
function newLoadArtById(e){

    var xmlhttp = new XMLHttpRequest();
   var art_id = e.children[0].value;
    var url = "?p=front&c=Articles&a=showArtById&art_id="+art_id;

    xmlhttp.onreadystatechange = function () {
        if(xmlhttp.readyState == 4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;

            <!-- 实例化编辑器 -->
            if(loadArtById_ue == null){
                loadArtById_ue = UE.getEditor('showArtById_comment_com', {
                    toolbars: [
                        ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                            'insertcode', 'inserthtml', 'link', 'unlink', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                            'touppercase', 'tolowercase', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', 'selectall',
                            'horizontal', 'fontfamily', 'fontsize', 'backcolor', 'forecolor', 'emotion'
                        ]
                    ],
                    // initialFrameWidth: 450,//设置编辑器宽度
                    // initialFrameHeight: 300,//设置编辑器高度
                    scaleEnabled: true    //滚动条
                });
            }
            else{
                loadArtById_ue.render('showArtById_comment_com');
            }

        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);
}



//文章搜索列表


function search_arts() {
    var search_text = document.getElementById('art_search').value;
    var url = "?p=front&c=Articles&a=art_search&art_key="+search_text;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function () {
        if(xmlhttp.readyState==4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;
        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);
}


/**
 * 根据文章分类id列出对应文章列表
 */

function getCagArts(hid_text) {
    var hid_cag_id = hid_text.value;
    var url = "?p=front&c=Articles&a=getCagArs&cag_id="+hid_cag_id;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function () {
        if(xmlhttp.readyState==4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;
        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);
}



/**
 * 加载留言表单
 */

function loadMsgForm() {

    var url = "?p=front&c=Message&a=loadMsgForm";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function () {
        if(xmlhttp.readyState==4 && xmlhttp.status ==200){
            document.getElementById('middle').innerHTML = "<br/>"+xmlhttp.responseText;
            if(loadMsgForm_ue == null){
                loadMsgForm_ue = UE.getEditor('leave_message_content', {
                    toolbars: [
                        ['fullscreen', 'source', '|', 'undo', 'redo', '|',
                            'insertcode', 'inserthtml', 'link', 'unlink', 'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                            'touppercase', 'tolowercase', 'lineheight', '|', 'insertorderedlist', 'insertunorderedlist', 'selectall',
                            'horizontal', 'fontfamily', 'fontsize', 'backcolor', 'forecolor', 'emotion'
                        ]
                    ],
                    // initialFrameWidth: 600,//设置编辑器宽度
                    // initialFrameHeight: 400,//设置编辑器高度
                    scaleEnabled: true    //滚动条
                });
            }else{
                loadMsgForm_ue.render('leave_message_content');
            }
        }
    }
    xmlhttp.open('get',url,false);
    xmlhttp.send(null);
}

/**
 * 留言文本插入数据库
 */

function submitMessageForm() {
    var leave_msg_uname = document.getElementById('leave_message_uname').value;
    var leave_msg_content = loadMsgForm_ue.getContent();
    var postData = "msg_name="+encodeURIComponent(leave_msg_uname)+"&msg_content="+encodeURIComponent(leave_msg_content);
    if(leave_msg_uname == null || leave_msg_uname==''){
        alert("请输入名称！");
        return;
    }
    else if(leave_msg_content== null || leave_msg_content==''){
        alert("请输入留言内容");
        return;
    }

    var xmlhttp2 = new XMLHttpRequest();
    var url2 = "?p=front&c=Message&a=insert_msg";
    xmlhttp2.onreadystatechange = function () {

        if(xmlhttp2.readyState == 4 && xmlhttp2.status ==200){
            alert("留言成功！");
            loadPage('index.php?p=front&c=Articles&a=getAllArts');

        }
    }
    xmlhttp2.open('post',url2,true);
    xmlhttp2.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xmlhttp2.send(postData);

}











