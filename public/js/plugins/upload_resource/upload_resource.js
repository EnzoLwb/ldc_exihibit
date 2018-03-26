/**
 * Created by Administrator on 2017/10/16.
 */
function upload_resource(title,uploaded_type,id,type){
    var now_num=$('#'+id).children().length;
    var url = "/admin/file/file/upload_resource_html/" + uploaded_type+"/"+id+"/"+type+"/"+now_num;
    layer.open({
        title: title,
        type: 2,
        area: ['800px', '480px'],
        fix: true, //固定
        maxmin: false,
        move: false,
        resize: false,
        zIndex: 1,
        content: url
    });
}

function del_img($this){
    console.log($(this));
    $this.parent().remove();
}