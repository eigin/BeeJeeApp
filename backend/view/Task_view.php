<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand">Список задач</a>
    <button class="btn btn-outline-success <?php echo isset($_SESSION['logged']) ? 'logout-but' : 'login-but' ?>"><?php echo isset($_SESSION['logged']) ? 'Выйти' : 'Авторизоваться' ?></button>
  </div>
</nav>
<table class="table">
  <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Имя</th>
        <th scope="col">Email</th>
        <th scope="col">Текст задачи</th>
        <th scope="col">Выполнено</th>
        <th scope="col">Отредактир. админ.</th>
        <th scope="col"></th>
      </tr>
      <tr>
          <?php
            $html = '';
            $array_keys = array_keys($templateData[0][0]);
            foreach ($array_keys as $value) {
                $checked = $templateData[1]['order_by'] == $value ? 'checked' : '';
                $html .= '<th scope="col">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input getpage" type="radio" name="inlineRadioOptions" value="' . $value . '" ' . $checked . '>
                      <label class="form-check-label" for="' . $value . '"></label>
                    </div>
                </th>';
            }
            echo $html;
          ?>
        <th scope="col"></th>
      </tr>
  </thead>
  <tbody>
      <?php
          $html = '';
          foreach($templateData[0] as $row)
            {
                $ready = '<div class="form-check">
                    <input class="form-check-input" type="checkbox" ' .
                    ($row['ready'] ? 'checked' : '') . ' id="ready' . $row['id_task'] . '" disabled></div>';
                $edit = '<div class="form-check">
                    <input class="form-check-input" type="checkbox" ' .
                    ($row['edit'] ? 'checked' : '') . ' id="edit' . $row['id_task'] . '" disabled></div>';
                $disabled = !isset($_SESSION['logged']) ? 'disabled' : '';
                $html .= '<tr><th scope="row">' . $row['id_task'] . '</th><td>' . $row['name'] .
                    '</td><td>' . $row['email'] . '</td><td>' . $row['task'] . '</td><td>' .
                    $ready . '</td><td>' . $edit . '</td><td>
                    <button data-key="' . $row['id_task'] .
                    '" ' . $disabled . ' type="button" class="btn btn-outline-primary upd btn-sm">изменить</button></td></tr>';
            }
          echo $html;
       ?>
  </tbody>
</table>

<div class="container-fluid text-center <?php if (count($templateData[0]) < 3 && !$templateData[1]['page_num']) echo 'd-none'; ?>">
    
    <div class="btn-group mx-5" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check getpage" name="btnradio2" id="asc-btn" value="ASC" autocomplete="off" <?php if($templateData[1]['direction'] == 'ASC') echo 'checked' ?> >
      <label class="btn btn-outline-primary" for="asc-btn">По возрастанию</label>
    
      <input type="radio" class="btn-check getpage" name="btnradio2"  id="desc-btn" value="DESC" autocomplete="off" <?php if($templateData[1]['direction'] == 'DESC') echo 'checked' ?> >
      <label class="btn btn-outline-primary" for="desc-btn">По убыванию</label>
    </div>    
    
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
      <?php
          // количество страниц и номер текущей
          $page_num = $templateData[1]['first_rec'] ? $templateData[1]['first_rec'] / 3 : 0;
          $count_page = ceil($templateData[1]['count_rec'] / 3);
          $html = '';
          // вывод пагинатора
          for ($i = 0; $i < $count_page; $i++) {
              $checked = $page_num == $i ? 'checked' : '';
              $html .= '<input type="radio" class="btn-check getpage" name="btnradio" value="' . ($i + 1) .
              '" autocomplete="off" ' . $checked . ' id="but' . ($i + 1)  .
              '"><label class="btn btn-outline-primary" for="but' . ($i + 1)  . '">' . ($i + 1) . '</label>';
          }
          echo $html;
       ?>
    </div>
    <button type="button" class="btn btn-primary add-but mx-5">Добавить задачу</button>
    
</div>
