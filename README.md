Инструкция по запуску Лабораторной работы MongoDB
Чтобы всё работало корректно, выполни эти 5 простых шагов.

Шаг 1. Размещение файлов проекта
Распакуй папку с проектом в директорию твоего локального веб-сервера (OpenServer).

Если у тебя новая версия OpenServer (6.0), это папка OSPanel\home.

<img width="643" height="38" alt="image" src="https://github.com/user-attachments/assets/6e7336f6-e3d5-4c02-aaaa-184339321c82" />

Обязательно убедись, что папка проекта называется mongodbsurgdb.local, и внутри неё лежат файлы db_mongo.php, index.php и папка vendor:

<img width="1108" height="343" alt="image" src="https://github.com/user-attachments/assets/d9177574-6d3d-453c-9835-f24fbb85870a" />

Шаг 2. Настройка виртуального хоста (project.ini)
Для того чтобы OpenServer правильно обрабатывал доменное имя проекта, убедись, что в папке с проектом создан конфигурационный файл project.ini со следующим содержимым:

Ini, TOML
[mongodbsurgdb.local]
php_engine = PHP-8.3
public_dir = {base_dir}

Шаг 3. Создание и заполнение базы данных NoSQL
Проект взаимодействует с нереляционной базой данных MongoDB. Для её наполнения:

Запусти утилиту MongoDB Compass и подключись к локальному серверу (mongodb://127.0.0.1:27017).

<img width="1130" height="581" alt="image" src="https://github.com/user-attachments/assets/def7be00-e1d2-449d-bcef-620981a71726" />

Сдесь просто нажимая Save&Connect

Создай новую базу данных с именем dbforlab и коллекцию с именем lessons.

<img width="722" height="556" alt="image" src="https://github.com/user-attachments/assets/ab2e3073-d81b-4998-a2d5-0406d67d44e8" />

<img width="350" height="165" alt="image" src="https://github.com/user-attachments/assets/6f81cef1-6436-4308-a5cb-07934c5dfd67" />

Нажми кнопку Add Data -> Insert Document.

<img width="1072" height="574" alt="image" src="https://github.com/user-attachments/assets/5bf657b3-a7d7-4024-b8c0-b5d210a63741" />

Обязательно переключи режим отображения окна на JSON (иконка {} в правом углу), полностью очисти текстовое поле от шаблонного кода и вставь туда следующий массив документов:

<img width="692" height="449" alt="image" src="https://github.com/user-attachments/assets/d9e6eaaa-b23f-48fa-9956-e65bab665398" />

JSON
```
[
  {
    "date": "2026-06-01",
    "pair": 1,
    "classroom": "404",
    "subject": "Object-Oriented Programming",
    "type": "laboratory",
    "groups": ["КІУКІ-23-1", "КІУКІ-23-2"],
    "teachers": ["Petrov P.P."]
  },
  {
    "date": "2026-06-01",
    "pair": 2,
    "classroom": "301",
    "subject": "Databases",
    "type": "lecture",
    "groups": ["КІУКІ-23-2"],
    "teachers": ["Kovalenko O.M.", "Sidorov S.S."]
  },
  {
    "date": "2026-06-02",
    "pair": 3,
    "classroom": "202",
    "subject": "Web Technologies",
    "type": "laboratory",
    "groups": ["КІУКІ-23-2", "КІУКІ-23-3"],
    "teachers": ["Ivanov I.I."]
  },
  {
    "date": "2026-06-02",
    "pair": 4,
    "classroom": "301",
    "subject": "Databases",
    "type": "laboratory",
    "groups": ["КІУКІ-23-1"],
    "teachers": ["Kovalenko O.M."]
  },
  {
    "date": "2026-06-03",
    "pair": 1,
    "classroom": "505",
    "subject": "Computer Networks",
    "type": "lecture",
    "groups": ["КІУКІ-23-1", "КІУКІ-23-2", "КІУКІ-23-3"],
    "teachers": ["Vasilyev V.V."]
  }
]
```
Нажми Insert. Данные успешно импортируются в систему.

<img width="797" height="787" alt="image" src="https://github.com/user-attachments/assets/cb01375c-065c-40ad-9584-d308b6b29e5b" />

Шаг 4. Запуск веб-приложения
Запусти или перезапусти OpenServer, чтобы сервер применил конфигурацию виртуального хоста. Открой браузер и перейди по ссылке: http://mongodbsurgdb.local.

<img width="549" height="459" alt="image" src="https://github.com/user-attachments/assets/aea6b256-06a4-495a-a8fc-8bc2c5584cde" />

Шаг 5. Проверка работы и результаты запросов
Для отчета поочередно проверь работоспособность всех трех обязательных фильтров выборки:

1. Лабораторные работы выбранной из списка группы
Выбери из списка любую группу (например, КІУКІ-23-1, КІУКІ-23-2 или КІУКІ-23-3) и нажми кнопку поиска. Система должна выдать список занятий, имеющих тип laboratory.

Результат для группы КІУКІ-23-1: Пары №1 (OOP) и №4 (Databases).

Результат для группы КІУКІ-23-2: Пары №1 (OOP) и №3 (Web Technologies).

Результат для группы КІУКІ-23-3: Пара №3 (Web Technologies).

<img width="1915" height="621" alt="image" src="https://github.com/user-attachments/assets/8e59cf31-5e06-4d43-9fdc-f137d84588d1" />

<img width="1919" height="604" alt="image" src="https://github.com/user-attachments/assets/c3b70746-1134-40db-a8cf-3355f43d2b80" />

<img width="1919" height="573" alt="image" src="https://github.com/user-attachments/assets/19fa2b22-4d2d-4f75-8422-b54c78014243" />

2. Лекции указанного преподавателя по указанной дисциплине
Установи в карточке фильтра преподавателя и соответствующий лекционный предмет.

Результат выборки: Система найдет лекционные занятия (тип lecture), где в массиве преподавателей есть выбранное лицо, а название предмета точно совпадает.

<img width="1919" height="595" alt="image" src="https://github.com/user-attachments/assets/f83dcc71-716f-4a8d-b4e4-d792806efde7" />

3. Занятость выбранной аудитории
Выбери номер аудитории из выпадающего списка (например, 202, 301 или 404), чтобы просмотреть все закрепленные за ней занятия независимо от их типа или групп.

Результат для аудитории 202: Найдено занятие по Web Technologies.

Результат для аудитории 301: Найдено два занятия по предмету Databases.

Результат для аудитории 404: Найдено занятие по Object-Oriented Programming.

<img width="1916" height="574" alt="image" src="https://github.com/user-attachments/assets/eaeea4eb-aa52-401d-8131-8704584a7919" />

<img width="1919" height="638" alt="image" src="https://github.com/user-attachments/assets/e4ef5ee1-a396-4a19-8590-760d0f5414a3" />

<img width="1919" height="604" alt="image" src="https://github.com/user-attachments/assets/5369ea5a-f4be-4e11-874c-901039654754" />

<img width="1919" height="611" alt="image" src="https://github.com/user-attachments/assets/39893a23-df5f-4473-b31f-410c70d030ec" />

🛠 Частые ошибки при защите лабы:
Сообщение "Нічого не знайдено": Возникает из-за невидимых пробелов в текстовых полях документов MongoDB Compass. В текущем коде добавлена функция trim(), которая автоматически очищает строки и предотвращает эту ошибку.

Ошибка подключения "Class MongoDB\Client not found": Убедись, что ты не удалил папку vendor или файл composer.json, которые подгружают официальную библиотеку-драйвер для работы с NoSQL базой.
