<?php
// Функція валідації
function validateForm($data) {
    $errors = [];
    
    // Валідація імені
    if (empty(trim($data['name'] ?? ''))) {
        $errors['name'] = "Ім'я обов'язкове";
    } elseif (strlen(trim($data['name'])) < 2) {
        $errors['name'] = "Ім'я має бути від 2 символів";
    }
    
    // Валідація email
    if (empty(trim($data['email'] ?? ''))) {
        $errors['email'] = "Email обов'язковий";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Невірний формат email";
    }
    
    // Валідація пароля
    if (empty($data['password'] ?? '')) {
        $errors['password'] = "Пароль обов'язковий";
    } elseif (strlen($data['password']) < 6) {
        $errors['password'] = "Пароль має бути від 6 символів";
    }
    
    return $errors;
}

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = validateForm($_POST);
    
    if (empty($errors)) {
        // Успішна валідація
        echo "<h2>Реєстрація успішна!</h2>";
        echo "<p>Вітаємо, " . htmlspecialchars($_POST['name']) . "!</p>";
    } else {
        // Помилки валідації - показуємо форму знову
        showFormWithErrors($errors, $_POST);
    }
} else {
    // Якщо не POST запит - показуємо пусту форму
    showFormWithErrors([], []);
}

function showFormWithErrors($errors, $oldInput) {
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head>
        <meta charset="UTF-8">
        <title>Реєстрація</title>
    </head>
    <body>
        <h1>Реєстрація</h1>
        <form method="post" action="validate.php">
            <div class="form-group">
                <label>Ім'я:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($oldInput['name'] ?? '') ?>">
                <?php if (isset($errors['name'])): ?>
                    <div class="error"><?= $errors['name'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?= htmlspecialchars($oldInput['email'] ?? '') ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?= $errors['email'] ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label>Пароль:</label>
                <input type="password" name="password">
                <?php if (isset($errors['password'])): ?>
                    <div class="error"><?= $errors['password'] ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit">Зареєструватися</button>
        </form>
    </body>
    </html>
    <?php
}
?>