<?php 
require_once 'db_mongo.php';

$result_data = [];
$query_type = "";
$options = ['projection' => ['_id' => 0]];

if (isset($_GET['action'])) {
    if ($_GET['action'] === 'lab_by_group') {
        $group = trim($_GET['group_name']);
        $query_type = "Лабораторні роботи для групи: " . htmlspecialchars($group);
        
        $result_data = $collection->find([
            'type' => 'laboratory',
            'groups' => $group
        ], $options)->toArray();
    } 
    elseif ($_GET['action'] === 'lectures_by_teacher') {
        $teacher = trim($_GET['teacher_name']);
        $subject = trim($_GET['subject_name']);
        $query_type = "Лекції викладача " . htmlspecialchars($teacher) . " з дисципліни " . htmlspecialchars($subject);
        
        $result_data = $collection->find([
            'type' => 'lecture',
            'teachers' => $teacher,
            'subject' => $subject
        ], $options)->toArray();
    }
    elseif ($_GET['action'] === 'by_classroom') {
        $classroom = trim($_GET['classroom_number']);
        $query_type = "Розклад для аудиторії: " . htmlspecialchars($classroom);
        
        $result_data = $collection->find([
            'classroom' => $classroom
        ], $options)->toArray();
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Розклад занять (MongoDB)</title>
    <style>
        body { font-family: sans-serif; background: #f0f2f5; padding: 20px; }
        .grid { display: flex; gap: 20px; margin-bottom: 20px; }
        .card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #c9c9c9; color: black; }
        .history { background: #e9ecef; padding: 10px; margin-bottom: 20px; border-left: 4px solid #333; }
        .tag { background: #eee; padding: 2px 6px; border-radius: 4px; margin-right: 5px; font-size: 0.8em; display: inline-block; margin-bottom: 2px; }
        input, select { padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px; display: block; width: 90%; }
        button { padding: 6px 12px; cursor: pointer; background: #007bff; color: white; border: none; border-radius: 4px; width: 100%; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h1>Розклад занять коледжу / університету (NoSQL)</h1>

<div class="grid">
    <div class="card">
        <h3>Лабораторні групи</h3>
        <form method="GET">
            <input type="hidden" name="action" value="lab_by_group">
            <label class="tag">Оберіть групу:</label>
            <select name="group_name" required>
                <?php
                $groups = $collection->distinct('groups');
                foreach ($groups as $g) {
                    $clean_g = trim($g);
                    echo "<option value=\"" . htmlspecialchars($clean_g) . "\">" . htmlspecialchars($clean_g) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Отримати лабораторні</button>
        </form>
    </div>

    <div class="card">
        <h3>Лекції викладача</h3>
        <form method="GET">
            <input type="hidden" name="action" value="lectures_by_teacher">
            <label class="tag">Викладач:</label>
            <select name="teacher_name" required>
                <?php
                $teachers = $collection->distinct('teachers');
                foreach ($teachers as $t) {
                    $clean_t = trim($t);
                    echo "<option value=\"" . htmlspecialchars($clean_t) . "\">" . htmlspecialchars($clean_t) . "</option>";
                }
                ?>
            </select>
            <label class="tag">Дисципліна:</label>
            <select name="subject_name" required>
                <?php
                $subjects = $collection->distinct('subject');
                foreach ($subjects as $s) {
                    $clean_s = trim($s);
                    echo "<option value=\"" . htmlspecialchars($clean_s) . "\">" . htmlspecialchars($clean_s) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Знайти лекції</button>
        </form>
    </div>

    <div class="card">
        <h3>Зайнятість аудиторії</h3>
        <form method="GET">
            <input type="hidden" name="action" value="by_classroom">
            <label class="tag">Аудиторія:</label>
            <select name="classroom_number" required>
                <?php
                $classrooms = $collection->distinct('classroom');
                foreach ($classrooms as $c) {
                    $clean_c = trim($c);
                    echo "<option value=\"" . htmlspecialchars($clean_c) . "\">" . htmlspecialchars($clean_c) . "</option>";
                }
                ?>
            </select>
            <button type="submit">Перевірити аудиторію</button>
        </form>
    </div>
</div>

<div class="history">
    <strong>Останній запит:</strong> <span id="hist_val">немає даних</span>
</div>

<?php if (isset($_GET['action'])): ?>
    <h2>Результати: <?= htmlspecialchars($query_type) ?></h2>
    <?php if (empty($result_data)): ?>
        <p>Нічого не знайдено.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Дата проведення</th>
                <th>Пара (Час)</th>
                <th>Дисципліна</th>
                <th>Тип заняття</th>
                <th>Аудиторія</th>
                <th>Групи</th>
                <th>Викладачі</th>
            </tr>
            <?php foreach ($result_data as $row): ?>
            <tr>
                <td><strong><?= htmlspecialchars($row['date'] ?? 'Не вказано') ?></strong></td>
                <td><?= htmlspecialchars($row['pair'] ?? '0') ?> пара</td>
                <td><?= htmlspecialchars($row['subject'] ?? '—') ?></td>
                <td><?= htmlspecialchars($row['type'] ?? '—') ?></td>
                <td>№ <?= htmlspecialchars($row['classroom'] ?? '—') ?></td>
                <td>
                    <?php if (isset($row['groups']) && (is_array($row['groups']) || is_object($row['groups']))): ?>
                        <?php foreach ($row['groups'] as $g): ?>
                            <span class="tag"><?= htmlspecialchars($g) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span style="color: #aaa;">—</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (isset($row['teachers']) && (is_array($row['teachers']) || is_object($row['teachers']))): ?>
                        <?php foreach ($row['teachers'] as $t): ?>
                            <span class="tag"><?= htmlspecialchars($t) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span style="color: #aaa;">—</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <script>localStorage.setItem('mongo_history', '<?= addslashes($query_type) ?>');</script>
    <?php endif; ?>
<?php endif; ?>

<script>
    const hist = localStorage.getItem('mongo_history');
    if (hist) document.getElementById('hist_val').innerText = hist;
</script>

</body>
</html>