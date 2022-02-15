/**
 *	JS script for BeeJeeTest app
 *  @author @eigins
 */


// отправить запрос и вывести результат
 function sendRequest (controller, method, param) {
     $.post( 'index.php', { c: controller, m: method, param: param },
         (data)=> {
             console.log('data:',data);
             let result = data;
             try {
             // если сообщение об ошибке
                result = JSON.parse(result);
                if (!confirm(result.msg)) {
                  document.location='/';
                }
             } catch (err) {
             // если нужен рендеринг
               $('.sub-view').html(data);
             }
         }
     );
 }


 // кнопки пагинации, сортировки и направления сортировки
 $(document).on("click", ".getpage", (e)=> {
     let page_num = $('input[name="btnradio"]:checked').val();
     let order_by = $('input[name="inlineRadioOptions"]:checked').val();  
     let direction = $('input[name="btnradio2"]:checked').val();
     let param = { page_num: page_num, order_by: order_by, direction: direction }
     sendRequest('Task', 'getPage', param);
  });


  // форма авторизации
  $(document).on("click", ".login-but", (e)=> {
      sendRequest('Users', 'showLoginForm', {});
   });


   // разлогиниться
   $(document).on("click", ".logout-but", (e)=> {
       sendRequest('Users', 'logout', {});
       document.location='/';
    });


    // форма добавления
    $(document).on("click", ".add-but", (e)=> {
        sendRequest('Task', 'showEditTaskForm', {});
    });


    // форма редактирования
    $(document).on("click", ".upd", (e)=> {
        let id_task = $(e.target).data('key')*1;
        sendRequest('Task', 'showEditTaskForm', {id_task: id_task});
    });

    // форма редактирования
    $(document).on("change", "#task-input", (e)=> {
        $('#edit').prop('checked', true);
    });



    // кнопка сохранения записи
    $(document).on("click", ".save-but", (e)=> {
        let id_task = $('#id_task-input').val();
        let name = $('#name-input').val();
        let email = $('#email-input').val();
        let task = $('#task-input').val();
        let ready = $('#ready').prop('checked')*1;
        let edit = $('#edit').prop('checked')*1;
        let param = { id_task: id_task, name: name, email: email, task: task, ready: ready, edit: edit }
        sendRequest('Task', 'saveTask', param);
     });


   // кнопка проверки авторизации
   $(document).on("click", ".login-auth", (e)=> {
       let login = $('#login-input').val();
       let password = $('#password-input').val();
       let param = { login: login, password: password }
       sendRequest('Users', 'login', param);
    });


   // кнопка отмена (на главную)
   $(document).on("click", ".back-but", (e)=> {
       document.location='/';
    });


