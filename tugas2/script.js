let todoList = [];

function addTodo() {
    const todoInput = document.getElementById('todo-input').value;
    if (todoInput.trim() !== '') {
        todoList.push({ text: todoInput, isEditing: false });
        document.getElementById('todo-input').value = '';
        renderTodoList();
    }
}

function renderTodoList() { 
    const todoUl = document.getElementById('todo-list');
    todoUl.innerHTML = '';
    todoList.forEach((todo, index) => {
        const li = document.createElement('li');
        
        if (todo.isEditing) {
            const editInput = document.createElement('input');
            editInput.value = todo.text;
            editInput.onchange = (e) => todo.text = e.target.value;
            li.appendChild(editInput);
        } else {
            const todoText = document.createElement('span');
            todoText.textContent = todo.text;
            li.appendChild(todoText);
        }

        const editBtn = document.createElement('button');
        editBtn.textContent = todo.isEditing ? 'Save' : 'Edit';
        editBtn.className = 'edit-btn';
        editBtn.onclick = () => toggleEdit(index);
        li.appendChild(editBtn);

        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Delete';
        deleteBtn.className = 'delete-btn';
        deleteBtn.onclick = () => deleteTodo(index);
        li.appendChild(deleteBtn);

        todoUl.appendChild(li);
    });
}

function deleteTodo(index) {
    todoList.splice(index, 1);
    renderTodoList();
}

function toggleEdit(index) {
    todoList[index].isEditing = !todoList[index].isEditing;
    renderTodoList();
}