$(function() {

$("#add_new_author").click( function() {
    var name = $('#add_new_author_name').val();
    var lastname = $('#add_new_author_lastname').val();
    if(name != '') {
        $("#add_new_author_div").append("<label><input name='author[]' value='new:" + name + "," + lastname + "' type='checkbox' checked> " + name + " " + lastname + "</label>");
        $('#add_new_author_name').val('');
        $('#add_new_author_lastname').val('');
    }

});

$("#add_new_cat").click( function() {
    var name = $('#add_new_cat_name').val();
    if(name != '') {
        $("#add_new_cat_div").append("<label><input name='cat[]' value='new:" + name + "' type='checkbox' checked> " + name + "</label>");
        $('#add_new_cat_name').val('');
    }

});

$("#add_new_pub").click( function() {
    var name = $('#add_new_pub_name').val();
    if(name != '') {
        $("#add_new_pub_div").html("<label><input name='pub' value='new:" + name + "' type='radio' checked> " + name + "</label>");
        $('#add_new_pub_name').val('');
    }

});

});