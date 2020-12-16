// Ajax запросы для кнопок "Добавить", "Изменить" и "Удалить" элемент
// Отображение форм для заполнения

function add_new_elem_form(event) {
  btn = event.target;
  id = btn.id;
  parent_id = id.replace('new_elem_btn_', '');
  new_form = document.getElementById('new_elem_frm_' + parent_id);
  
  if(new_form.style.display == 'none'){
    new_form.style.display = 'block';
    btn.innerHTML = 'Отменить';
  }
  else {
    new_form.style.display = 'none';
    btn.innerHTML = 'Добавить элемент';
  }
};

function add_new_elem(event) {
  id = event.target.id;
  parent_id = id.replace('new_elem_sbm_', '');
  
  input_name = document.getElementById('new_elem_txt_' + parent_id).value;
  input_details = document.getElementById('new_elem_dtl_' + parent_id).value;
  
  data = 'action=add&parent_id=' + parent_id + '&name=' + input_name + '&details=' + input_details;
  
  ajax('add_element', data);
}

function edit_elem(event) {
  id = event.target.id;
  id = id.replace('edit_elem_sbm_', '');
  
  input_name = document.getElementById('edit_elem_txt_' + parent_id).value;
  input_details = document.getElementById('edit_elem_dtl_' + parent_id).value;
  
  data = 'action=edit&id=' + id + '&name=' + input_name + '&details=' + input_details;
  
  ajax('edit_element', data);
}

function edit_elem_form(event) {
  btn = event.target;
  id = btn.id;
  parent_id = id.replace('edit_elem_btn_', '');
  edit_form = document.getElementById('edit_elem_frm_' + parent_id);
  
  if(edit_form.style.display == 'none'){
    edit_form.style.display = 'block';
    btn.innerHTML = 'Отменить';
  }
  else {
    edit_form.style.display = 'none';
    btn.innerHTML = 'Изменить';
  }
}

function del_elem(id) {
  data = 'action=del&id=' + id;
  
  ajax('del_element', data);
}
