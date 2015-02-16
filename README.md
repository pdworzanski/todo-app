# todo-by-przemo

####Instalation
1. Composer
```
composer install|update
```
2. Create database
3. Update DB schema
```
vendor/bin/doctrine orm:schema-tool:update --dump-sql --force
```

####Usage

- Add task
```
php todo.php add "Read the book @tomorrow"
```
- Remove task
```
php todo.php remove <task_id>
```
- Mark task as done|undone
```
php todo.php set <task_id> done|undone
```
- Show all tasks with optional filter by date
```
php todo.php show
php todo.php show @tomorow
php todo.php show @thursday
```



