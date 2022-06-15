<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
      .th-100{
        min-width:100px!important;
        max-width:100px!important;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">
                  Todo list
                </h1>
            </div>
            <div id="todoListPanel" class="col-12">
              <form id="todoListForm">
                <div class="input-group">
                  <input id="TaskValue" placeholder="Ingrese alguna tarea." type="text" class="form-control">
                  <button type="button" class="btn btn-success btn-sm" onclick="newTask()">Aceptar</button>
                </div>
              </form>
            </div>
            <div id="todoListTask" class="col-12 mt-5">
              <table id="todoListTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Tareas</th>
                    <th class="th-100 text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="todoListTableBody">
                  <tr>
                    <th colspan="2">
                      No hay tareas para mostrar.
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script>
      let todoListForm = document.getElementById('todoListForm');
      let todoListTableBody = document.getElementById('todoListTableBody');

      window.addEventListener('load', printTable);

      function printTable(){
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'todo.php', true);
        
        ajax.onreadystatechange = function(){
          if(ajax.readyState === 4){
            let data = JSON.parse(ajax.responseText);
            
            let html = '<tr><th colspan="2">No hay tareas para mostrar.</th></tr>';

            if(data && data.length > 0){
              html = '';
              for(let id in data){
                html += '<tr>';
                  html += '<td>';
                  html += '<span id="task'+id+'">'+data[id]+'</span><input id="taskInput'+id+'" class="form-control d-none" value="'+data[id]+'"/>';
                  html += '</td>';
                  html += '<td class="th-100">';
                  html += '<div class="input-group">';
                  html += '<button id="btnEdit'+id+'" class="btn btn-sm btn-info text-white" onclick="editTask('+id+')">Editar</button>';
                  html += '<button id="btnSave'+id+'" class="btn btn-sm btn-success text-white d-none" onclick="saveTask('+id+')">Guardar</button>';
                  html += '<button class="btn btn-sm btn-danger" onclick="deleteTask('+id+')">Eliminar</button>';
                  html += '</div>';
                  html += '</td>';
                html += '</tr>';
              }
            }

            todoListTableBody.innerHTML = html;
          }
        };

        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({method: 'GET_LIST'}));
      }
      
      function editTask(TaskId) {
        let task = document.getElementById('task' + TaskId);
        let taskInput = document.getElementById('taskInput' + TaskId);
        let btnEdit = document.getElementById('btnEdit' + TaskId);
        let btnSave = document.getElementById('btnSave' + TaskId);

        task.classList.add('d-none');
        btnEdit.classList.add('d-none');

        taskInput.classList.remove('d-none');
        btnSave.classList.remove('d-none');
      }
      
      function saveTask(TaskId) {
        let task = document.getElementById('task' + TaskId);
        let taskInput = document.getElementById('taskInput' + TaskId);
        let btnEdit = document.getElementById('btnEdit' + TaskId);
        let btnSave = document.getElementById('btnSave' + TaskId);

        taskInput.classList.add('d-none');
        btnSave.classList.add('d-none');

        task.classList.remove('d-none');
        btnEdit.classList.remove('d-none');
        
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'todo.php', true);
        
        ajax.onreadystatechange = function(){
          if(ajax.readyState === 4){
            printTable();
          }
        };

        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({method: 'EDIT_TASK', id: TaskId, task: taskInput.value}));
      }

      function newTask() {
        let taskValue = document.getElementById('TaskValue').value;

        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'todo.php', true);
        
        ajax.onreadystatechange = function(){
          if(ajax.readyState === 4){
            printTable();
          }
        };

        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({method: 'NEW_TASK', task: taskValue}));
      }

      function deleteTask(TaskId) {
        let ajax = new XMLHttpRequest();
        ajax.open('POST', 'todo.php', true);
        
        ajax.onreadystatechange = function(){
          if(ajax.readyState === 4){
            printTable();
          }
        };

        ajax.setRequestHeader("Content-Type", "application/json");
        ajax.send(JSON.stringify({method: 'DELETE_TASK', id: TaskId}));
      }
    </script>
  </body>
</html>