<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand">Редактирование задачи</a>
    <button class="btn btn-outline-success back-but">Закрыть</button>
  </div>
</nav>
<div class="container-fluid">

    <div class="row col-md-3">
          <div class="mb-3 d-none">
            <label for="name-input" class="form-label">Код записи</label>
            <input type="text" class="form-control" value="<?php if(isset($templateData[0]['id_task'])) echo $templateData[0]['id_task']?>" id="id_task-input">
            </div>
          <div class="mb-3">
            <label for="name-input" class="form-label">Имя</label>
            <input type="text" class="form-control" value="<?php if(isset($templateData[0]['name'])) echo $templateData[0]['name']?>" id="name-input">
          </div>
          <div class="mb-3">
            <label for="email-input" class="form-label">email</label>
            <input type="text" class="form-control" value="<?php if(isset($templateData[0]['email'])) echo $templateData[0]['email']?>" id="email-input">
          </div>
          <div class="mb-3">
            <label for="task-input" class="form-label">Текст задачи</label>
            <input type="text" class="form-control" value="<?php if(isset($templateData[0]['task'])) echo $templateData[0]['task']?>" id="task-input">
          </div>
          <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" <?php if(isset($templateData[0]['ready']) && $templateData[0]['ready']) echo 'checked'?> id="ready" <?php if(!isset($_SESSION['logged'])) echo 'disabled' ?>>
                <label class="form-check-label" for="ready">
                  Выполнено
                </label>
              </div>
          </div>
          <div class="mb-3 d-none">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" <?php if(isset($templateData[0]['edit']) && $templateData[0]['edit']) echo 'checked'?> id="edit" <?php if(!isset($_SESSION['logged'])) echo 'disabled' ?>>
                <label class="form-check-label" for="ready">
                  Отредактировано администратором
                </label>
              </div>
          </div>
          <br>
          <button class="btn btn-primary save-but mx-3 col-6">Сохранить</button>
    </div>

</div>
