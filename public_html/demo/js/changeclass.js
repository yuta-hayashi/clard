var classname = getCookie('class');
document.getElementById("changeclass").value = classname;

document.getElementById("changeclass").onchange = function(){
	classname = changeclass.value;
	document.cookie = 'class=' + classname;
	location.href = "./";
};

//クッキー読み込み
function getCookie(c_name){
    var st="";
    var ed="";
    if(document.cookie.length>0){
        // クッキーの値を取り出す
        st=document.cookie.indexOf(c_name + "=");
        if(st!=-1){
            st=st+c_name.length+1;
            ed=document.cookie.indexOf(";",st);
            if(ed==-1) ed=document.cookie.length;
            // 値をデコードして返す
            return unescape(document.cookie.substring(st,ed));
        }
    }
    return "3I";
}